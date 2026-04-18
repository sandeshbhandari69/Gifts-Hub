<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendOtpMail;
use Carbon\Carbon;

class TestOtpCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:otp {email?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test OTP sending functionality';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        
        if (!$email) {
            $user = User::first();
            if (!$user) {
                $this->error('No users found in database');
                return 1;
            }
            $email = $user->email;
        } else {
            $user = User::where('email', $email)->first();
            if (!$user) {
                $this->error('User not found with email: ' . $email);
                return 1;
            }
        }

        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        
        try {
            // Update user with OTP
            $user->otp = $otp;
            $user->otp_expires_at = Carbon::now()->addMinutes(5);
            $user->save();
            
            // Send OTP email
            Mail::to($user->email)->send(new SendOtpMail($otp));
            
            $this->info('OTP sent successfully!');
            $this->info('Email: ' . $user->email);
            $this->info('OTP: ' . $otp);
            $this->info('Expires at: ' . $user->otp_expires_at);
            
            return 0;
            
        } catch (\Exception $e) {
            $this->error('Error sending OTP: ' . $e->getMessage());
            return 1;
        }
    }
}

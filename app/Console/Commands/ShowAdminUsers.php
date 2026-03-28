<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class ShowAdminUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:show-admin-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show all users and their roles';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('All Users and Their Roles:');
        $this->info('================================');
        
        $users = User::all(['email', 'role', 'name']);
        
        foreach ($users as $user) {
            $role = $user->role ?? 'null';
            $status = $role === 'admin' ? '🔑 ADMIN' : '👤 USER';
            $this->line("{$user->email} - {$user->name} - Role: {$role} {$status}");
        }
        
        $this->info('================================');
        $this->info('Admin users count: ' . User::where('role', 'admin')->count());
        $this->info('Total users count: ' . User::count());
        
        return 0;
    }
}

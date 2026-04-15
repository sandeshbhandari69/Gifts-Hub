<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Auth;
use App\Mail\SendOtpMail;
use Carbon\Carbon;

class OtpVerificationController extends Controller
{
    /**
     * Show the OTP request form
     */
    public function showOtpForm()
    {
        return view('auth.otp-request');
    }

    /**
     * Send OTP to user's email
     */
    public function sendOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ], [
            'email.exists' => 'This email is not registered in our system.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        // Rate limiting: max 3 OTP requests per minute per email
        $key = 'otp-request:' . $request->email;
        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);
            return response()->json([
                'success' => false,
                'message' => 'Too many OTP requests. Please try again in ' . $seconds . ' seconds.'
            ], 429);
        }

        RateLimiter::hit($key, 60); // 60 seconds decay

        try {
            $user = User::where('email', $request->email)->first();
            
            // Generate 6-digit OTP
            $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            
            // Set expiry time (5 minutes)
            $expiresAt = Carbon::now()->addMinutes(5);
            
            // Save OTP and expiry to database
            $user->otp = $otp;
            $user->otp_expires_at = $expiresAt;
            $user->save();
            
            // Send OTP via email (synchronously for immediate delivery)
            Mail::to($user->email)->send(new SendOtpMail($otp));
            
            // Store email in session for verification step
            session(['otp_email' => $request->email]);
            
            return response()->json([
                'success' => true,
                'message' => 'OTP has been sent to your email address.',
                'redirect' => route('otp.verify.form')
            ]);
            
        } catch (\Exception $e) {
            \Log::error('OTP sending failed: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to send OTP. Please try again.'
            ], 500);
        }
    }

    /**
     * Show the OTP verification form
     */
    public function showVerifyForm()
    {
        $email = session('otp_email') ?? session('pending_login_email');
        
        if (!$email) {
            return redirect()->route('otp.request.form')
                ->with('error', 'Please request an OTP first.');
        }
        
        // Store email in otp_email session for consistency
        if (!session('otp_email')) {
            session(['otp_email' => $email]);
        }
        
        return view('auth.otp-verify', [
            'email' => $email
        ]);
    }

    /**
     * Verify OTP entered by user
     */
    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'otp' => 'required|string|size:6',
        ], [
            'otp.size' => 'OTP must be exactly 6 digits.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        // Rate limiting: max 5 verification attempts per minute per IP
        $key = 'otp-verify:' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            return response()->json([
                'success' => false,
                'message' => 'Too many verification attempts. Please try again in ' . $seconds . ' seconds.'
            ], 429);
        }

        RateLimiter::hit($key, 60);

        try {
            $email = session('otp_email') ?? session('pending_login_email');
            
            // Debug logging
            \Log::info('OTP Verification Attempt:', [
                'otp_email' => session('otp_email'),
                'pending_login_email' => session('pending_login_email'),
                'final_email' => $email,
                'request_otp' => $request->otp
            ]);
            
            if (!$email) {
                return response()->json([
                    'success' => false,
                    'message' => 'Session expired. Please request a new OTP.'
                ], 400);
            }

            $user = User::where('email', $email)->first();
            
            if (!$user) {
                \Log::error('User not found for email: ' . $email);
                return response()->json([
                    'success' => false,
                    'message' => 'User not found.'
                ], 404);
            }
            
            // Debug user OTP data
            \Log::info('User OTP Data:', [
                'user_id' => $user->id,
                'user_email' => $user->email,
                'stored_otp' => $user->otp,
                'stored_expires_at' => $user->otp_expires_at,
                'request_otp' => $request->otp,
                'current_time' => Carbon::now(),
                'is_expired' => $user->otp_expires_at ? Carbon::now()->gt($user->otp_expires_at) : 'no expiry set'
            ]);

            if (!$user->otp || !$user->otp_expires_at) {
                \Log::error('OTP data missing for user: ' . $user->email);
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid OTP request. Please request a new OTP.'
                ], 400);
            }

            // Check if OTP has expired
            if (Carbon::now()->gt($user->otp_expires_at)) {
                \Log::info('OTP expired for user: ' . $user->email);
                // Clear expired OTP
                $user->otp = null;
                $user->otp_expires_at = null;
                $user->save();
                
                return response()->json([
                    'success' => false,
                    'message' => 'OTP has expired. Please request a new OTP.'
                ], 400);
            }

            // Verify OTP
            if ($user->otp !== $request->otp) {
                \Log::warning('OTP mismatch for user: ' . $user->email . '. Expected: ' . $user->otp . ', Got: ' . $request->otp);
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid OTP. Please check and try again.'
                ], 400);
            }

            // Clear OTP after successful verification
            $user->otp = null;
            $user->otp_expires_at = null;
            $user->save();

            // Clear session
            session()->forget('otp_email');
            
            // Check if this is part of login process
            if (session('pending_login_user_id')) {
                // Complete the login process
                Auth::login($user);
                $request->session()->regenerate();
                
                // Clear pending login session
                session()->forget('pending_login_user_id');
                session()->forget('pending_login_email');
                
                // Mark email as verified if not already verified
                if (!$user->email_verified_at) {
                    $user->email_verified_at = Carbon::now();
                    $user->save();
                }

                return response()->json([
                    'success' => true,
                    'message' => 'Login successful! OTP verified.',
                    'redirect' => route('user.dashboard')
                ]);
            } else {
                // Standalone OTP verification
                // Mark email as verified if not already verified
                if (!$user->email_verified_at) {
                    $user->email_verified_at = Carbon::now();
                    $user->save();
                }

                return response()->json([
                    'success' => true,
                    'message' => 'OTP verified successfully!',
                    'redirect' => route('home')
                ]);
            }
            
        } catch (\Exception $e) {
            \Log::error('OTP verification failed: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Verification failed. Please try again.'
            ], 500);
        }
    }

    /**
     * Resend OTP
     */
    public function resendOtp(Request $request)
    {
        $email = session('otp_email') ?? session('pending_login_email');
        
        if (!$email) {
            return response()->json([
                'success' => false,
                'message' => 'Session expired. Please request a new OTP.'
            ], 400);
        }

        // Rate limiting: max 1 resend per minute per email
        $key = 'otp-resend:' . $email;
        if (RateLimiter::tooManyAttempts($key, 1)) {
            $seconds = RateLimiter::availableIn($key);
            return response()->json([
                'success' => false,
                'message' => 'Please wait ' . $seconds . ' seconds before requesting another OTP.'
            ], 429);
        }

        RateLimiter::hit($key, 60);

        try {
            $user = User::where('email', $email)->first();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found.'
                ], 404);
            }

            // Generate new OTP
            $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            $expiresAt = Carbon::now()->addMinutes(5);
            
            // Update OTP and expiry
            $user->otp = $otp;
            $user->otp_expires_at = $expiresAt;
            $user->save();
            
            // Send OTP via email (synchronously for immediate delivery)
            Mail::to($user->email)->send(new SendOtpMail($otp));
            
            return response()->json([
                'success' => true,
                'message' => 'New OTP has been sent to your email address.'
            ]);
            
        } catch (\Exception $e) {
            \Log::error('OTP resend failed: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to resend OTP. Please try again.'
            ], 500);
        }
    }
}

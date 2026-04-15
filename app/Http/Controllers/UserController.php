<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function register()
    {
        return view('register');
    }

    public function register1()
    {
        return view('register1');
    }

    //user dashboard method
    
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to access dashboard.');
        }
        
        $user = Auth::user();
        $recentOrders = Order::where('user_id', $user->id)
                            ->orderBy('created_at', 'desc')
                            ->take(5)
                            ->get();
        
        $orderStats = [
            'total_orders' => Order::where('user_id', $user->id)->count(),
            'processing_orders' => Order::where('user_id', $user->id)->where('status', 'processing')->count(),
            'completed_orders' => Order::where('user_id', $user->id)->where('status', 'delivered')->count(),
            'total_spent' => Order::where('user_id', $user->id)->sum('total')
        ];
        
        // Get additional dashboard data
        $wishlistCount = Wishlist::where('user_id', $user->id)->count();
        
        // Get recent activity (last 5 orders with their status)
        $recentActivity = Order::where('user_id', $user->id)
                              ->orderBy('created_at', 'desc')
                              ->take(3)
                              ->get()
                              ->map(function($order) {
                                  return [
                                      'type' => 'order',
                                      'description' => 'Order #' . $order->order_id . ' placed',
                                      'status' => $order->status,
                                      'date' => $order->created_at->diffForHumans(),
                                      'icon' => 'fa-shopping-bag',
                                      'color' => $this->getActivityColor($order->status)
                                  ];
                              });
        
        // Add wishlist activity if user has items
        if ($wishlistCount > 0) {
            $recentActivity->push([
                'type' => 'wishlist',
                'description' => $wishlistCount . ' items in wishlist',
                'status' => 'active',
                'date' => 'Updated recently',
                'icon' => 'fa-heart',
                'color' => 'text-danger'
            ]);
        }
        
        return view('user.index', compact('user', 'recentOrders', 'orderStats', 'wishlistCount', 'recentActivity'));
    }
    
    private function getActivityColor($status)
    {
        return match($status) {
            'processing' => 'text-secondary',
            'shipped' => 'text-info',
            'delivered' => 'text-success',
            'cancelled' => 'text-danger',
            'on_the_way' => 'text-primary',
            default => 'text-warning'
        };
    }

    public function history()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to access order history.');
        }
        
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)
                        ->orderBy('created_at', 'desc')
                        ->paginate(10);
        
        return view('user.order-history', compact('user', 'orders'));
    }

    public function detail($orderId)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to view order details.');
        }
        
        $user = Auth::user();
        
        // Only find orders that belong to the current user
        $order = Order::where('user_id', $user->id)
                     ->where('order_id', $orderId)
                     ->first();
        
        // If no order found for this user, show 404
        if (!$order) {
            abort(404, 'Order not found.');
        }
        
        return view('user.detail', compact('user', 'order'));
    }
    
    public function settings()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to access settings.');
        }
        
        $user = Auth::user();
        return view('user.settings', compact('user'));
    }
    
    public function updateProfile(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to update profile.');
        }
        
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
        ]);
        
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);
        
        return back()->with('success', 'Profile updated successfully!');
    }
    
    public function updatePassword(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to update password.');
        }
        
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:6|confirmed',
        ]);
        
        $user = Auth::user();
        
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Current password is incorrect!');
        }
        
        $user->update([
            'password' => Hash::make($request->password),
        ]);
        
        return back()->with('success', 'Password updated successfully!');
    }
    
    public function wishlist()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to view wishlist.');
        }
        
        $user = Auth::user();
        $wishlists = Wishlist::where('user_id', $user->id)->get();
        
        return view('user.wishlist', compact('user', 'wishlists'));
    }

    public function registerPost(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        // Store registration data in session
        session([
            'pending_registration' => [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'user'
            ]
        ]);

        // Generate and send OTP
        try {
            $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            $expiresAt = \Carbon\Carbon::now()->addMinutes(5);
            
            // Store OTP in session (not in database yet since user doesn't exist)
            session([
                'registration_otp' => $otp,
                'registration_otp_expires_at' => $expiresAt,
                'registration_email' => $request->email
            ]);
            
            // Send OTP via email (synchronously for immediate delivery)
            \Mail::to($request->email)->send(new \App\Mail\SendOtpMail($otp));
            
            return redirect()->route('register.otp.verify')
                ->with('success', 'Registration details received! Please enter the OTP sent to your email to complete registration.')
                ->with('email', $request->email);
                
        } catch (\Exception $e) {
            \Log::error('OTP sending failed during registration: ' . $e->getMessage());
            
            // Clear session data on error
            session()->forget(['pending_registration', 'registration_otp', 'registration_otp_expires_at', 'registration_email']);
            
            return back()->with('error', 'Failed to send verification email. Please try again.');
        }
    }

    public function loginPost(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Direct authentication without OTP
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            return redirect()->route('home')
                ->with('success', 'Login successful!');
        }

        return back()->with('error', 'The provided credentials do not match our records.');
    }

    public function showRegisterOtpVerify()
    {
        $email = session('registration_email');
        
        if (!$email || !session('pending_registration')) {
            return redirect()->route('register')
                ->with('error', 'Registration session expired. Please start again.');
        }
        
        return view('auth.register-otp-verify', [
            'email' => $email
        ]);
    }

    public function verifyRegisterOtp(Request $request)
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
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

        try {
            $email = session('registration_email');
            $pendingRegistration = session('pending_registration');
            
            if (!$email || !$pendingRegistration) {
                return response()->json([
                    'success' => false,
                    'message' => 'Registration session expired. Please start again.'
                ], 400);
            }

            // Check if OTP has expired
            if (\Carbon\Carbon::now()->gt(session('registration_otp_expires_at'))) {
                // Clear expired session data
                session()->forget(['pending_registration', 'registration_otp', 'registration_otp_expires_at', 'registration_email']);
                
                return response()->json([
                    'success' => false,
                    'message' => 'OTP has expired. Please start registration again.'
                ], 400);
            }

            // Verify OTP
            if (session('registration_otp') !== $request->otp) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid OTP. Please check and try again.'
                ], 400);
            }

            // Create the user account
            $user = User::create($pendingRegistration);
            
            // Clear session data
            session()->forget(['pending_registration', 'registration_otp', 'registration_otp_expires_at', 'registration_email']);

            // Auto-login the user after successful registration
            Auth::login($user);
            $request->session()->regenerate();

            return response()->json([
                'success' => true,
                'message' => 'Registration successful! Welcome to Gifts Hub!',
                'redirect' => route('home')
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Registration OTP verification failed: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Registration failed. Please try again.'
            ], 500);
        }
    }

    public function resendRegisterOtp(Request $request)
    {
        $email = session('registration_email');
        $pendingRegistration = session('pending_registration');
        
        if (!$email || !$pendingRegistration) {
            return response()->json([
                'success' => false,
                'message' => 'Registration session expired. Please start again.'
            ], 400);
        }

        try {
            // Generate new OTP
            $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            $expiresAt = \Carbon\Carbon::now()->addMinutes(5);
            
            // Update session with new OTP
            session([
                'registration_otp' => $otp,
                'registration_otp_expires_at' => $expiresAt
            ]);
            
            // Send OTP via email (synchronously for immediate delivery)
            \Mail::to($email)->send(new \App\Mail\SendOtpMail($otp));
            
            return response()->json([
                'success' => true,
                'message' => 'New OTP has been sent to your email address.'
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Registration OTP resend failed: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to resend OTP. Please try again.'
            ], 500);
        }
    }

    public function forget()
    {
        return view('auth.forget');
    }

    public function forgetPost(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:6|confirmed',
        ], [
            'email.exists' => 'This email address is not registered in our system.',
            'password.confirmed' => 'Password confirmation does not match.',
        ]);

        try {
            $user = User::where('email', $request->email)->first();
            
            if ($user) {
                // Update the user's password
                $user->update([
                    'password' => Hash::make($request->password),
                ]);
                
                return redirect()->route('login')
                    ->with('success', 'Your password has been reset successfully! Please login with your new password.');
            }
            
            return back()->with('error', 'User not found with this email address.');
            
        } catch (\Exception $e) {
            \Log::error('Password reset failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to reset password. Please try again.');
        }
    }

    public function logout(Request $request)
    {
        // Debug: Log what method is being used
        \Log::info('Logout method: ' . $request->method());
        \Log::info('Logout route requested: ' . request()->route()->getName());
        
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success', 'Logged out successfully');
    }

}
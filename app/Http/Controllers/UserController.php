<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

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
        
        // Try to find real order first
        $order = Order::where('user_id', $user->id)
                     ->where('order_id', $orderId)
                     ->first();
        
        // If no real order found, create sample order data
        if (!$order) {
            $order = $this->getSampleOrderData($orderId);
        }
        
        return view('user.detail', compact('user', 'order'));
    }
    
    private function getSampleOrderData($orderId)
    {
        // Sample order data for demonstration
        $sampleOrders = [
            '1001' => [
                'order_id' => '1001',
                'created_at' => now()->subMonths(2),
                'total' => 150.00,
                'payment_method' => 'cod',
                'status' => 'shipped',
                'status_badge' => '<span class="badge rounded-pill bg-success">Shipped</span>',
                'billing' => [
                    'first_name' => 'Sandesh',
                    'last_name' => 'Shrestha',
                    'email' => 'sandesh@example.com',
                    'phone' => '(123) 456-7890',
                    'address' => '123 Main Street',
                    'city' => 'Kathmandu',
                    'state' => 'Bagmati',
                    'pin_code' => '44600',
                    'country' => 'Nepal'
                ],
                'items' => [] // Empty items, will show sample products
            ],
            '2002' => [
                'order_id' => '2002',
                'created_at' => now()->subMonth(),
                'total' => 200.00,
                'payment_method' => 'credit_card',
                'status' => 'processing',
                'status_badge' => '<span class="badge rounded-pill bg-secondary">Processing</span>',
                'billing' => [
                    'first_name' => 'Sandesh',
                    'last_name' => 'Shrestha',
                    'email' => 'sandesh@example.com',
                    'phone' => '(123) 456-7890',
                    'address' => '123 Main Street',
                    'city' => 'Kathmandu',
                    'state' => 'Bagmati',
                    'pin_code' => '44600',
                    'country' => 'Nepal'
                ],
                'items' => [] // Empty items, will show sample products
            ],
            '2003' => [
                'order_id' => '2003',
                'created_at' => now()->subMonth(),
                'total' => 200.00,
                'payment_method' => 'cod',
                'status' => 'processing',
                'status_badge' => '<span class="badge rounded-pill bg-secondary">Processing</span>',
                'billing' => [
                    'first_name' => 'Sandesh',
                    'last_name' => 'Shrestha',
                    'email' => 'sandesh@example.com',
                    'phone' => '(123) 456-7890',
                    'address' => '123 Main Street',
                    'city' => 'Kathmandu',
                    'state' => 'Bagmati',
                    'pin_code' => '44600',
                    'country' => 'Nepal'
                ],
                'items' => [] // Empty items, will show sample products
            ],
            '2004' => [
                'order_id' => '2004',
                'created_at' => now()->subMonth(),
                'total' => 200.00,
                'payment_method' => 'esewa',
                'status' => 'on_the_way',
                'status_badge' => '<span class="badge rounded-pill bg-info">On the way</span>',
                'billing' => [
                    'first_name' => 'Sandesh',
                    'last_name' => 'Shrestha',
                    'email' => 'sandesh@example.com',
                    'phone' => '(123) 456-7890',
                    'address' => '123 Main Street',
                    'city' => 'Kathmandu',
                    'state' => 'Bagmati',
                    'pin_code' => '44600',
                    'country' => 'Nepal'
                ],
                'items' => [] // Empty items, will show sample products
            ],
            '2005' => [
                'order_id' => '2005',
                'created_at' => now()->subMonth(),
                'total' => 200.00,
                'payment_method' => 'cod',
                'status' => 'cancelled',
                'status_badge' => '<span class="badge rounded-pill bg-warning">Cancelled</span>',
                'billing' => [
                    'first_name' => 'Sandesh',
                    'last_name' => 'Shrestha',
                    'email' => 'sandesh@example.com',
                    'phone' => '(123) 456-7890',
                    'address' => '123 Main Street',
                    'city' => 'Kathmandu',
                    'state' => 'Bagmati',
                    'pin_code' => '44600',
                    'country' => 'Nepal'
                ],
                'items' => [] // Empty items, will show sample products
            ]
        ];
        
        // Return sample order data or create default if not found
        return (object) ($sampleOrders[$orderId] ?? [
            'order_id' => $orderId,
            'created_at' => now()->subMonth(),
            'total' => 150.00,
            'payment_method' => 'cod',
            'status' => 'shipped',
            'status_badge' => '<span class="badge rounded-pill bg-success">Shipped</span>',
            'billing' => [
                'first_name' => 'Sandesh',
                'last_name' => 'Shrestha',
                'email' => 'sandesh@example.com',
                'phone' => '(123) 456-7890',
                'address' => '123 Main Street',
                'city' => 'Kathmandu',
                'state' => 'Bagmati',
                'pin_code' => '44600',
                'country' => 'Nepal'
            ],
            'items' => []
        ]);
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
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect()->route('login')->with('success', 'Registration successful! Please login.');
    }

    public function loginPost(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('user.dashboard')->with('success', 'Logged in successfully');
        }

        return back()->with('error', 'The provided credentials do not match our records.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success', 'Logged out successfully');
    }

}
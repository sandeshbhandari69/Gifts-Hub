<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use App\Models\Order;

class CheckoutController extends Controller
{
    public function checkout($slug)
    {
        // Get cart items
        $cartItems = Session::get('cart', []);
        
        // Check if cart is empty
        if (empty($cartItems)) {
            return redirect()->route('home')->with('error', 'Your cart is empty. Please add items first.');
        }
        
        return view('checkout', compact('cartItems'));
    }
    
    public function process(Request $request)
    {
        // Validate the form
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'country' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'pin_code' => 'required|string|max:10',
            'address' => 'required|string',
            'payment_method' => 'required|in:credit_card,esewa,khalti,cod'
        ]);
        
        // Get cart items
        $cartItems = Session::get('cart', []);
        $total = collect($cartItems)->sum(function($item) {
            return (float)str_replace('$', '', $item['price']) * $item['quantity'];
        });
        
        // Create order data
        $orderData = [
            'user_id' => auth()->id() ?? null,
            'order_id' => 'ORD-' . strtoupper(uniqid()),
            'billing_data' => [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'country' => $request->country,
                'city' => $request->city,
                'state' => $request->state,
                'pin_code' => $request->pin_code,
                'landmark' => $request->landmark,
                'address' => $request->address,
            ],
            'items' => $cartItems,
            'total' => $total,
            'payment_method' => $request->payment_method,
            'status' => 'processing',
        ];
        
        // Save order to database
        $order = Order::create($orderData);
        
        // Store order in session for success page
        Session::put('last_order', $order->toArray());
        
        // Clear cart
        Session::forget('cart');
        
        // Redirect to success page
        return redirect()->route('checkout.success')->with('success', 'Order placed successfully!');
    }
    
    public function success()
    {
        $order = Session::get('last_order');
        
        if (!$order) {
            return redirect()->route('home');
        }
        
        return view('checkout-success', compact('order'));
    }
}
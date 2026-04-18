<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Models\Order;

class CheckoutController extends Controller
{
    public function checkoutDirect()
    {
        // Get cart items
        $cartItems = Session::get('cart', []);
        
        // Check if cart is empty
        if (empty($cartItems)) {
            return redirect()->route('home')->with('error', 'Your cart is empty. Please add items first.');
        }
        
        return view('checkout', compact('cartItems'));
    }
    
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
        // Validate form
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'country' => 'required|string',
            'pin_code' => 'nullable|string|max:10',
            'address' => 'required|string',
            'payment_method' => 'required|in:credit_card,esewa,khalti,cod'
        ]);
        
        // Get cart items
        $cartItems = Session::get('cart', []);
        $total = collect($cartItems)->sum(function($item) {
            return (float)str_replace(['$', 'Rs.', 'Rs '], '', $item['price']) * $item['quantity'];
        });
        
        // Check if Khalti payment is selected
        if ($request->payment_method === 'khalti') {
            $khaltiService = app(\App\Services\KhaltiService::class);
            $purchaseOrderId = 'ORD-' . strtoupper(uniqid());
            
            // Convert amount to paisa (Rs 1 = 100 paisa)
            $amountInPaisa = (int) ($total * 100);
            
            // Format phone number for Khalti
            $phone = preg_replace('/[^0-9]/', '', $request->phone);
            if (strlen($phone) < 10) {
                $phone = str_pad($phone, 10, '0', STR_PAD_RIGHT);
            }
            $phone = substr($phone, 0, 10); // Ensure exactly 10 digits
            
            // Create payment data for Khalti
            $paymentData = [
                'amount' => $amountInPaisa,
                'purchase_order_id' => $purchaseOrderId,
                'purchase_order_name' => 'Order ' . $purchaseOrderId,
                'customer_name' => $request->first_name . ' ' . $request->last_name,
                'customer_email' => $request->email,
                'customer_phone' => $phone,
                'return_url' => route('payment.callback'), // Add return URL for callback
                'website_url' => config('app.url') // Add website URL
            ];
            
            // Store order details in session for callback processing
            $orderData = [
                'user_id' => auth()->id() ?? null,
                'order_id' => $purchaseOrderId,
                'billing_data' => [
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'country' => $request->country,
                    'pin_code' => $request->pin_code,
                    'landmark' => request('landmark'),
                    'address' => $request->address,
                ],
                'items' => $cartItems,
                'total' => $total,
                'payment_method' => 'khalti',
                'status' => 'pending_payment',
            ];
            Session::put('pending_khalti_order', $orderData);
            
            // Initiate payment using KhaltiService
            $response = $khaltiService->initiatePayment($paymentData);
            
            // Log the full response for debugging
            Log::info('Khalti API Response', [
                'response' => $response,
                'payment_data' => $paymentData
            ]);
            
            if (isset($response['payment_url'])) {
                Log::info('Redirecting directly to Khalti payment URL', [
                    'payment_url' => $response['payment_url'],
                    'pidx' => $response['pidx'] ?? null,
                    'order_id' => $purchaseOrderId
                ]);
                
                // Direct redirect to Khalti payment URL (no intermediate page)
                return redirect()->away($response['payment_url']);
            }
            
            // Handle errors
            $errorMessage = 'Unknown error occurred';
            if (isset($response['error']) && $response['error']) {
                $errorMessage = $response['message'] ?? $response['detail'] ?? 'Khalti API Error';
            } elseif (isset($response['detail'])) {
                $errorMessage = is_array($response['detail']) ? json_encode($response['detail']) : $response['detail'];
            } elseif (isset($response['message'])) {
                $errorMessage = $response['message'];
            }
            
            return redirect()->back()->with('error', 'Could not initiate Khalti payment: ' . $errorMessage);
        }

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
                'pin_code' => $request->pin_code,
                'landmark' => request('landmark'),
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
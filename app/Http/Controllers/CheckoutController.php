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
            
            // Make amount into paisa. Khalti strictly requires minimum Rs 10 (1000 paisa) and maximum Rs 1000 (100000 paisa) for standard tests.
            $amountInPaisa = (int) ($total * 100);
            $amountInPaisa = min(max($amountInPaisa, 1000), 100000); // Enforce Rs 10 - Rs 1000 limit
            
            // Khalti usually expects a 10-digit phone number.
            $phone = preg_replace('/[^0-9]/', '', $request->phone);
            if (strlen($phone) < 10) {
                $phone = str_pad($phone, 10, '0', STR_PAD_RIGHT);
            }
            
            $payload = [
                'return_url' => route('payment.callback'),
                'website_url' => url('/'),
                'amount' => $amountInPaisa,
                'purchase_order_id' => $purchaseOrderId,
                'purchase_order_name' => 'Order ' . $purchaseOrderId,
                'customer_info' => [
                    'name' => $request->first_name . ' ' . $request->last_name,
                    'email' => $request->email,
                    'phone' => substr($phone, 0, 10), // Ensure max 10
                ]
            ];
            
            // Store order details in session so that callback can save it after success
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
            
            $response = $khaltiService->initiatePayment($payload);
            
            if (isset($response['payment_url'])) {
                return redirect()->away($response['payment_url']);
            }
            
            $errorMessage = isset($response['detail']) ? json_encode($response['detail']) : json_encode($response);
            return redirect()->back()->with('error', 'Could not initiate Khalti payment. Reason: ' . $errorMessage);
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
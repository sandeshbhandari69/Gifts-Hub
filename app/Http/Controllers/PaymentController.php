<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\KhaltiService;
use App\Models\Order;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    protected $khaltiService;

    public function __construct(KhaltiService $khaltiService)
    {
        $this->khaltiService = $khaltiService;
    }

    /**
     * Initiate Khalti payment
     */
    public function initiate(Request $request)
    {
        // Example payload. In a real application, calculate amount based on cart/order.
        // Khalti expects amount in paisa (1 Rs = 100 paisa).
        $amount = $request->input('amount', 1000); // Default 10 Rs
        $purchaseOrderId = 'Order-' . uniqid();
        $purchaseOrderName = 'Test Product';

        $payload = [
            'return_url' => route('payment.callback'),
            'website_url' => url('/'),
            'amount' => $amount,
            'purchase_order_id' => $purchaseOrderId,
            'purchase_order_name' => $purchaseOrderName,
            'customer_info' => [
                'name' => 'Test User',
                'email' => 'test@example.com',
                'phone' => '9800000000'
            ]
        ];

        $response = $this->khaltiService->initiatePayment($payload);

        if (isset($response['payment_url'])) {
            return redirect()->away($response['payment_url']);
        }

        // Handle error globally
        return redirect()->back()->with('error', 'Could not initiate Khalti payment. Please try again.');
    }

    /**
     * Handle payment validation callback
     */
    public function callback(Request $request)
    {
        $pidx = $request->query('pidx');

        if (!$pidx) {
            return redirect()->route('home')->with('error', 'Invalid payment request. Pidx missing.');
        }

        $response = $this->khaltiService->lookupPayment($pidx);

        if (isset($response['status']) && $response['status'] === 'Completed') {
            
            $pendingOrder = Session::get('pending_khalti_order');
            
            if (!$pendingOrder) {
                return redirect()->route('home')->with('error', 'Payment successful, but session expired before saving the order. Please contact support.');
            }
            
            if (empty($pendingOrder['user_id'])) {
                return redirect()->route('login')->with('error', 'You must be logged in to complete this order. Your payment was successful but order failed to save. Contact support.');
            }

            // Payment is confirmed. Update status and save to DB
            $pendingOrder['status'] = 'processing';
            
            // Check if order already exists to prevent duplicates
            $existingOrder = Order::where('order_id', $pendingOrder['order_id'])->first();
            if ($existingOrder) {
                $order = $existingOrder;
            } else {
                $order = Order::create($pendingOrder);
            }
            
            // Check if payment already exists to prevent duplicates
            $existingPayment = DB::table('payments')->where('pidx', $pidx)->first();
            if (!$existingPayment) {
                // Save out to payments database table as well using session user_id
                DB::table('payments')->insert([
                    'transaction_id' => $response['transaction_id'] ?? 'txn_' . uniqid(),
                    'pidx' => $pidx,
                    'user_id' => $pendingOrder['user_id'],
                    'product_name' => 'Order ' . $pendingOrder['order_id'],
                    'product_id' => (string) $order->id,
                    'amount' => $response['total_amount'] ?? $pendingOrder['total'], // response amount is in paisa usually, better to save order total or Khalti amount based on preference.
                    'status' => 'completed',
                    'payment_method' => 'khalti',
                    'khalti_response' => json_encode($response),
                    'khalti_verification' => json_encode(['status' => 'verified']),
                    'completed_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            
            // Prepare session for success page
            Session::put('last_order', $order->toArray());
            Session::forget('cart');
            Session::forget('pending_khalti_order');
            
            return redirect()->route('checkout.success')->with('success', 'Order placed successfully with Khalti!');
        }

        return redirect()->route('home')->with('error', 'Payment failed, expired, or was canceled.');
    }
}

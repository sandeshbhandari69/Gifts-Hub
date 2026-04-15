<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class KhaltiService
{
    protected $publicKey;
    protected $secretKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->publicKey = env('KHALTI_PUBLIC_KEY');
        $this->secretKey = env('KHALTI_SECRET_KEY');
        $this->baseUrl = env('KHALTI_BASE_URL', 'https://dev.khalti.com/api/v2/');
        
        // Debug: Log credentials (without exposing full secret)
        Log::info('KhaltiService initialized', [
            'public_key' => $this->publicKey ? substr($this->publicKey, 0, 8) . '...' : 'NULL',
            'secret_key' => $this->secretKey ? substr($this->secretKey, 0, 8) . '...' : 'NULL',
            'base_url' => $this->baseUrl,
            'env_loaded' => env('KHALTI_PUBLIC_KEY') !== null
        ]);
    }

    /**
     * Initiate Khalti ePayment
     *
     * @param array $payload
     * @return array
     */
    public function initiatePayment($payload)
    {
        try {
            Log::info('Khalti Payment Initiation Started', [
                'url' => $this->baseUrl . 'epayment/initiate/',
                'payload' => $payload,
                'secret_key_available' => !empty($this->secretKey),
                'secret_key_length' => strlen($this->secretKey ?? '')
            ]);

            $headers = [
                'Authorization' => 'Key ' . $this->secretKey,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ];

            Log::info('Khalti Request Headers', [
                'headers' => $headers,
                'auth_header' => $headers['Authorization']
            ]);

            $response = Http::withHeaders($headers)->post($this->baseUrl . 'epayment/initiate/', $payload);

            $responseData = $response->json();
            
            Log::info('Khalti Payment Response', [
                'status' => $response->status(),
                'successful' => $response->successful(),
                'response' => $responseData
            ]);

            return $responseData;
        } catch (\Exception $e) {
            Log::error('Khalti Payment Error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'secret_key_available' => !empty($this->secretKey)
            ]);
            
            return [
                'error' => true,
                'message' => $e->getMessage(),
                'detail' => 'Failed to initiate Khalti payment'
            ];
        }
    }

    /**
     * Verify Khalti payment using pidx
     *
     * @param string $pidx
     * @return array
     */
    public function verifyPayment($pidx)
    {
        try {
            Log::info('Khalti Payment Verification Started', [
                'pidx' => $pidx
            ]);

            $response = Http::withHeaders([
                'Authorization' => 'Key ' . $this->secretKey,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->post($this->baseUrl . 'epayment/lookup/', [
                'pidx' => $pidx
            ]);

            $responseData = $response->json();
            
            Log::info('Khalti Verification Response', [
                'status' => $response->status(),
                'response' => $responseData
            ]);

            return $responseData;
        } catch (\Exception $e) {
            Log::error('Khalti Verification Error', [
                'pidx' => $pidx,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return [
                'error' => true,
                'message' => $e->getMessage(),
                'detail' => 'Failed to verify Khalti payment'
            ];
        }
    }

    /**
     * Get public key for frontend integration
     *
     * @return string
     */
    public function getPublicKey()
    {
        return $this->publicKey;
    }

    /**
     * Create payment payload for Khalti
     *
     * @param array $orderData
     * @return array
     */
    public function createPaymentPayload($orderData)
    {
        return [
            'return_url' => route('payment.callback'),
            'website_url' => config('app.url'),
            'amount' => $orderData['amount'], // Amount in paisa
            'purchase_order_id' => $orderData['purchase_order_id'],
            'purchase_order_name' => $orderData['purchase_order_name'],
            'customer_info' => [
                'name' => $orderData['customer_name'],
                'email' => $orderData['customer_email'],
                'phone' => $orderData['customer_phone']
            ]
        ];
    }
}

<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class KhaltiService
{
    protected $baseUrl;
    protected $secretKey;

    public function __construct()
    {
        $this->baseUrl = config('services.khalti.base_url', 'https://dev.khalti.com/api/v2/');
        $this->secretKey = config('services.khalti.secret_key');
    }

    /**
     * Initiate Khalti Payment
     *
     * @param array $payload
     * @return array
     */
    public function initiatePayment($payload)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Key ' . $this->secretKey,
                'Content-Type'  => 'application/json',
            ])->post($this->baseUrl . 'epayment/initiate/', $payload);

            // Log the response for debugging
            \Log::info('Khalti HTTP Response', [
                'status' => $response->status(),
                'body' => $response->body(),
                'headers' => $response->headers()
            ]);

            // Check if the request was successful
            if ($response->successful()) {
                return $response->json();
            } else {
                // Return error information
                return [
                    'error' => true,
                    'status' => $response->status(),
                    'message' => $response->json()['message'] ?? $response->json()['detail'] ?? 'HTTP Error: ' . $response->status(),
                    'body' => $response->body()
                ];
            }
        } catch (\Exception $e) {
            // Log and return exception information
            \Log::error('Khalti API Exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return [
                'error' => true,
                'message' => 'Exception: ' . $e->getMessage(),
                'exception' => true
            ];
        }
    }

    /**
     * Lookup Khalti Payment by pidx
     *
     * @param string $pidx
     * @return array
     */
    public function lookupPayment($pidx)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Key ' . $this->secretKey,
            'Content-Type'  => 'application/json',
        ])->post($this->baseUrl . 'epayment/lookup/', [
            'pidx' => $pidx
        ]);

        return $response->json();
    }
}
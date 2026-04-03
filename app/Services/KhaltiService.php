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
        $response = Http::withHeaders([
            'Authorization' => 'Key ' . $this->secretKey,
            'Content-Type'  => 'application/json',
        ])->post($this->baseUrl . 'epayment/initiate/', $payload);

        return $response->json();
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

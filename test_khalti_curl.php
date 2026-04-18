<?php

// Simple test to verify Khalti API credentials
$secretKey = "live_secret_key_1691d7084bec4a8b8d0017d89af34e5f";
$publicKey = "live_public_key_0328236b00b04669a3c27d50f5c6fe44";
$baseUrl = "https://dev.khalti.com/api/v2/";

$payload = [
    'return_url' => 'http://127.0.0.1:8000/payment/callback',
    'website_url' => 'http://127.0.0.1:8000',
    'amount' => 1000,
    'purchase_order_id' => 'TEST-' . uniqid(),
    'purchase_order_name' => 'Test Payment',
    'customer_info' => [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'phone' => '9800000000'
    ]
];

$ch = curl_init($baseUrl . 'epayment/initiate/');

curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Key ' . $secretKey,
    'Content-Type: application/json',
    'Accept: application/json'
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "HTTP Status: " . $httpCode . "\n";
echo "Response: " . $response . "\n";

// Also test with test environment
echo "\n=== Testing with Sandbox Environment ===\n";

$testBaseUrl = "https://dev.khalti.com/api/v2/";
$ch = curl_init($testBaseUrl . 'epayment/initiate/');

curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Key ' . $secretKey,
    'Content-Type: application/json',
    'Accept: application/json'
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "HTTP Status: " . $httpCode . "\n";
echo "Response: " . $response . "\n";
?>

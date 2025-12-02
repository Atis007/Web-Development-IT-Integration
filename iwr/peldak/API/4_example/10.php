<?php
require 'vendor/autoload.php';
use GuzzleHttp\Client;

$client = new Client();

try {
    $response = $client->request('PATCH', 'http://localhost/iws_2025/06/API/2_example/products/4', [
        'headers' => [
            'Authorization' => 'Bearer YOUR_ACCESS_TOKEN',
            'Accept' => 'application/json',
            'Content-Type' => 'application/json', // Set the content type to JSON
        ],
        'json' => [
            'name' => 'vts2php',
            'size' => 15,
            'available' => 1,
        ],
    ]);

    // Get and display the response
    echo "Response Status Code: " . $response->getStatusCode() . "\n";
    echo "Response Body: " . $response->getBody() . "\n";
} catch (\GuzzleHttp\Exception\RequestException $e) {
    echo "Request failed: " . $e->getMessage() . "\n";
}

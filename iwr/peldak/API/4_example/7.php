<?php
require 'vendor/autoload.php';
use GuzzleHttp\Client;

$client = new Client();
$url = "http://localhost/iws_2025/06/API/2_example/products";
try {
    $response = $client->request('POST', $url, [
        'headers' => [
            'Authorization' => 'Bearer YOUR_ACCESS_TOKEN',
            'Accept' => 'application/json',
            'Content-Type' => 'application/json', // Set the content type to JSON
        ],
        'json' => [
            'name' => 'foo',
            'size' => 12,
            'available' => 1,
        ],
    ]);

    // Get and display the response
    echo "Response Status Code: " . $response->getStatusCode() . "\n";
    echo "Response Body: " . $response->getBody() . "\n";
} catch (\GuzzleHttp\Exception\RequestException $e) {
    echo "Request failed: " . $e->getMessage() . "\n";
}
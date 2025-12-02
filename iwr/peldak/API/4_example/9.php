<?php

require 'vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;

$client = new Client([
    'base_uri' => 'http://localhost/iws_2025/06/API/2_example/', // Base URL for your API
]);

$endpoint = 'products/5';

try {
    $response = $client->delete($endpoint, [
        'headers' => [
            'Authorization' => 'Bearer YOUR_ACCESS_TOKEN',
            'Accept' => 'application/json',
        ],
    ]);

    if ($response->getStatusCode() === 200) {
        echo "Resource deleted successfully: " . $response->getBody();
    } else {
        echo "Unexpected response status: " . $response->getStatusCode();
    }
} catch (\GuzzleHttp\Exception\ClientException $e) {
    // Handle client-side errors (4xx)
    echo "Client error: " . $e->getMessage();
} catch (\GuzzleHttp\Exception\ServerException $e) {
    // Handle server-side errors (5xx)
    echo "Server error: " . $e->getMessage();
} catch (\Exception $e) {
    // Handle other errors
    echo "Error: " . $e->getMessage();
}


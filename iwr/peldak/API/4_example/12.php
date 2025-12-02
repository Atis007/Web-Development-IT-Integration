<?php
// The API will return JSON, so we set the correct response header
header("Content-Type: application/json; charset=UTF-8");

require 'vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

// Create a Guzzle HTTP client instance
$client = new Client();

$url = "https://v2.jokeapi.dev/joke/Programming";

try {
    // Send a GET request with timeout, headers and query parameters
    $response = $client->request('GET', $url, [
        'timeout' => 3.0,                // Maximum time (in seconds) to wait for the API response
        'headers' => [
            'Accept' => 'application/json', // Tell the API that we want JSON response
        ],
        'query' => [                    // Query parameters added to the URL
            'type' => 'single',
            'amount' => 10
        ]
    ]);

    // Convert response body stream to string
    $body = (string)$response->getBody();

    // Decode JSON into an associative array
    $data = json_decode($body, true);

    // Check if json_decode() failed (invalid or corrupted JSON)
    if (json_last_error() !== JSON_ERROR_NONE) {
        http_response_code(502); // Bad Gateway: error from upstream API

        echo json_encode([
            'success' => false,
            'error' => 'Invalid JSON from remote API: ' . json_last_error_msg(),
        ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

        exit;
    }

    // Everything is OK — return a clean JSON response
    http_response_code(200);

    echo json_encode([
        'success' => true,
        'data' => $data,
    ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);


} catch (GuzzleException $e) {
    // Any Guzzle-related error: timeout, connection failure, DNS, HTTP error, etc.
    http_response_code(500);

    echo json_encode([
        'success' => false,
        'error' => 'Request failed: ' . $e->getMessage(),
    ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
}
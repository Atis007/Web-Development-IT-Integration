<?php
// Example: Guzzle GET request with timeout, JSON validation and nice JSON responses
// Install Guzzle: composer require guzzlehttp/guzzle

header("Content-Type: application/json; charset=UTF-8");

require 'vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

$client = new Client();

$url = "https://v2.jokeapi.dev/joke/Programming";

try {
    // Send GET request with query params and 3-second timeout
    $response = $client->request('GET', $url, [
        'timeout' => 3.0,
        'headers' => [
            'Accept' => 'application/json', // Ask API to return JSON
        ],
        'query' => [
            'type'   => 'single',
            'amount' => 10
        ]
    ]);

    $statusCode = $response->getStatusCode();
    $body       = (string)$response->getBody();

    // ---------------------------------------------------------
    // 1. Check if API returned JSON in Content-Type header
    // ---------------------------------------------------------
    $contentType = $response->getHeaderLine('Content-Type');

    if (!str_contains($contentType, 'application/json')) {
        http_response_code(502);

        echo json_encode([
            'success'     => false,
            'error'       => 'Remote API did not return JSON.',
            'contentType' => $contentType,
            'rawBody'     => $body
        ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit;
    }

    // ---------------------------------------------------------
    // 2. Try to decode JSON
    // ---------------------------------------------------------
    $data = json_decode($body, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        http_response_code(502);

        echo json_encode([
            'success' => false,
            'error'   => "Invalid JSON received: " . json_last_error_msg(),
            'rawBody' => $body
        ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit;
    }

    // ---------------------------------------------------------
    // 3. Everything is OK — return pretty JSON
    // ---------------------------------------------------------
    http_response_code($statusCode);

    echo json_encode([
        'success' => true,
        'status'  => $statusCode,
        'count'   => count($data['jokes'] ?? []),
        'data'    => $data
    ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);


} catch (GuzzleException $e) {

    // ---------------------------------------------------------
    // Any error: timeout, connection error, DNS fail, HTTP error
    // ---------------------------------------------------------
    http_response_code(500);

    echo json_encode([
        'success' => false,
        'error'   => 'Request failed: ' . $e->getMessage(),
        'type'    => get_class($e) // Shows exception type (useful for learning)
    ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
}
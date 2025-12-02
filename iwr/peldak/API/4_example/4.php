<?php
header("Content-Type: application/json; charset=UTF-8");

require 'vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

$client = new Client();
$url = 'http://localhost/iws_2025/06/API/4_example/slow.php';

try {
    $response = $client->request('GET', $url, [
        'timeout' => 2.0, // seconds
        'headers' => [
            'Accept' => 'application/json',
        ],
    ]);

    $body = (string)$response->getBody();

    $data = json_decode($body, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        http_response_code(502); // Bad Gateway

        echo json_encode([
            'success' => false,
            'error' => 'Invalid JSON from remote service: ' . json_last_error_msg(),
            'rawBody' => $body,
        ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit;
    }

    http_response_code(200);

    echo json_encode([
        'success' => true,
        'data' => $data,
    ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

} catch (GuzzleException $e) {
    // Any request/connection error (including timeout)
    http_response_code(500);

    echo json_encode([
        'success' => false,
        'error' => 'Request failed: ' . $e->getMessage(),
    ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
}
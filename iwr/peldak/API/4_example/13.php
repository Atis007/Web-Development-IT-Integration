<?php
declare(strict_types=1);

require 'vendor/autoload.php';

use GuzzleHttp\Client;

// Simple HTTP client configuration
// base_uri  → avoids repeating the same URL
// http_errors = false → Guzzle will NOT throw exceptions on 4xx/5xx responses.
//                       We can manually check the status code in every request.
$client = new Client([
    'base_uri' => 'http://localhost/iws_2025/06/API/2_example/',
    'http_errors' => false,
]);

// Helper function to print API responses in a readable (HTML-friendly) format
function printResponse($title, $response)
{
    echo "==============================<br>\n";
    echo "<strong>$title</strong><br>\n";
    echo "Status code: " . $response->getStatusCode() . "<br>\n";
    echo "Body:<br>" . htmlspecialchars((string)$response->getBody()) . "<br><br>\n";
}

/**
 * 1) GET /products
 * Fetch all products from the API
 */
$response = $client->get('products');
printResponse('GET /products', $response);

/**
 * 2) GET /products/1
 * Fetch a single product by its ID
 */
$response = $client->get('products/1');
printResponse('GET /products/1', $response);

/**
 * 3) POST /products
 * Create a new product
 * JSON body → { "name": "vts" }
 * Using 'json' automatically sets Content-Type: application/json
 */
$response = $client->post('products', [
    'json' => [
        'name' => 'vts',
    ],
]);
printResponse('POST /products', $response);

/**
 * 4) PATCH /products/18
 * Partially update a product
 * JSON body → { "name": "vts2", "size": 1 }
 */
$response = $client->patch('products/18', [
    'json' => [
        'name' => 'vts2',
        'size' => 1,
    ],
]);
printResponse('PATCH /products/18', $response);

/**
 * 5) DELETE /products/19
 * Delete a product by ID
 */
$response = $client->delete('products/19');
printResponse('DELETE /products/19', $response);

/**
 * 6) PUT /products
 * The API does NOT allow this method
 * Expected result: 405 Method Not Allowed
 */
$response = $client->put('products', [
    'json' => [
        'name' => 'something',
    ],
]);
printResponse('PUT /products (expected 405)', $response);

echo "<strong>Done.</strong><br>\n";
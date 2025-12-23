<?php
declare(strict_types=1);

require __DIR__ . '/includes/functions.php';

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

$pdo = $GLOBALS['pdo'];
$tokenRow = fetchRandomToken($pdo);

if (!$tokenRow) {
    exit('No tokens available. Run generate_tokens.php first.');
}

$tokenValue = $tokenRow['token'];
$client = new Client([
    'base_uri' => 'http://localhost/iskola/iwr/feladatok/Task9/api/',
    'http_errors' => false,
]);

$requests = [];

try {
    $requests[] = [
        'label' => 'GET /api/products',
        'response' => $client->get('products', buildOptions($tokenValue)),
    ];

    $requests[] = [
        'label' => 'GET /api/products/1',
        'response' => $client->get('products/1', buildOptions($tokenValue)),
    ];

    $requests[] = [
        'label' => 'GET /api/categories',
        'response' => $client->get('categories', buildOptions($tokenValue)),
    ];

    $requests[] = [
        'label' => 'GET /api/categories/1/products',
        'response' => $client->get('categories/1/products', buildOptions($tokenValue)),
    ];

    $payload = [
        'name' => 'Demo Product ' . date('His'),
        'price' => 123.45,
        'amount' => 5,
        'id_category' => 1,
    ];

    $createResponse = $client->post('products', buildOptions($tokenValue, ['json' => $payload]));
    $requests[] = [
        'label' => 'POST /api/products',
        'response' => $createResponse,
    ];

    $responseBody = (string)$createResponse->getBody();
    $createdPayload = decodeBody($responseBody);
    $createResponse->getBody()->rewind();
    $createdId = $createdPayload['data']['id_product'] ?? null;

    if ($createdId) {
        $requests[] = [
            'label' => "DELETE /api/products/$createdId",
            'response' => $client->delete("products/$createdId", buildOptions($tokenValue)),
        ];
    }
} catch (GuzzleException $exception) {
    exit('API request failed: ' . $exception->getMessage());
}

echo '<!doctype html><html lang="en"><head><meta charset="UTF-8"><title>Task 9 API demo</title></head><body>';
echo '<h1>API request log</h1>';
echo '<p>Token in use: <code>' . htmlspecialchars($tokenValue, ENT_QUOTES) . '</code></p>';

foreach ($requests as $entry) {
    renderResponse($entry['label'], $entry['response']);
}

echo '</body></html>';

function buildOptions(string $token, array $extra = []): array
{
    $base = [
        'headers' => [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
        ],
    ];

    return array_merge($base, $extra);
}

function decodeBody(string $body): array
{
    $decoded = json_decode($body, true);
    return is_array($decoded) ? $decoded : [];
}

function renderResponse(string $label, ResponseInterface $response): void
{
    $payload = decodeBody((string)$response->getBody());
    echo '<section style="margin-bottom:1rem;">';
    echo '<h2 style="font-size:1rem;">' . htmlspecialchars($label, ENT_QUOTES) . '</h2>';
    echo '<strong>Status:</strong> ' . $response->getStatusCode() . '<br>';
    echo '<pre style="background:#f5f5f5;padding:0.5rem;">' . htmlspecialchars(json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES), ENT_QUOTES) . '</pre>';
    echo '</section>';
}

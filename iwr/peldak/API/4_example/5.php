<?php
require 'vendor/autoload.php';

use GuzzleHttp\Client;

$url = "http://localhost/iws_2025/06/API/3_example/api/product";
$client = new Client();
$response = $client->request('GET', $url, [
    'headers' => [
        'Accept' => 'application/json',
        'Authorization' => 'Bearer 121212',
    ]
]);

echo $response->getBody();
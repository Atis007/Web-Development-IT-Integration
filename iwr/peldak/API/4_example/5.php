<?php
require 'vendor/autoload.php';

use GuzzleHttp\Client;

$url = "http://localhost/iskola/iwr/peldak/API/3_example/api/product";
$client = new Client();

//$client = new Client(
//    ['http_errors' => false]
//);

$response = $client->request('GET', $url, [
    'headers' => [
        'Accept' => 'application/json',
        'Authorization' => 'Bearer 121212',
    ]
]);

echo $response->getBody();

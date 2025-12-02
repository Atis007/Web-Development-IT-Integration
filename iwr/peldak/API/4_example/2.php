<?php
require 'vendor/autoload.php';

use GuzzleHttp\Client;

$url = "https://v2.jokeapi.dev/joke/Programming";
$client = new Client();
$response = $client->request('GET', $url, [
    'query' => [
        'type' => 'single',
        'amount' => 10
    ]
]);

echo '<pre>';
echo $response->getBody();
echo '</pre>';
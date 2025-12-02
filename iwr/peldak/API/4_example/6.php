<?php
require 'vendor/autoload.php';

use GuzzleHttp\Client;

$client = new Client();
$response = $client->request('POST', 'https://jsonplaceholder.typicode.com/posts', [
    'json' => [
        'title' => 'foo',
        'body' => 'bar',
        'userId' => 2,
    ]
]);

echo $response->getBody();
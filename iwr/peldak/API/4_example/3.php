<?php
require 'vendor/autoload.php';

use GuzzleHttp\Client;

$client = new Client();
$response = $client->request('GET', 'https://jsonplaceholder.typicode.com/posts/1');

$status = $response->getStatusCode();
echo "Status Code: $status\n";

$body = $response->getBody();
echo "Response Body: $body\n";
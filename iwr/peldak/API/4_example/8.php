<?php
require 'vendor/autoload.php';

use GuzzleHttp\Client;

$client = new Client();

$response = $client->request('GET', 'https://jsonplaceholder.typicode.com/posts/1');

// Decode the JSON response into a PHP array
$data = json_decode($response->getBody(), true);

var_dump($data);  // Output the decoded JSON
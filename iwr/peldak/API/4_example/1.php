<?php
// Install Guzzle using Composer: composer require guzzlehttp/guzzle
// Guzzle documentation: https://docs.guzzlephp.org/en/stable/
// API used for testing: https://v2.jokeapi.dev/

require 'vendor/autoload.php';

use GuzzleHttp\Client;

$client = new Client();

$url = "https://v2.jokeapi.dev/joke/Programming?type=single&amount=10";

$response = $client->request('GET', $url);

echo '<pre>';
echo $response->getBody();
echo '</pre>';
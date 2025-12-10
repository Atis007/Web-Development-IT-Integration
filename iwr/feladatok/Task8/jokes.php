<?php
require 'vendor/autoload.php';
require 'includes/functions.php';


$title="Task8";
include_once 'includes/header.php';
use GuzzleHttp\Client;

$pdo = $GLOBALS['pdo'];

$client = new Client();

$url = "https://v2.jokeapi.dev/joke/Programming";

$response = $client->request('GET', $url, [
    'query' => [
        'amount' => 10
    ]
]);

$result = $response->getBody()->getContents();

echo "<pre>";
echo $result;
echo "</pre>";

$data = json_decode($result, true);

$jokesArray = $data["jokes"];

foreach($jokesArray as $jokes) {
    $type = $jokes['type'];
    $joke = '';
    $setup = $delivery = '';
    if ($type === "twopart") {
        $joke = "Two part joke";
        $setup = $jokes['setup'];
        $delivery = $jokes['delivery'];
    }

    if ($type === "single") {
        $joke = $jokes['joke'];
        $setup = $delivery = "Single part joke";
    }
    insertIntoJokes($pdo, $type, $joke, $setup, $delivery);
}

include_once 'includes/footer.php';
<?php
require 'includes/functions.php';

$title="Task8";
include_once 'includes/header.php';
use GuzzleHttp\Client;

$pdo = $GLOBALS['pdo'];

$client = new Client();

$url = "https://v2.jokeapi.dev/joke/Programming";

$latestTimeFromDb = latestInsertToLogs($pdo);

$dbLatestTime = strtotime($latestTimeFromDb);
$now = time();

if(( ($now - $dbLatestTime) / 60) > 5) {
    $response = $client->request('GET', $url, [
        'query' => [
            'amount' => 10
        ]
    ]);

    $result = $response->getBody()->getContents();

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
    insertIntoLogs($pdo, $url);

    echo "<p>10 jokes added to the database.</p>";
}
echo "<p><a href='jokes.php'>Go to see</a> the then latest joke in the database</p>";
include_once 'includes/footer.php';
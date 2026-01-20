<?php
use GuzzleHttp\Exception\GuzzleException;

$id=isset($_POST['worker_id']) ? (int)$_POST['worker_id'] : 0;

$urlPath = ($id>0) ? 'workers/' . $id : 'workers';
$endpoint = API_URL . $urlPath;
try {
    $response = $client->request('GET', $endpoint, [
            'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $token,
            ]
    ]);

    $workers = json_decode($response->getBody()->getContents(), true);
    if (!is_array($workers)) {
        $workers = [];
    }
    if ($id > 0 && array_key_exists('name', $workers)) {
        $workers = [$workers];
    }
} catch (GuzzleException $e) {
    // Részletesebb hibaüzenet a debugoláshoz
    $responseBody = $e->hasResponse() ? $e->getResponse()->getBody()->getContents() : '';
    die("API Hiba: " . $e->getMessage() . " <br> Válasz: " . $responseBody);
}
?>
<table class="d-flex justify-content-center">
    <tr>
        <th>No</th>
        <th>Workers Name</th>
    </tr>
    <?php
    $i = 1;
    foreach ($workers as $worker) {
        $name = isset($worker['name']) ? $worker['name'] : '';
        echo "<tr>";
        echo "<td>" . $i . "</td>";
        echo "<td>" . $name . "</td>";
        echo "</tr>";
        $i++;
    }
    ?>
</table>

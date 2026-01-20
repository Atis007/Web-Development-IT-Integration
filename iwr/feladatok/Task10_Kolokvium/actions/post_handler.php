<?php
use GuzzleHttp\Exception\GuzzleException;

$name = trim($_POST["name"] ?? '');
$job = trim($_POST["job"] ?? '');
$email = trim($_POST["email"] ?? '');
$phoneNumber = trim($_POST["phone_number"] ?? '');
$salary = trim($_POST["salary"] ?? '');
$company = trim($_POST["company_name"] ?? '');

if($name === "" || $job === "" || $email === "" || $phoneNumber === "" || $salary === "" || $company === "") {
    header('Location:public/index.php?postError=Everything must be filled.');
    exit;
}

if(!is_numeric($phoneNumber) || !is_numeric($salary)) {
    header('Location:public/index.php?postError=Phone and salary must be numeric.');
    exit;
}

$endpoint = API_URL . 'workers/';
$payload = [
    'name' => $name,
    'job' => $job,
    'email' => $email,
    'phone_number' => $phoneNumber,
    'salary' => $salary,
    'company' => $company,
];

try {
    $response = $client->request('POST', $endpoint, [
        'headers' => [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
        ],
        'json' => $payload,
    ]);

    $responseBody = $response->getBody()->getContents();
    $newWorker = json_decode($responseBody, true);

    if (!is_array($newWorker)) {
        die("Unexpected API response: " . $responseBody);
    }

    $status = $newWorker['status'] ?? null;
    $message = $newWorker['message'] ?? 'Unknown response.';
    $idWorker = $newWorker['id_worker'] ?? null;

    echo $status . " " . $message . " " . $idWorker . "\n";
} catch (GuzzleException $e) {
    // Részletesebb hibaüzenet a debugoláshoz
    $responseBody = $e->hasResponse() ? $e->getResponse()->getBody()->getContents() : '';
    die("API Hiba: " . $e->getMessage() . " <br> Válasz: " . $responseBody);
}
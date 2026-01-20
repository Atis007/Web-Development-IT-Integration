<?php
use GuzzleHttp\Exception\GuzzleException;

$id = isset($_POST['worker_id']) ? (int)$_POST['worker_id'] : 0;
$name = trim($_POST["worker_new_name"] ?? '');
$job = trim($_POST["worker_new_job"] ?? '');
$email = trim($_POST["worker_new_email"] ?? '');
$phoneNumber = trim($_POST["worker_new_phone_number"] ?? '');
$salary = trim($_POST["worker_new_salary"] ?? '');
$company = trim($_POST["worker_new_company_name"] ?? '');

if($id === 0){
    header('Location:public/index.php?patchError=Select one worker.');
    exit;
}

if($name === '' && $job === '' && $email === '' && $phoneNumber === '' && $salary === '' && $company === '') {
    header('Location:public/index.php?patchError=At least one of the following fields is required.');
    exit;
}

$salaryInvalid = ($salary !== '' && !ctype_digit($salary));
$phoneInvalid  = ($phoneNumber !== '' && !ctype_digit($phoneNumber));

if ($salaryInvalid || $phoneInvalid) {
    header('Location:public/index.php?patchError=Phone and salary must be whole numbers.');
    exit;
}

$urlPath = ($id > 0) ? 'workers/' . $id : 'workers';
$endpoint = API_URL . $urlPath;
$payload = [
    'id' => $id,
    'name' => $name,
    'job' => $job,
    'email' => $email,
    'phone_number' => $phoneNumber,
    'salary' => $salary,
    'company' => $company,
];

try {
    $response = $client->request('PATCH', $endpoint, [
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

    echo "$status . " . $message . " " . $idWorker . "\n";
} catch (GuzzleException $e) {
    // Részletesebb hibaüzenet a debugoláshoz
    $responseBody = $e->hasResponse() ? $e->getResponse()->getBody()->getContents() : '';
    die("API Hiba: " . $e->getMessage() . " <br> Válasz: " . $responseBody);
}
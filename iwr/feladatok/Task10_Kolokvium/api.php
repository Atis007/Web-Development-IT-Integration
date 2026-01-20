<?php

declare(strict_types=1);

require __DIR__ . '/includes/functions.php';

header('Content-Type: application/json; charset=UTF-8');

$pdo = $GLOBALS['pdo'];
// 1. URL Elemzése (Router)
$requestUri = $_SERVER['REQUEST_URI'];
// Levágjuk a query stringet (?error=...) ha van
$path = parse_url($requestUri, PHP_URL_PATH);
$segments = explode('/', trim($path, '/'));

// Megkeressük az "api" kulcsszót az URL-ben
$apiIndex = array_search('api', $segments);

if ($apiIndex === false || !isset($segments[$apiIndex + 1])) {
    http_response_code(404);
    echo json_encode(['error' => 'Endpoint not found']);
    exit;
}

$resource = $segments[$apiIndex + 1];

//token check
$headers = getallheaders();
$authHeader = $headers['Authorization'] ?? '';

if (preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
    $tokenValue = $matches[1];
} else {
    $tokenValue = '';
}

if (!validateToken($pdo, $tokenValue)) {
    http_response_code(401);
    echo json_encode(['message' => 'Token is not valid.']);
    exit;
}

if ($resource === 'workers') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        if (!$data) {
            http_response_code(400);
            echo json_encode(['status' => 400, 'error' => 'Invalid input data.']);
            exit;
        }

        $newWorkerData = insertWorker($pdo, $data);

        if ($newWorkerData['id']) {
            $qrFilePath = __DIR__ . '/qr_codes/number.png';
            if (file_exists($qrFilePath)) {
                unlink($qrFilePath);
            }
            createWorkerQrCode((int)$newWorkerData['id'], $newWorkerData['company']);

            http_response_code(201);
            echo json_encode([
                'status' => 201,
                'message' => 'Worker added successfully.',
                'id_worker' => $newWorkerData['id'],
            ]);
            exit;
        } else {
            http_response_code(500);
            echo json_encode(['status' => 500, 'message' => 'Failed to save worker to database.']);
            exit;
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'PATCH') {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        if (!$data) {
            http_response_code(400);
            echo json_encode(['status' => 400, 'error' => 'Invalid input data.']);
            exit;
        }

        $updatedWorker = updateWorker($pdo, (int)$data['id'], $data);

        if ($updatedWorker['id']) {
            $pattern = __DIR__ . '/qr_codes/' . $updatedWorker['id'] . '_*_*.png';
            $files = glob($pattern);
            if (!empty($files)) {
                $qrFilePath = $files[0];
            } else {
                $qrFilePath = null;
            }
            if ($qrFilePath !== null && file_exists($qrFilePath)) {
                unlink($qrFilePath);
            }
            createWorkerQrCode((int)$updatedWorker['id'], $updatedWorker['company']);

            http_response_code(200);
            echo json_encode([
                'status' => 200,
                'message' => 'Worker updated successfully.',
                'id_worker' => $updatedWorker['id'],
            ]);
            exit;
        } else {
            http_response_code(500);
            echo json_encode(['status' => 500, 'message' => 'Failed to save worker to database.']);
            exit;
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        // Adatok lekérése az adatbázisból
        // Itt újra felhasználhatod a getWorkers függvényedet!
        $workerId = isset($segments[$apiIndex + 2]) ? (int)$segments[$apiIndex + 2] : 0;

        $workers = getWorkers($GLOBALS['pdo'], $workerId);

        http_response_code(200);
        echo json_encode($workers); // Visszaküldjük JSON-ként a requests.php-nak
        exit;
    }

    http_response_code(405);
    echo json_encode(['status' => 405, 'message' => 'Method is not allowed for this resource.']);
    exit;
}

// Ha nem workers a végpont
http_response_code(404);
echo json_encode(['error' => 'Resource not found']);

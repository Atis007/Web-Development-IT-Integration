<?php
header("Content-Type: application/json; charset=UTF-8");
header("Allow: GET");

// http://localhost/iws_2025/06/API/3_example/api/product?table=product

$table = $_GET['table'] ?? "";

/**
 * Extract Bearer token from Authorization header if present.
 */
$authorizationHeader = '';

if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
    $authorizationHeader = $_SERVER['HTTP_AUTHORIZATION'];
} elseif (isset($_SERVER['REDIRECT_HTTP_AUTHORIZATION'])) {
    $authorizationHeader = $_SERVER['REDIRECT_HTTP_AUTHORIZATION'];
}

$token = '';
if (!empty($authorizationHeader)) {
    // "Bearer 1212121" => [0] = "Bearer", [1] = "1212121"
    $parts = explode(' ', $authorizationHeader);

    if (count($parts) === 2 && strtolower($parts[0]) === 'bearer') {
        $token = $parts[1];
    }
}

$method = strtolower($_SERVER['REQUEST_METHOD'] ?? '');

// Default values (just in case)
$status  = 500;
$message = "Unexpected error.";

// 1) Check HTTP method
if ($method !== 'get') {
    $status  = 405;
    $message = "Method Not Allowed.";
    http_response_code(405);
}
// 2) Check required parameter
elseif (empty($table)) {
    $status  = 400;
    $message = "Bad Request!";
    http_response_code(400);
}
// 3) Check token
elseif ($token !== "121212") {
    $status  = 401;
    $message = "Unauthorized.";
    http_response_code(401);
}
// 4) All good
else {
    $status  = 200;
    $message = "Statistics data fetched successfully. {$table}";
    http_response_code(200);
}

echo json_encode([
    "message" => $message,
    "status"  => $status,
    "token"   => $token,
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

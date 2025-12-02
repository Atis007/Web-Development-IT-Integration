<?php
header("Content-type: application/json; charset=UTF-8");

if (strtolower($_SERVER["REQUEST_METHOD"]) == "get") {
    $data = [
        ['product1' => 1],
        ['product2' => 2],
        ['product3' => 3],
        ['product4' => 4],
    ];
    $message = "Statistics data fetched successfully.";
    $status = 200;
    http_response_code(200);
} else {
    $message = $_SERVER["REQUEST_METHOD"] . " method is not allowed. Only GET is allowed.";
    $data = null;
    $status = 405;
    http_response_code(405);
}

echo json_encode([
    "message" => $message,
    "data" => $data,
    "status" => $status
]);
<?php
sleep(2);
header("Content-Type: application/json; charset=UTF-8");
header('Allow: GET');

$response = [
    "data" => null,
    "status" => 405,
    "message" => $_SERVER['REQUEST_METHOD'] . " is not allowed. Only GET method is allowed!"
];

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $response['data'] = [
        'school' => 'Vts',
        'city' => 'Subotica'
    ];
    $response['status'] = 200;
    $response['message'] = "Data fetched successfully.";
}
http_response_code($response['status']);
echo json_encode($response, JSON_UNESCAPED_UNICODE);
echo "VTS";
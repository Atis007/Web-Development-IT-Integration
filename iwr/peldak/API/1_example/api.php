<?php
header("Content-Type: application/json");
require "data.php";

if (!empty($_GET['name'])) {
    $name = $_GET['name'];
    $price = get_price($name);

    if ($price === null) {
        response(404, "Product Not Found", null);
    } else {
        response(200, "Product Found", $price);
    }
} else {
    response(400, "Invalid Request", null);
}

/**
 * Sends a JSON response with HTTP status code.
 *
 * @param int $status HTTP status code (e.g. 200, 400, 404)
 * @param string $status_message Short human-readable status message
 * @param mixed $data Payload data (can be null)
 *
 * @return void
 */
function response(int $status, string $status_message, mixed $data): void
{
    http_response_code($status);

    $response = [
        'status' => $status,
        'status_message' => $status_message,
        'data' => $data,
    ];

    echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
}


# http://localhost/iws_2025/06/API/1_example/api.php?name=book
# http://localhost/iws_2025/06/API/1_example/api/book
# http://localhost/iws_2025/06/API/1_example/api/books
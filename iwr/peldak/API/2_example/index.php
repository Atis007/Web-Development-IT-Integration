<?php
declare(strict_types=1);

spl_autoload_register(function ($class) {
    require __DIR__ . "/src/$class.php";
});

set_error_handler("ErrorHandler::handleError");
set_exception_handler("ErrorHandler::handleException");

header("Content-type: application/json; charset=UTF-8");

$parts = explode("/", $_SERVER["REQUEST_URI"]);

$position = array_search("products", $parts);

if (!$position) {
    http_response_code(404);
    exit;
}
$id = $parts[$position + 1] ?? null;

$database = new Database("localhost", "iws", "root", "");

$gateway = new ProductGateway($database);

$controller = new ProductController($gateway);

$controller->processRequest($_SERVER["REQUEST_METHOD"], $id);

# http://localhost/iws_2025/06/API/2_example/api/products/1
# http://localhost/iws_2025/06/api/2_example/api/books
# http://localhost/iws_2025/06/API/2_example/api/products

/*

PATCH
JSON
{
    "size":10
    }

DELETE
POST

*/

<?php
require_once __DIR__ . '/../../../config/config.php';
require_once PROJECT_ROOT . '/src/functions.php';
$action = $_POST['action'] ?? '';

if ($action !== 'create') {
    logEvent($GLOBALS['pdo'], 'product_create_failed', 'Invalid action');
    redirectFn('error', 'Invalid action.', 'admin/products');
}
$name = trim($_POST['name'] ?? '');
$description = trim($_POST['description'] ?? '');
$price = filter_var($_POST['price'] ?? null, FILTER_VALIDATE_INT);
$categoryId = filter_var($_POST['category_id'] ?? null, FILTER_VALIDATE_INT);

if ($name === '' || $price === false || $categoryId === false) {
    $statusMessage = 'Name, category, and price are required.';
    $statusType = 'error';
    logEvent($GLOBALS['pdo'], 'product_create_failed', 'Validation failed');
} else {
    $msg = createNewProduct($GLOBALS['pdo'], $categoryId, $name, $description, $price);
    $statusMessage = $msg['statusMessage'];
    $statusType = $msg['statusType'];
    logEvent($GLOBALS['pdo'], 'product_created', 'Name ' . $name . ' category ' . $categoryId);
}

redirectFn($statusType, $statusMessage, 'admin/products');
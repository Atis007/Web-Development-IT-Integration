<?php
$action = $_POST['action'] ?? '';

if ($action !== 'update') {
    logEvent($GLOBALS['pdo'], 'product_update_failed', 'Invalid action');
    redirectFn('error', 'Invalid action.', 'admin/products');
}
$productId = filter_var($_POST['product_id'] ?? null, FILTER_VALIDATE_INT);
$name = trim($_POST['name'] ?? '');
$description = trim($_POST['description'] ?? '');
$price = filter_var($_POST['price'] ?? null, FILTER_VALIDATE_INT);
$categoryId = filter_var($_POST['category_id'] ?? null, FILTER_VALIDATE_INT);

if ($productId === false || $name === '' || $price === false || $categoryId === false) {
    $statusMessage = 'Product, name, category, and price are required.';
    $statusType = 'error';
    logEvent($GLOBALS['pdo'], 'product_update_failed', 'Validation failed');
    redirectFn($statusType, $statusMessage, 'admin/products');
}

$msg = updateProduct($GLOBALS['pdo'], $productId, $categoryId, $name, $description, $price);
$statusMessage = $msg['statusMessage'];
$statusType = $msg['statusType'];

if ($statusType === 'success') {
    logEvent($GLOBALS['pdo'], 'product_updated', 'Product id ' . $productId);
} else {
    logEvent($GLOBALS['pdo'], 'product_update_failed', $statusMessage);
}

redirectFn($statusType, $statusMessage, 'admin/products');

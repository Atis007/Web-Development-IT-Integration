<?php
$action = $_POST['action'] ?? '';

if ($action !== 'delete') {
    logEvent($GLOBALS['pdo'], 'product_delete_failed', 'Invalid action');
    redirectFn('error', 'Invalid action.', 'admin/products');
}

$pdo = $GLOBALS['pdo'];
$productId = filter_var($_POST['product_id'] ?? null, FILTER_VALIDATE_INT);

if ($productId === false) {
    $statusMessage = 'Product is required.';
    $statusType = 'error';
    logEvent($GLOBALS['pdo'], 'product_delete_failed', 'Missing product id');
    redirectFn($statusType, $statusMessage, 'admin/products');
}

$msg = deleteProduct($GLOBALS['pdo'], $productId);
$statusMessage = $msg['statusMessage'];
$statusType = $msg['statusType'];

if ($statusType === 'success') {
    logEvent($GLOBALS['pdo'], 'product_deleted', 'Product id ' . $productId);
} else {
    logEvent($GLOBALS['pdo'], 'product_delete_failed', $statusMessage);
}

redirectFn($statusType, $statusMessage, 'admin/products');

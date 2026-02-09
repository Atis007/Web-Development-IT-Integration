<?php
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    logEvent($GLOBALS['pdo'], 'order_failed', 'Invalid method');
    redirectFn('orderError', "Only POST requests are allowed!", 'menu');
}

if (empty($_POST['items'])) {
    logEvent($GLOBALS['pdo'], 'order_failed', 'No items submitted');
    redirectFn('orderError', "No items were selected. Please choose at least one item to place an order.", 'menu');
}

$validItems = array_values(array_filter($_POST['items'], function ($item) {
    return isset($item['quantity']) && is_numeric($item['quantity']) && (int)$item['quantity'] > 0;
}));

if (empty($validItems)) {
    logEvent($GLOBALS['pdo'], 'order_failed', 'No valid items submitted');
    redirectFn('orderError', "No valid items were selected. Please choose at least one item if you want to place an order.", 'menu');
}

$title = 'Order Confirmation';
require PROJECT_ROOT . '/templates/header.php';

require_once PROJECT_ROOT . '/src/OrderProcess.php';

include PROJECT_ROOT . '/templates/footer.php';
?>
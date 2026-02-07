<?php
$title = 'Order Confirmation';
require PROJECT_ROOT . '/templates/header.php';

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    redirectFn('orderError', "Only POST requests are allowed!", 'menu');
}

if (empty($_POST['items'])) {
    redirectFn('orderError', "No items were selected. Please choose at least one item to place an order.", 'menu');
}

$validItems = array_values(array_filter($_POST['items'], function ($item) {
    return isset($item['quantity']) && is_numeric($item['quantity']) && (int)$item['quantity'] > 0;
}));

if (!empty($validItems)) {
    require_once PROJECT_ROOT . '/src/OrderProcess.php';
} else {
    redirectFn('orderError', "No valid items were selected. Please choose at least one item if you want to place an order.", 'menu');
}
?>

<?php include PROJECT_ROOT . '/templates/footer.php'; ?>
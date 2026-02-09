<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../functions.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$logUserId = isset($_SESSION['id_user']) ? (int)$_SESSION['id_user'] : 0;

header('Content-Type: application/json');
try {
    $input = json_decode(file_get_contents('php://input'), true);

    if (!is_array($input)) {
        throw new Exception("Empty data arrived!");
    }

    if (empty($_SESSION['id_user'])) {
        throw new Exception("User not logged in.");
    }

    if (empty($input['items']) || !is_array($input['items'])) {
        throw new Exception("Order items are missing.");
    }

    if (!isset($input['totalPrice']) || !is_numeric($input['totalPrice'])) {
        throw new Exception("Total price is missing or invalid.");
    }

    $pdo = $GLOBALS['pdo'];
    $userId = (int)$_SESSION['id_user'];
    $items = $input['items'];
    $totalPrice = (int)round((float)$input['totalPrice']);

    $newOrderId = createOrder($pdo, $userId, $items, $totalPrice);

    logEvent(
        $pdo,
        'order_created',
        'Order id ' . $newOrderId . ' user id ' . $userId . ' total ' . $totalPrice
    );

    echo json_encode(['status' => 'success', 'orderId' => $newOrderId]);
}catch (Exception $e) {
    if (isset($pdo) && $pdo->inTransaction()) $pdo->rollBack();
    if (isset($GLOBALS['pdo'])) {
        logEvent($GLOBALS['pdo'], 'order_failed', 'User id ' . $logUserId . ' ' . $e->getMessage());
    }
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
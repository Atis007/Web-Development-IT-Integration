<?php
require_once __DIR__ . '/../../config/config.php';
require_once PROJECT_ROOT . '/src/functions.php';

$action = $_POST['action'] ?? '';
if (!in_array($action, ACTIONS, true)) {
    logEvent($GLOBALS['pdo'], 'product_action_failed', 'Invalid action');
    header('Location: ' . BASE_URL);
    exit;
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['logged_in']) || ($_SESSION['role'] ?? '') !== 'admin') {
    logEvent($GLOBALS['pdo'], 'product_action_failed', 'Unauthorized access');
    header('Location: ' . BASE_URL);
    exit;
}

switch ($action) {
    case 'create':
        require __DIR__ . '/actions/product_create.php';
        break;
    case 'update':
        require __DIR__ . '/actions/product_update.php';
        break;
    case 'delete':
        require __DIR__ . '/actions/product_delete.php';
        break;
    default:
        logEvent($GLOBALS['pdo'], 'product_action_failed', 'Unknown action');
        header('Location: ' . BASE_URL);
        exit;
}

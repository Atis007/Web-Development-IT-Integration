<?php
declare(strict_types=1);

require __DIR__ . '/../../config/config.php';
require PROJECT_ROOT . '/src/functions.php';

if (session_status() === PHP_SESSION_NONE) {
	session_start();
}

if (empty($_SESSION['logged_in']) || ($_SESSION['role'] ?? '') !== 'admin') {
    header('Location: ' . BASE_URL);
    exit;
}

header('Location: ' . BASE_URL . 'admin/orders/orders.php');
exit;

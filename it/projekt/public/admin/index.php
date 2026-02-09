<?php
declare(strict_types=1);

require_once __DIR__ . '/../../config/config.php';
require_once PROJECT_ROOT . '/src/functions.php';

if (session_status() === PHP_SESSION_NONE) {
	session_start();
}

if (empty($_SESSION['logged_in']) || ($_SESSION['role'] ?? '') !== 'admin') {
    header('Location: ' . BASE_URL);
    exit;
}

header('Location: ' . BASE_URL . 'admin/orders');
exit;

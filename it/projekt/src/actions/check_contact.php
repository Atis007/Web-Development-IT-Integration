<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirectFn('contactError', 'Invalid request method.', 'contact');
}

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$message = trim($_POST['message'] ?? '');

if (empty($name) || empty($email) || empty($message)) {
    redirectFn('contactError', 'If you want to write to us, then fill in all fields.', 'contact');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    redirectFn('contactError', 'Invalid email address format.', 'contact');
}

$status = insertMessage($GLOBALS['pdo'], $name, $email, $message);

redirectFn($status['statusType'], $status['statusMessage'], 'contact');

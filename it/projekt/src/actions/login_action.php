<?php
require_once PROJECT_ROOT . '/src/functions.php';

$pdo = $GLOBALS['pdo'];

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    logEvent($pdo, 'login_failed', 'Invalid method');
    redirectFn('loginError', "Only POST requests are allowed!", 'login');
}

$pw = $_POST["password"] ?? "";
$email = trim($_POST["email"] ?? "");

if ($pw === "" || $email === "") {
    logEvent($pdo, 'login_failed', 'Missing email or password');
    redirectFn('loginError', "Must provide an email and password!", 'login');
}
$result = loginUser($GLOBALS['pdo'], $email, $pw);

if ($result === null) {
    logEvent($pdo, 'login_failed', 'Invalid credentials for ' . $email);
    redirectFn('loginError', "Email or password is invalid!", 'login');
}

$_SESSION["id_user"] = $result["id_user"];
$_SESSION["fullname"] = $result["fullname"];
$_SESSION["role"] = $result["role"];
$_SESSION["logged_in"] = true;

logEvent($pdo, 'login_success', 'User id ' . $result["id_user"] . ' logged in');

redirectFn('success', htmlspecialchars($result["fullname"]), '/');
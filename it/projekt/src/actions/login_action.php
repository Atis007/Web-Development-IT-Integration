<?php
require_once PROJECT_ROOT . '/src/functions.php';

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    redirectFn('loginError', "Only POST requests are allowed!", 'login');
}

$pw = $_POST["password"] ?? "";
$email = trim($_POST["email"]) ?? "";

if ($pw === "" || $email === "") {
    redirectFn('loginError', "Must provide an email and password!", 'login');
}
$result = loginUser($GLOBALS['pdo'], $email, $pw);

if ($result === null) {
    redirectFn('loginError', "Email or password is invalid!", 'login');
}

$_SESSION["id_user"] = $result["id_user"];
$_SESSION["fullname"] = $result["fullname"];
$_SESSION["role"] = $result["role"];
$_SESSION["logged_in"] = true;

redirectFn('success', htmlspecialchars($result["fullname"]), '/');
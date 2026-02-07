<?php
require_once PROJECT_ROOT . '/src/functions.php';

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    redirectFn('registerError', "Only POST requests are allowed!", 'register');
}

$fullName = trim($_POST["fullName"]) ?? "";
$email = trim($_POST["email"]) ?? "";
$pw = $_POST["password"] ?? "";
$pwAgain = $_POST["passwordAgain"] ?? "";

if ($fullName === "" || $email === "" || $pw === "" || $pwAgain === "") {
    redirectFn('registerError', "Everything must be filled out", 'register');
}

$result = registerUser($GLOBALS['pdo'], $email, $pw, $fullName);

if ($result === false) {
    redirectFn('registerError', "Something went wrong! Try again later.", 'register');
}

$_SESSION["id_user"] = $result;
$_SESSION["fullname"] = $fullName;
$_SESSION["role"] = "user";
$_SESSION["logged_in"] = true;

redirectFn('success', htmlspecialchars($fullName), '/');
<?php
require_once PROJECT_ROOT . '/src/functions.php';

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    redirectFn('registerError', "Only POST requests are allowed!", 'register');
}

$fullName = trim($_POST["fullName"] ?? "");
$email = trim($_POST["email"] ?? "");
$pw = $_POST["password"] ?? "";
$pwAgain = $_POST["passwordAgain"] ?? "";

if ($fullName === "" || $email === "" || $pw === "" || $pwAgain === "") {
    redirectFn('registerError', "Everything must be filled out", 'register');
}

if(filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
    redirectFn('registerError', "Invalid email format", 'register');
}

/*
^ asserts the start of the string.
(?=.*[a-z]) ensures at least one lowercase letter is present.
(?=.*[A-Z]) ensures at least one uppercase letter is present.
(?=.*\d) ensures at least one digit is present (equivalent to [0-9]).
(?=.*[\W]) ensures at least one non-word character (special character) is present. Note that \W includes _ (underscore).
(?=.*[^\s]) ensures no whitespace characters are allowed.
.{8,} requires a minimum of eight characters in total.
$ asserts the end of the string. 
this regex ensures that the password is strong by enforcing the presence of various character types and a minimum length, while also disallowing whitespace.
*/
$pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W])(?=.*[^\s]).{8,}$/';
if (!preg_match($pattern, $pw)) {
    $msg = "Password must be at least 8 characters long. Also include uppercase letters, lowercase letters, numbers, and special characters.";
    redirectFn('registerError', $msg, 'register');
}

if ($pw !== $pwAgain) {
    redirectFn('registerError', "Passwords do not match", 'register');
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
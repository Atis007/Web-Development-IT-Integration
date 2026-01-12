<?php
session_start();
require 'includes/functions.php';
$pdo = $GLOBALS["pdo"];
if($_SERVER["REQUEST_METHOD"] !== "POST"){
    redirectFn('',"Only POST requests are allowed!");
}

$pw = $_POST["password"];
$email = trim($_POST["email"]);

if($pw === "" || $email === ""){
    redirectFn('',"Must provide an email and password!");
}
$result = loginUser($pdo, $email, $pw);

if($result === null){
    redirectFn('',"Email, password or status is invalid!");
}

$_SESSION["id_user"] = $result["id_user"];
$_SESSION["role"] = $result["role"];

header("Location: panel.php");
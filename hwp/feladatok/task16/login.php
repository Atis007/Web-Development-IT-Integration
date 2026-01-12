<?php
session_start();
require 'includes/functions.php';
$pdo = $GLOBALS["pdo"];
if($_SERVER["REQUEST_METHOD"] !== "POST"){
    redirectFn("Only POST requests are allowed!");
}

$pw = trim($_POST["password"]);
$user = trim($_POST["username"]);

if($pw === "" || $user === ""){
    redirectFn("Must provide a username and password!");
}
$result = checkUserExist($pdo, $user, $pw);

$_SESSION["id_user"] = $result["id_user"];
$_SESSION["level"] = $result["level"];
$_SESSION["name"] = $result["name"];

if($result["id_user"] !== null){
    if($result["level"] === "admin"){
        header("Location: admin.php");
    } else {
        header("Location: photos.php");
    }
    exit;
}

echo $result['message'];
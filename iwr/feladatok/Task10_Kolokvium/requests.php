<?php
require "includes/functions.php";

if($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location:index.php?error=Only POST requests are allowed');
    exit;
}

$formMethod = $_POST["METHOD"] ?? '';

if(!in_array($formMethod, $GLOBALS['method'], true)) {
    header('Location:index.php?error=Invalid action requested');
    exit;
}
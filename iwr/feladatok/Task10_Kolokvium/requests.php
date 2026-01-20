<?php
$title="Requests";
require "includes/header.php";
require "includes/functions.php";

use Detection\MobileDetect;
use GuzzleHttp\Client;

$detect = new MobileDetect();
$client = new Client();

$ip = get_client_ip();
$operationSystem = $detect->isiOS() ? 'ios' : ($detect->isAndroidOS() ? 'android' : 'other');
$deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');
$userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
//insertDetectData($GLOBALS['pdo'], $ip, $operationSystem, $deviceType, $userAgent);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location:public/index.php?error=Only POST requests are allowed');
    exit;
}

$formMethod = $_POST["METHOD"] ?? '';

if (!in_array($formMethod, $GLOBALS['method'], true)) {
    header('Location:public/index.php?error=Method is not allowed.');
    exit;
}

$token = getFirstToken($GLOBALS['pdo']);

if (!$token) {
    die("Hiba: Nincs érvényes token az adatbázisban!");
}

switch($formMethod) {
    case 'GET':
        require "actions/get_handler.php";
        break;
    case 'POST':
        require "actions/post_handler.php";
        break;
    case 'PATCH':
        require "actions/patch_handler.php";
        break;
    default:
        header('Location:public/index.php?error=Invalid action requested');
        exit;
}
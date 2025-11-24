<?php
require __DIR__ . '/vendor/autoload.php';

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\ErrorCorrectionLevel;

// WiFi settings
$ssid = 'MyWiFi';
$password = 'myPassword123';
$encryption = 'WPA'; // WPA, WEP, nopass

// WiFi QR format
$data = "WIFI:T:$encryption;S:$ssid;P:$password;;";

// PNG writer
$writer = new PngWriter();

// QR code
$qrCode = new QrCode(
    data: $data,
    errorCorrectionLevel: ErrorCorrectionLevel::High,
    size: 300,
    margin: 10
);

$result = $writer->write($qrCode);

// Output PNG
header('Content-Type: '.$result->getMimeType());
echo $result->getString();
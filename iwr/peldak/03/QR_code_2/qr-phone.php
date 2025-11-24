<?php
require __DIR__ . '/vendor/autoload.php';

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\ErrorCorrectionLevel;

// Telephone URI format
$phone = 'tel:+381641234567';

// PNG writer
$writer = new PngWriter();

// QR code object
$qrCode = new QrCode(
    data: $phone,
    errorCorrectionLevel: ErrorCorrectionLevel::High,
    size: 300,
    margin: 10
);

$result = $writer->write($qrCode);

// Output as PNG
header('Content-Type: '.$result->getMimeType());
echo $result->getString();
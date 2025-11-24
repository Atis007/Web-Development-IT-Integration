<?php
require __DIR__ . '/vendor/autoload.php';

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\ErrorCorrectionLevel;

// Target URL
$url = 'https://vts.su.ac.rs';

// Create PNG writer
$writer = new PngWriter();

// Create QR code object
$qrCode = new QrCode(
    data: $url,
    errorCorrectionLevel: ErrorCorrectionLevel::High,
    size: 300,
    margin: 10
);

// Generate image
$result = $writer->write($qrCode);

// Show PNG in browser
header('Content-Type: '.$result->getMimeType());
echo $result->getString();
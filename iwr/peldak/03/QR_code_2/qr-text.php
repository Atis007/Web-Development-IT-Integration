<?php
require __DIR__ . '/vendor/autoload.php';

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\ErrorCorrectionLevel;

$writer = new PngWriter();

$qrCode = new QrCode(
    data: 'Hello from VTS Subotica!',
    errorCorrectionLevel: ErrorCorrectionLevel::High, // L, M, Q, H
    size: 300,
    margin: 10
);

/*
LOW
MEDIUM
QUARTILE
HIGH
*/

// Build PNG output
$result = $writer->write($qrCode);

// Output image
header('Content-Type: '.$result->getMimeType());
echo $result->getString();
<?php
require __DIR__ . '/vendor/autoload.php';

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\ErrorCorrectionLevel;

$data = 'https://vts.su.ac.rs';

$qrCode = new QrCode(
    data: $data,
    errorCorrectionLevel: ErrorCorrectionLevel::Low,
    size: 300,
    margin: 10
);


$writer = new PngWriter();

$result = $writer->write($qrCode);

// Path to save the generated file
$filename = __DIR__ . '/codes/vts_qr.png';

// Save the image file to the "codes" directory
file_put_contents($filename, $result->getString());

// Output confirmation
echo "QR code has been successfully saved to: <strong>$filename</strong>";
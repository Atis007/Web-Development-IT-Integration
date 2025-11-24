<?php
require __DIR__ . '/vendor/autoload.php';

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\ErrorCorrectionLevel;

// Data to encode
$data = 'https://vts.su.ac.rs';

// PNG writer
$writer = new PngWriter();

// Create QR object
$qrCode = new QrCode(
    data: $data,
    errorCorrectionLevel: ErrorCorrectionLevel::High,
    size: 300,
    margin: 10
);

// Build PNG image
$result = $writer->write($qrCode);

// Unique filename
$filename = 'qr_' . uniqid() . '.png';

// Full path
$fullPath = __DIR__ . '/codes/' . $filename;

// Save file
file_put_contents($fullPath, $result->getString());

// Show confirmation + display QR image
echo "<h3>QR code generated and saved as: $filename</h3>";
echo "<img src='codes/$filename' alt='QR Code'>";
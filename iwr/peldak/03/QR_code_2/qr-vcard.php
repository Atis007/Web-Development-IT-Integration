<?php
require __DIR__ . '/vendor/autoload.php';

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\ErrorCorrectionLevel;

// vCard 3.0 format with fictional English data
$vcard  = "BEGIN:VCARD\n";
$vcard .= "VERSION:3.0\n";
$vcard .= "N:Smith;John;;Mr.;\n";
$vcard .= "FN:Mr. John Smith\n";
$vcard .= "ORG:Tech Future Innovations\n";
$vcard .= "TITLE:Senior Software Engineer\n";
$vcard .= "TEL;TYPE=CELL:+1-202-555-0147\n";
$vcard .= "EMAIL:john.smith@example.com\n";
$vcard .= "URL:https://www.techfuture.example.com\n";
$vcard .= "ADR;TYPE=WORK:;;123 Innovation Drive;New York;NY;10001;USA\n";
$vcard .= "END:VCARD";

// PNG writer
$writer = new PngWriter();

// QR object
$qrCode = new QrCode(
    data: $vcard,
    errorCorrectionLevel: ErrorCorrectionLevel::Low,
    size: 300,
    margin: 10
);

$result = $writer->write($qrCode);

// Output PNG
header('Content-Type: '.$result->getMimeType());
echo $result->getString();
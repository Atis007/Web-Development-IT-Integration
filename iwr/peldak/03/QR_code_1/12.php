<?php

require 'phpqrcode/qrlib.php';

$name = "Someone";
$surname = "The Someone";
$company = "PHP";
$position = "programmer";
$email = "some@php.net";
$phone = "+381641111222";

$vCardData = "BEGIN:VCARD\n";
$vCardData .= "VERSION:3.0\n";
$vCardData .= "N:$surname;$name;;;\n";
$vCardData .= "FN:$name $surname\n";
$vCardData .= "ORG:$company\n";
$vCardData .= "TITLE:$position\n";
$vCardData .= "EMAIL:$email\n";
$vCardData .= "TEL:$phone\n";
$vCardData .= "END:VCARD";


$qrFilePath = 'codes/' . uniqid() . '.png';
QRcode::png($vCardData, $qrFilePath, QR_ECLEVEL_L, 4);

echo "<h3>Visit card</h3>";
echo "<img src='$qrFilePath' alt='QR Kod'>";

<?php

require 'phpqrcode/qrlib.php';

require 'config.php';


// how to build raw content - QRCode to call phone number

$tempDir = EXAMPLE_TMP_SERVERPATH;

// here our data
$url = 'https://www.vts.su.ac.rs';

// we building raw data
$codeContents = $url;
//$codeContents = 'url:' . $url;

// generating
QRcode::png($codeContents, $tempDir . 'vts.png', QR_ECLEVEL_L, 8);

// displaying
echo '<img src="' . EXAMPLE_TMP_URLRELPATH . 'vts.png" alt="qr code">';
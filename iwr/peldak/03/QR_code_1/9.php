<?php

require 'phpqrcode/qrlib.php';

require 'config.php';


// how to build raw content - QRCode to call phone number

$tempDir = EXAMPLE_TMP_SERVERPATH;

// here our data
$phoneNo = '(069)033312-345-678';

// we building raw data
$codeContents = 'tel:' . $phoneNo;

// generating
QRcode::png($codeContents, $tempDir . '9.png', QR_ECLEVEL_L, 10);

// displaying
echo '<img src="' . EXAMPLE_TMP_URLRELPATH . '9.png" alt="qr code">';
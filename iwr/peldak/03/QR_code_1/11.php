<?php

require 'phpqrcode/qrlib.php';

require 'config.php';


$tempDir = EXAMPLE_TMP_SERVERPATH;

// here your data
$phoneNo = '(064)22344';

// we building raw data
$codeContents = 'sms:' . $phoneNo;

// generating
QRcode::png($codeContents, $tempDir . '11.png', QR_ECLEVEL_L, 10);

// displaying
echo '<img src="' . EXAMPLE_TMP_URLRELPATH . '11.png" alt="qr code">';
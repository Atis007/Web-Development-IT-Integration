<?php

// 3.php?id=vts
// 3.php?id=2345


require 'phpqrcode/qrlib.php';

$param = 0;

if (isset($_GET['id'])) {
    $param = (int)$_GET['id'];
}

//$param = mt_rand(200, 4000);

// 3.php?id=255
// remember to sanitize that - it is user input!

// we need to be sure ours script does not output anything!!!
// otherwise it will break up PNG binary!

ob_start();

// ob_start("callback");

// here DB request or some processing
$codeText = 'DEMO - ' . $param;
echo "VTS";

// end of processing here

$debugLog = ob_get_contents();
ob_end_clean();

// outputs image directly into browser, as PNG stream
QRcode::png($codeText);
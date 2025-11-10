<?php
// Mobile Detect examples:
// http://mobiledetect.net/
// http://demo.mobiledetect.net/
// https://github.com/serbanghita/Mobile-Detect/wiki/Code-examples

require __DIR__ . '/vendor/autoload.php';

use Detection\MobileDetect;

$detect = new MobileDetect();

// Determine device type
$deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');

echo "<!DOCTYPE html><html><head><meta charset='UTF-8'><title>Mobile Detect Demo</title></head><body>";

if ($deviceType === "phone" || $deviceType === "tablet") {
    echo "You are using a <b>$deviceType</b>!";

    if ($detect->isiOS()) {
        echo "<br>Your device runs <b>iOS</b>.";
    }

    if ($detect->isAndroidOS()) {
        echo "<br>Your device runs <b>Android</b>.";
    }

} else {
    echo "You are using a <b>computer</b>!";
}

echo "</body></html>";
<?php
$header_ua = strtolower($_SERVER['HTTP_USER_AGENT'] ?? '');
$keywords = ["ipad", "nokia", "touch", "samsung", "sonyericsson", "alcatel", "panasonic",
    "tosh", "benq", "sagem", "android", "iphone", "berry", "palm", "mobi",
    "lg", "symb", "kindle", "phone"];

$mobile = false;
$match = "";

foreach ($keywords as $keyword) {
    if (strpos($header_ua, $keyword) !== false) {
        $mobile = true;
        $match = $keyword;
        break;
    }
}

echo "<p><b>User agent string:</b> " . htmlspecialchars($header_ua, ENT_QUOTES, 'UTF-8') . "</p>";

if ($mobile) {
    echo "<p>You are using a mobile device. (search term: $match)</p>";
    //header("Location: https://m.example.com");
    //exit();
} else {
    echo "<p>You are not using a mobile device.</p>";
}
<?php
$header_ua = strtolower(htmlspecialchars($_SERVER['HTTP_USER_AGENT'] ?? '', ENT_QUOTES, 'UTF-8'));
$keywords = [
    "nokia", "touch", "samsung", "sonyericsson", "alcatel", "panasonic",
    "tosh", "benq", "sagem", "android", "iphone", "berry", "palm",
    "mobi", "lg", "symb", "kindle", "phone"
];
$mobile = false;
$match = "";

// str_contains() returns true if the substring is found (PHP 8+)
foreach ($keywords as $keyword) {
    if (str_contains($header_ua, $keyword)) {
        $mobile = true;
        $match = $keyword;
        break;
    }
}

echo "<p><b>User agent string:</b> $header_ua</p>";

if ($mobile) {
    echo "<p>You are using a mobile device. (search term: $match)</p>";
    //header("Location: mobile.php");
    //exit();
} else {
    echo "<p>You are not using a mobile device.</p>";
}
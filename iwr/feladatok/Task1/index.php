<?php
require __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/config.php';
require __DIR__ . '/functions.php';

use Detection\MobileDetect;

if(!isset($_COOKIE['VISITED'])) {
    $detect = new MobileDetect();
    $deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');
    $userAgent = $_SERVER['HTTP_USER_AGENT'];
    $ipAddress = getIpAddress();
    $ipAddress = "103.14.26.0";

    $url = "https://proxycheck.io/v2/$ipAddress?vpn=1&asn=1";
    $response = getCurlData($url);
    $data = json_decode($response, true);

    if ($data && isset($data[$ipAddress])) {
        $info = $data[$ipAddress];
        $country = $info['country'] ?? 'N/A';
        $proxy = ($info['proxy'] ?? 'no') === 'yes' ? '1' : '0';
        $isp = $info['provider'] ?? 'N/A';
    } else {
        echo "Request failed<hr>";
    }

//var_dump($deviceType, $userAgent, $ipAddress, $country, $proxy, $isp);
    insertIntoLog($pdo, $userAgent, $ipAddress, $deviceType, $country, $proxy, $isp);
    setCookie('VISITED', 'YES', time() + 10, '/');
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<a href="show_logs.php">Go to logs</a>
</body>
</html>

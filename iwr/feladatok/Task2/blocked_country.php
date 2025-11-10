<?php
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/includes/functions.php';
require __DIR__ . '/config.php';

use Detection\MobileDetect;

$detect = new MobileDetect();

/**
 * ips for test:
 * Colombia: "181.49.0.1"
 * Mexico: "201.144.0.1"
 */

$pdo = connectDatabase($dsn, $pdoOptions);
//$ip = '201.144.0.1';
$ip = get_client_ip();

if(is_blocked_country($ip)): {
    $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
    $deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');
    insertIntoLog($pdo, $userAgent, $ip, $deviceType);
    ?>
    <h1><b><?php echo "Access denied for your country!"; ?></b></h1>
    <?php exit;
} endif;
?>
<?php

$pdo = connectDatabase($dsn, $pdoOptions);

/** Function tries to connect to database using PDO
 * @param string $dsn
 * @param array $pdoOptions
 * @return PDO
 */
function connectDatabase(string $dsn, array $pdoOptions): PDO
{

    try {
        $pdo = new PDO($dsn, PARAMS['USER'], PARAMS['PASSWORD'], $pdoOptions);
    } catch (\PDOException $e) {
        var_dump($e->getCode());
        throw new \PDOException($e->getMessage());
    }

    return $pdo;
}


function getIpAddress(): string
{

    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }

    if (!filter_var($ip, FILTER_VALIDATE_IP)) {
        $ip = "unknown";
    }


    return $ip;
}


/**
 * Detects the client's IP address from HTTP headers.
 * This function returns the first valid IP found, or 'unknown' if no valid IP is detected.
 * Note: Do not trust forwarded headers unless you are behind a trusted proxy.
 */
function getIpAddressTwo(bool $preferForwarded = false): string
{
    $remote = $_SERVER['REMOTE_ADDR'] ?? '';

    if (!$preferForwarded) {
        return filter_var($remote, FILTER_VALIDATE_IP) ? $remote : 'unknown';
    }

    // Collect potential IPs from headers
    $candidates = [];
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        // Often contains a list: "client, proxy1, proxy2"
        $parts = array_map('trim', explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']));
        $candidates = array_merge($candidates, $parts);
    }
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $candidates[] = trim($_SERVER['HTTP_CLIENT_IP']);
    }
    if (!empty($remote)) {
        $candidates[] = $remote;
    }

    // Return the first valid IP (IPv4 or IPv6)
    foreach ($candidates as $ip) {
        if (filter_var($ip, FILTER_VALIDATE_IP)) {
            return $ip;
        }
    }

    return 'unknown';
}

function insertIntoLog(PDO $pdo, string $userAgent, string $ipAddress, string $deviceType, string $country, string $proxy, string $isp): void
{
    $sql = "INSERT INTO task1(user_agent, ip_address, country, proxy, device_type, isp) VALUES(?, ?, ?, ?, ?, ?)";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(1, $userAgent, PDO::PARAM_STR);
    $stmt->bindValue(2, $ipAddress, PDO::PARAM_STR);
    $stmt->bindValue(3, $country, PDO::PARAM_STR);
    $stmt->bindValue(4, $proxy, PDO::PARAM_INT);
    $stmt->bindValue(5, $deviceType, PDO::PARAM_STR);
    $stmt->bindValue(6, $isp, PDO::PARAM_STR);

    $stmt->execute();
}

function getLogData(PDO $pdo): array
{
    $sql = "SELECT user_agent, country, proxy, ip_address, device_type, DATE_FORMAT(date_time, '%d.%m.%Y. %T') as date FROM task1 ORDER BY date_time DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $result;
}

function getCurlData($url): string
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($ch);
    curl_close($ch);

    return $result;
}
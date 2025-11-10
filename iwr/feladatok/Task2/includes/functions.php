<?php
require __DIR__ . '/../vendor/autoload.php';

use IPLocate\IPLocate;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

/** Function tries to connect to database using PDO
 * @param string $dsn
 * @param array $pdoOptions
 * @return PDO
 */
function connectDatabase(string $dsn, array $pdoOptions): PDO
{
    try {
        $pdo = new PDO($dsn, PARAMS['USER'], PARAMS['PASSWORD'], $pdoOptions);
    } catch (PDOException $e) {
        var_dump($e->getCode());
        throw new PDOException($e->getMessage());
    }
    return $pdo;
}

function insertIntoLog(PDO $pdo, string $userAgent, string $ipAddress, string $deviceType): void
{
    $sql = "INSERT INTO task2(user_agent, ip_address, device_type) VALUES(?, ?, ?)";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(1, $userAgent, PDO::PARAM_STR);
    $stmt->bindValue(2, $ipAddress, PDO::PARAM_STR);
    $stmt->bindValue(3, $deviceType, PDO::PARAM_STR);

    $stmt->execute();
}

function getLogData(PDO $pdo): array
{
    $sql = "SELECT user_agent, ip_address, device_type, DATE_FORMAT(date_time, '%d.%m.%Y. %T') as date FROM task2 ORDER BY date_time DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $result;
}

function get_client_ip(): string
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    }
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ipList = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        return trim($ipList[0]);
    }
    return $_SERVER['REMOTE_ADDR'] ?? 'unknown';
}

function is_blocked_country(?string $ip ): bool {
    $apiKey = $_ENV['IPLOCATE_API_KEY'] ?? null;
    if (!$apiKey || !$ip) return false;

    $client = new IPLocate($apiKey);
    $result = $client->lookup($ip);

    $countryCode = strtoupper($result->countryCode ?? '');
    return in_array($countryCode, ['MX','CO']);
}
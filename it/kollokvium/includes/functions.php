<?php

declare(strict_types=1);

use Faker\Factory;

require __DIR__ . '/config.php';
require __DIR__ . '/../phpqrcode/qrlib.php';

$GLOBALS['pdo'] = databaseConnect($dsn, $pdoOptions);

function databaseConnect(string $dsn, array $pdoOptions): PDO
{
    try {
        $pdo = new PDO($dsn, PARAMS['USER'], PARAMS['PASSWORD'], $pdoOptions);
    } catch (PDOException $e) {
        var_dump($e->getCode());
        throw new PDOException($e->getMessage());
    }

    return $pdo;
}

function tokenTableInsert(PDO $pdo, string $token, string $expire): void
{
    $sql = "INSERT INTO tokens (token, date_expires, date_time) VALUES (:token, :expires_at, NOW())";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':token' => $token,
        ':expires_at' => $expire
    ]);
}

function createQrCode(string $randomString): void
{
    $vCardData = "BEGIN:VCARD\n";
    $vCardData .= "VERSION:3.0\n";
    $vCardData .= "N:$randomString\n";
    $vCardData .= "END:VCARD";

    // the server and url path comes from the config file
    $dir = SERVERPATH;

    // 1. Ellenőrizzük, létezik-e a mappa, ha nem, hozzuk létre
    if (!is_dir($dir)) {
        if (!mkdir($dir, 0775, true)) {
            die("Hiba: Nem sikerült létrehozni a mappát: $dir");
        }
    }

    $filename = 'number.png';
    $fullPath = $dir . $filename;
    QRcode::png($vCardData, $fullPath, QR_ECLEVEL_L, 4);
}

function createWorkerQrCode(int $id, string $company): string
{
    $faker = Factory::create();
    $randomNumber = $faker->numberBetween(100, 9999);
    $md = md5($company);
    $qrContent = "{$id}_{$randomNumber}_{$md}";

    // the server and url path comes from the config file
    $dir = SERVERPATH;
    //2_456_5f532a3fc4f1ea403f37070f59a7a53a.png
    $filename = $id . '_' . $randomNumber . '_' . $md . '.png';
    $fullPath = $dir . $filename;
    QRcode::png($qrContent, $fullPath, QR_ECLEVEL_L, 4);

    return $filename;
}

function insertQrCode(PDO $pdo, int $id, string $filename): void
{
    $sql = "UPDATE workers SET qr_code = :filename WHERE id_worker = :id";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':id' => $id,
        ':filename' => $filename
    ]);
}

function getWorkers(PDO $pdo, int $id = 0): array
{
    $sql = "SELECT id_worker, name, company_name FROM workers";
    if ($id !== 0) {
        $sql .= " WHERE id_worker = :id";
    }
    $stmt = $pdo->prepare($sql);
    if ($id !== 0) {
        $stmt->execute(['id' => $id]);
    } else {
        $stmt->execute();
    }
    //Ha konkrét ID-t kértünk, elég egy sort visszaadni (fetch), egyébként mindet (fetchAll)
    return $stmt->fetchAll();
}

function insertWorkers(PDO $pdo, string $name, string $job, string $email, string $phone, int $salary, string $company): void
{
    $sql = "INSERT INTO workers(name, job, email, phone_number, salary, company_name, date_time) VALUES (:name, :job, :email, :phone, :salary, :company, NOW())";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':name' => $name,
        ':job' => $job,
        ':email' => $email,
        ':phone' => $phone,
        ':salary' => $salary,
        ':company' => $company
    ]);
}

function insertWorker(PDO $pdo, array $worker): array
{
    $sql = "INSERT INTO workers(name, job, email, phone_number, salary, company_name, date_time) VALUES (:name, :job, :email, :phone, :salary, :company, NOW())";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':name' => $worker['name'],
        ':job' => $worker['job'],
        ':email' => $worker['email'],
        ':phone' => $worker['phone_number'],
        ':salary' => $worker['salary'],
        ':company' => $worker['company']
    ]);

    return [
        'id' => $pdo->lastInsertId(),
        'company' => $worker['company']
    ];
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

function insertDetectData(PDO $pdo, string $ip, string $operationSystem, string $deviceType, string $userAgent): void
{
    $sql = "INSERT INTO detects(ip_address, operation_system, device_type, http_user_agent, date_time) VALUES (:ip, :operation_system, :device_type, :userAgent, NOW())";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':ip' => $ip,
        ':operation_system' => $operationSystem,
        ':device_type' => $deviceType,
        ':userAgent' => $userAgent
    ]);
}

function getFirstToken(PDO $pdo): string
{
    $sql = "SELECT token FROM tokens ORDER BY id_token LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_COLUMN);

    return $result ?? '';
}

function validateToken(PDO $pdo, string $token): bool
{
    $sql = "SELECT date_expires FROM tokens WHERE token = :token";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['token' => $token]);

    $result = $stmt->fetch(PDO::FETCH_COLUMN);

    if (!$result) {
        return false;
    }

    $now = new DateTime();
    $expires = new DateTime($result);

    return $now < $expires;
}

function updateWorker(PDO $pdo, int $id, array $data): array
{
    $fields = [];
    $params = [':id' => $id];

    if (!empty($data['name'])) {
        $fields[] = "name = :name";
        $params[':name'] = $data['name'];
    }
    if (!empty($data['job'])) {
        $fields[] = "job = :job";
        $params[':job'] = $data['job'];
    }
    if (!empty($data['email'])) {
        $fields[] = "email = :email";
        $params[':email'] = $data['email'];
    }
    if (!empty($data['phone_number'])) {
        $fields[] = "phone_number = :phone_number";
        $params[':phone_number'] = $data['phone_number'];
    }
    if (!empty($data['salary'])) {
        $fields[] = "salary = :salary";
        $params[':salary'] = $data['salary'];
    }
    if (!empty($data['company'])) {
        $fields[] = "company_name = :company";
        $params[':company'] = $data['company'];
    }

    if (empty($fields)) {
        return ['id' => $id, 'company' => $data['company'] ?? ''];
    }

    // A mezőket vesszővel összefűzzük
    $sql = "UPDATE workers SET " . implode(', ', $fields) . " WHERE id_worker = :id";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    return [
        'id' => $id,
        'company' => $data['company']
    ];
}

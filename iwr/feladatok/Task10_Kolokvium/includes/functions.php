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

function tokenTableInsert(PDO $pdo, string $token, string $expire): void{
    $sql = "INSERT INTO tokens (token, date_expires, date_time) VALUES (:token, :expires_at, NOW())";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':token' => $token,
        ':expires_at' => $expire
    ]);
}

function createQrCode(string $randomString): void{
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

function createWorkerQrCode(int $id, string $company): string{
    $faker = Factory::create();
    $randomNumber = $faker->numberBetween(100,9999);
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

function insertQrCode(PDO $pdo, int $id, string $filename): void{
    $sql = "UPDATE workers SET qr_code = :filename WHERE id_worker = :id";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':id' => $id,
        ':filename' => $filename
    ]);
}

function getWorkers(PDO $pdo){
    $sql = "SELECT id_worker, name, company_name FROM workers";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
}

function insertWorkers(PDO $pdo, string $name, string $job, string $email, string $phone, int $salary, string $company): void{
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
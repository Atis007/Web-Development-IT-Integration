<?php
declare(strict_types=1);
require 'phpqrcode/qrlib.php';
require_once 'classes.php';

/**
 * Function tries to connect to database using PDO.
 *
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

function generateWorkers(int $count=20): array{
    $faker = Faker\Factory::create('hu_HU');
    $workers = [];

    for ($i = 0; $i < $count; $i++) {
        $w = new Worker();
        $w->name = $faker->firstName();
        $w->surname = $faker->lastName();
        $w->company = $faker->company();
        $w->position = $faker->jobTitle();
        $w->email = $faker->unique()->email();
        $w->phone = $faker->phoneNumber();
        //$w->created_at = date("Y-m-d H:i:s");
        $w->created_at = $faker->dateTimeBetween('2000-01-01 0:0:0', '2024-01-01 23:59:59')->format('Y-m-d H:i:s');
        $w->updated_at = $faker->dateTimeBetween('2025-01-01 0:0:0', 'now')->format('Y-m-d H:i:s');

        $workers[] = $w;
    }

    return $workers;
}

function insertWorkers(PDO $pdo, Worker $w): int{
    $sql = "INSERT INTO workers (name, surname, company, position, email, phone, created_at, updated_at) VALUES (?,?,?,?,?,?,?,?)";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        $w->name,
        $w->surname,
        $w->company,
        $w->position,
        $w->email,
        $w->phone,
        $w->created_at,
        $w->updated_at
    ]);

    $id = (int)$pdo->lastInsertId();
    $w->id_worker = $id;

    return  $id;// returning the id_worker for qrcode generating purposes
}


function createQrCode(Worker $w): string{
    $vCardData = "BEGIN:VCARD\n";
    $vCardData .= "VERSION:3.0\n";
    $vCardData .= "N:$w->surname;$w->name;;;\n";
    $vCardData .= "FN:" . $w->name . ' ' .$w->surname . "\n";
    $vCardData .= "ORG:$w->company\n";
    $vCardData .= "TITLE:$w->position\n";
    $vCardData .= "EMAIL:$w->email\n";
    $vCardData .= "TEL:$w->phone\n";
    $vCardData .= "END:VCARD";

    // the server and url path comes from the config file
    $dir = SERVERPATH;
    $filename = uniqid('Qr') . '.png';
    $fullPath = $dir . $filename;
    QRcode::png($vCardData, $fullPath, QR_ECLEVEL_L, 4);

    return $filename;
}

function insertQrCode(PDO $pdo, QrCodeData $qr): void{
    $sql = "INSERT INTO qr_codes (id_worker, name, generated_at, updated_at) VALUES (?,?,?,?)";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        $qr->id_worker,
        $qr->name,
        $qr->generated_at,
        $qr->updated_at
    ]);
}

function getWorkersWithQr(PDO $pdo): array{
    $sql = "SELECT CONCAT(w.name, ' ', w.surname) AS name, w.company, w.position, w.email, w.phone, q.name AS qr_filename FROM workers w LEFT JOIN qr_codes q ON q.id_worker = w.id_worker";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll();
}

function deleteOldFile($fileName) {
    $path = SERVERPATH . $fileName;

    if (!$fileName || !file_exists($path)) {
        return false;
    }
    unlink($path);
    return true;
}

function updateCode(PDO $pdo, int $workerId, string $newFileName): bool {
    $sql = "UPDATE qr_codes 
            SET name = ?, updated_at = NOW()
            WHERE id_worker = ?";

    $stmt = $pdo->prepare($sql);

    return $stmt->execute([$newFileName, $workerId]);
}

function workerHasChanged(PDO $pdo, int $id_worker, Worker $newData): bool {
    $stmt = $pdo->prepare("SELECT * FROM workers WHERE id_worker = ?");
    $stmt->execute([$id_worker]);
    $old = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$old) return false;

    return (
        $old['name'] !== $newData->name ||
        $old['surname'] !== $newData->surname ||
        $old['company'] !== $newData->company ||
        $old['position'] !== $newData->position ||
        $old['email'] !== $newData->email ||
        $old['phone'] !== $newData->phone
    );
}

function updateWorker(PDO $pdo, Worker $w): bool {

    $sql = "UPDATE workers SET 
            name = ?, surname = ?, company = ?, position = ?, 
            email = ?, phone = ?, updated_at = NOW()
            WHERE id_worker = ?";

    $stmt = $pdo->prepare($sql);
    $ok = $stmt->execute([
        $w->name,
        $w->surname,
        $w->company,
        $w->position,
        $w->email,
        $w->phone,
        $w->id_worker
    ]);

    if (!$ok) return false;

    if (!workerHasChanged($pdo, $w->id_worker, $w)) {
        return true;
    }

    $stmt = $pdo->prepare("SELECT name FROM qr_codes WHERE id_worker = ?");
    $stmt->execute([$w->id_worker]);
    $old = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($old && isset($old['name'])) {
        deleteOldFile($old['name']);
    }

    $newFile = createQrCode($w);

    return updateCode($pdo, $w->id_worker, $newFile);
}


function refreshWorkerQr(PDO $pdo, int $id_worker, Worker $w): bool {
    $stmt = $pdo->prepare("SELECT name FROM qr_codes WHERE id_worker = ?");
    $stmt->execute([$id_worker]);
    $old = $stmt->fetchColumn();

    if ($old) {
        deleteOldFile($old);
    }

    $newFile = createQrCode($w);

    return updateCode($pdo, $id_worker, $newFile);
}

function autoRefreshQr(PDO $pdo): void {
    $stmt = $pdo->query("SELECT id_worker FROM worker_changes");
    $changes = $stmt->fetchAll(PDO::FETCH_COLUMN);

    if (!$changes) return;

    foreach ($changes as $id_worker) {

        $stmt = $pdo->prepare("SELECT * FROM workers WHERE id_worker = ?");
        $stmt->execute([$id_worker]);
        $w = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$w) continue;

        $worker = new Worker();
        $worker->name      = $w['name'];
        $worker->surname   = $w['surname'];
        $worker->company   = $w['company'];
        $worker->position  = $w['position'];
        $worker->email     = $w['email'];
        $worker->phone     = $w['phone'];
        $worker->id_worker = $w['id_worker'];

        $stmt = $pdo->prepare("SELECT name FROM qr_codes WHERE id_worker = ?");
        $stmt->execute([$id_worker]);
        $oldFile = $stmt->fetchColumn();

        if ($oldFile) {
            deleteOldFile($oldFile);
        }

        $newFile = createQrCode($worker);

        updateCode($pdo, $id_worker, $newFile);

        $pdo->prepare("DELETE FROM worker_changes WHERE id_worker = ?")
            ->execute([$id_worker]);
    }
}

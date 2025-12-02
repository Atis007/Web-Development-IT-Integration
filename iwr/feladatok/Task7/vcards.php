<?php
require_once 'vendor/autoload.php';

require 'includes/config.php';
require 'includes/functions.php';
require_once 'includes/classes.php';

$title = 'Task7 vcards';
require_once 'includes/header.php';

$pdo = connectDatabase($dsn, $pdoOptions);

$faker = Faker\Factory::create('hu_HU');

$workers = generateWorkers(1);

// Insert each generated Worker object individually into the database
foreach($workers as $worker) {
    $id_worker = insertWorkers($pdo, $worker);

    $qrFile = createQrCode($worker);

    $qr = new QrCodeData();
    $qr->id_worker = $id_worker;
    $qr->name = $qrFile;

    $qr->generated_at = $faker->dateTimeBetween('2000-01-01 0:0:0', '2024-01-01 23:59:59')->format('Y-m-d H:i:s');
    $qr->updated_at = $faker->dateTimeBetween('2025-01-01 0:0:0', 'now')->format('Y-m-d H:i:s');

    insertQrCode($pdo, $qr);
    echo "Inserted worker and qrcode";
}

include_once 'includes/footer.php';
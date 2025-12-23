<?php
require_once "includes/functions.php";
require_once "category.php";

$pdo = $GLOBALS['pdo'];

/** @var array<int,string> $categories */
var_dump($categories);
foreach($categories as $code => $name) {
    $stmt = $pdo->prepare("INSERT INTO categories (name, code, date_time_added) VALUES (:name, :code, NOW())");
    $stmt->execute([
        ':name' => $name,
        ':code' => $code
    ]);
}
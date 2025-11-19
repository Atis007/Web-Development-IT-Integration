<?php
header('Content-Type: application/json; charset=utf-8');

require __DIR__ . '/../includes/config.php';
require __DIR__ . '/../includes/functions.php';

$pdo = $GLOBALS['pdo'];

$id_category = $_POST['id_category'] ?? null;
$name        = $_POST['name']        ?? null;
$datetime    = $_POST['datetime']    ?? null;

if (!$id_category || !$name || !$datetime) {
    echo json_encode(['success' => false, 'message' => 'Missing required fields'], JSON_UNESCAPED_UNICODE);
    exit;
}

try {
    $sql = "UPDATE categories 
            SET name = :name, date_time = :datetime 
            WHERE id_category = :id_category";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':name',        $name,     PDO::PARAM_STR);
    $stmt->bindValue(':datetime',    $datetime, PDO::PARAM_STR);
    $stmt->bindValue(':id_category', $id_category, PDO::PARAM_INT);

    $stmt->execute();

    echo json_encode(['success' => true], JSON_UNESCAPED_UNICODE);
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Database error: ' . $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}
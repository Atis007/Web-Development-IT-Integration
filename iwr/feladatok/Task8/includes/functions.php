<?php
declare(strict_types=1);

require 'config.php';
$GLOBALS['pdo'] = connectDatabase($dsn, $pdoOptions);
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

function insertIntoJokes(PDO $pdo, string $type, string $joke, string $setup, string $delivery): void{
    $sql = "INSERT INTO jokes (type, joke, setup, delivery, created_at) VALUES (?,?,?,?, NOW())";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([$type, $joke, $setup, $delivery]);
}


function insertIntoLogs(PDO $pdo, string $url): void{
    $sql = "INSERT INTO logs (url, date_time) VALUES (?, NOW())";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([$url]);
}

function getLastJokes(PDO $pdo): array{
    $sql = "SELECT type, joke, setup, delivery FROM jokes ORDER BY id DESC LIMIT 10";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll();
}

function latestInsertToLogs(PDO $pdo): string{
    $sql = "SELECT date_time FROM logs ORDER BY date_time DESC LIMIT 1";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetch()['date_time'];
}
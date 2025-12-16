<?php
declare(strict_types=1);

require 'config.php';

$GLOBALS['pdo'] = connectDatabase($dsn, $pdoOptions);

/**
 * Attempt to establish a PDO database connection.
 *
 * @param string $dsn Full PDO DSN string (mysql:host=...;dbname=...)
 * @param array $pdoOptions Additional PDO attributes such as error mode, fetch mode etc.
 *
 * @return PDO                 Returns an active PDO instance on success.
 *
 * @throws PDOException        If the connection fails.
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

/**
 * If the month and the day matches exactly the ones in the database, then the function is returning an array with the
 * name picture and slogan. Otherwise, it returns an empty string
 *
 * @param PDO $pdo
 * @return array|string
 */
function dynamicHolidays(PDO $pdo): array|string{
    $month = date('n'); // example: 9,10,11...
    $day = date('j'); // example: 1,2,3,4...

    //$month = 5;
    //$day = 9;

    $sql = "SELECT name, picture, slogan FROM holidays where month = :month and day = :day";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':month', $month);
    $stmt->bindParam(':day', $day);
    $stmt->execute();

    $result = $stmt->fetch();

    return empty($result) ? '' : $result;
}
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
    } catch (\PDOException $e) {
        var_dump($e->getCode());
        throw new \PDOException($e->getMessage());
    }

    return $pdo;
}

function insertIntoWords(PDO $pdo, string $word): void{
    $sql = "INSERT IGNORE INTO bonuszwords (word) VALUES (:word)"; // ignoring the words that already inside the db
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':word', $word);
    $stmt->execute();
}

function getDataFromWords(PDO $pdo): array{
    $sql = "SELECT word FROM bonuszwords";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}

function levenshteinDistance(string $input): array{
    $pdo = $GLOBALS['pdo'];
    $words = getDataFromWords($pdo);

    // no shortest distance found, yet
    $shortest = -1;

    // loop through words to find the closest
    foreach ($words as $word) {
        // calculate the distance between the input word,
        // and the current word
        $lev = levenshtein($input, $word);

        // check for an exact match
        if ($lev === 0) {
            // closest word is this one (exact match)
            $closest = $word;
            $shortest = 0;
            // break out of the loop; we've found an exact match
            break;
        }

        // if this distance is less than the next found shortest
        // distance, OR if a next shortest word has not yet been found
        if ($lev <= $shortest || $shortest < 0) {
            // set the closest match, and shortest distance
            $closest  = $word;
            $shortest = $lev;
        }
    }

    if ($shortest === 0) {
        $message = "Exact match found: $closest\n";
    } else {
        $message = "Did you mean: $closest?\n";
    }

    return [$message, $shortest, $lev, $closest];
}
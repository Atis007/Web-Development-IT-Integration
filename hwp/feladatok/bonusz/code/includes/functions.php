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

function fetchAllWords(PDO $pdo): array{
    $sql = "SELECT id_word, word FROM bonuszwords";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function fetchWordsByLength(PDO $pdo, int $min, int $max): array{
    $sql = "SELECT id_word, word FROM bonuszwords_indexed WHERE word_length BETWEEN :min AND :max";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':min', $min);
    $stmt->bindParam(':max', $max);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function levenshteinDistance(string $input, bool $useLengthConstraint, int $min = 1, int $max = 21): array{ // if the user is not added min or max values, then need values where
    $pdo = $GLOBALS['pdo'];

    $start = microtime(true);

    if ($useLengthConstraint) {
        $words = fetchWordsByLength($pdo, $min, $max);
        $constraint = 'used';
    } else {
        $words = fetchAllWords($pdo);
        $constraint = 'not_used';
    }

    if(empty($words)){
        $totalMs = (microtime(true) - $start) * 1000;
        return [-1, '', $totalMs, $constraint];
    }

    // no shortest distance found, yet
    $shortest = -1;
    $closestWord = '';
    $closestWordId = 0;

    // loop through words to find the closest
    foreach ($words as $row) {
        // calculate the distance between the input word,
        // and the current word
        $lev = levenshtein($input, $row['word']);

        // check for an exact match
        if ($lev === 0) {
            // closest word is this one (exact match)
            $shortest = 0;
            $closestWord = $row['word'];
            $closestWordId = $row['id_word'];
            // break out of the loop; we've found an exact match
            break;
        }

        // if this distance is less than the next found shortest
        // distance, OR if a next shortest word has not yet been found
        if ($shortest < 0 || $lev < $shortest) {
            // set the closest match, and shortest distance
            $shortest = $lev;
            $closestWord  = $row['word'];
            $closestWordId = $row['id_word'];
        }
    }

    $totalMs = (microtime(true) - $start) * 1000;
    return [$shortest, $closestWord, $closestWordId, $totalMs, $constraint];
}

function insertIntoResults(PDO $pdo, string $closestWordId, string $input, int $distance, float $runtime, string $used): void{
    $sql = "INSERT INTO bonuszresults (id_word, input, distance, date_time, runtime_ms, length_constraint) 
            VALUES (:closestWordId, :input, :distance, NOW(), :runtime, :used)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':closestWordId' => $closestWordId,
        ':input' => $input,
        ':distance' => $distance,
        ':runtime' => $runtime,
        ':used' => $used
    ]);
}
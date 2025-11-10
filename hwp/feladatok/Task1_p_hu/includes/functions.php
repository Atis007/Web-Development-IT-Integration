<?php
declare(strict_types=1);

/** Function tries to connect to database using PDO
 * @param string $dsn
 * @param array $pdoOptions
 * @return PDO
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

/** Searches words in the db, like the ones that are given
 * @param PDO $pdo
 * @param array $words
 * @return array
 */
function searchEveryWord(PDO $pdo, array $words): array{
    $results = [];
    foreach ($words as $word) {
        $sql = "SELECT id_text_data FROM text_data WHERE text LIKE :word";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':word' => "%$word%"]);

        // Fetch ID-k tombkent
        $ids = $stmt->fetchAll(\PDO::FETCH_COLUMN);

        //Hozzaadja a tomb vegehez az idt
        $results = array_merge($results, $ids);
    }

    // duplikatumok eltavolitasa
    $results = array_unique($results);

    //novekvo sorrend
    sort($results);

    return $results;
}

/**
 * Generates a random word-based sentence.
 *
 * @return string
 */
function generateSentence(): string
{
    $nouns = ['student', 'project', 'system', 'database', 'teacher', 'server', 'client', 'developer', 'program', 'network'];
    $verbs = ['learns', 'builds', 'tests', 'deploys', 'improves', 'creates', 'optimizes', 'studies', 'writes', 'updates'];
    $adjectives = ['fast', 'secure', 'simple', 'advanced', 'modern', 'dynamic', 'stable', 'clean', 'scalable', 'useful'];
    $adverbs = ['quickly', 'carefully', 'smoothly', 'efficiently', 'silently', 'openly', 'clearly', 'intensely', 'slowly'];
    $connectors = ['and', 'but', 'while', 'because', 'although', 'when'];

    $words = [];

    $sentenceLength = mt_rand(5, 12);

    for ($i = 0; $i < $sentenceLength; $i++) {
        $type = mt_rand(1, 5);

        switch ($type) {
            case 1: $words[] = $nouns[array_rand($nouns)]; break;
            case 2: $words[] = $verbs[array_rand($verbs)]; break;
            case 3: $words[] = $adjectives[array_rand($adjectives)]; break;
            case 4: $words[] = $adverbs[array_rand($adverbs)]; break;
            case 5: $words[] = $connectors[array_rand($connectors)]; break;
        }
    }

    $sentence = implode(' ', $words);
    $sentence = ucfirst($sentence) . '.';

    return $sentence;
}

/**
 * Generates a text block (1-3 sentences).
 *
 * @return string
 */
function generateText(): string
{
    $sentenceCount = mt_rand(1, 3);

    $text = [];
    for ($i = 0; $i < $sentenceCount; $i++) {
        $text[] = generateSentence();
    }

    return implode(' ', $text);
}

/**
 * Generates a random datetime from last 30 days.
 *
 * @return string
 */
function generateRandomDate(): string
{
    $timestamp = time() - mt_rand(0, 60 * 60 * 24 * 30);
    return date("Y-m-d H:i:s", $timestamp);
}

/**
 * Inserts a generated text row into database.
 *
 * @param PDO $pdo
 * @param string $text
 * @param string $date
 * @return void
 */
function insertText(PDO $pdo, string $text, string $date): void
{
    $sql = "INSERT INTO text_data (text, date_time) VALUES (:text, :date_time)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':text' => $text,
        ':date_time' => $date
    ]);
}

/**Inserts the data to the search table
 * @param PDO $pdo
 * @param string $searchContent
 * @param string $resultsString
 * @return void
 */
function insertToSearch(PDO $pdo, string $searchContent, string $resultsString): void {
    $sql = "INSERT INTO search (search_content, results) VALUES (:content, :results)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':content' => $searchContent,
        ':results' => $resultsString
    ]);
}
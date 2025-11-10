<?php

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

/** Function that inserting data to the database
 * @param PDO $pdo
 * @param string $original_text
 * @param string $modified_text
 * @param string $length
 * @return void
 */
function insertData(PDO $pdo, string $original_text, string $modified_text, string $length): void
{
    $sql = "INSERT INTO task8
            (original_text, modified_text, length)
            VALUES (:ot, :mt, :length)";

    $stmt = $pdo->prepare($sql);

    $stmt->bindValue(':ot', $original_text, PDO::PARAM_STR);
    $stmt->bindValue(':mt', $modified_text, PDO::PARAM_STR);
    $stmt->bindValue(':length', $length, PDO::PARAM_STR);
    $stmt->execute();
}

/** Function that selects the tables needed
 * @param PDO $pdo
 * @return array
 */
function getData(PDO $pdo): array
{
    $sql = "SELECT original_text, modified_text, length, DATE_FORMAT(created_at, '%d.%m.%Y. %T') as date FROM task8 ORDER BY created_at DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $result;
}

/** Processes the text from the textarea
 * @param string $text
 * @return array
 */
function processText(string $text): array {
    $modifiedText = preg_replace('/\s+/', ' ', $text); // every whitespace → 1 space.
    $modifiedText = trim($modifiedText);
    $modifiedText = str_replace(['a', 'A'], "@", $modifiedText);
    $modifiedText = ucwords($modifiedText);
    if(strlen($modifiedText) > 100) $modifiedText = substr($modifiedText, 0, 100) . '...';
    $modifiedTextFinalLength = strlen($modifiedText);

    return [$text, $modifiedText, $modifiedTextFinalLength];
}
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
function insertData(PDO $pdo, string $first_name, string $last_name, string $email, string $city, string $language, string $created_at): void
{
    $sql = "INSERT INTO contacts
            (first_name, last_name, email, city, language, created_at)
            VALUES (:fn, :ln, :email, :city, :l, :date)";

    $stmt = $pdo->prepare($sql);

    $stmt->bindValue(':fn', $first_name, PDO::PARAM_STR);
    $stmt->bindValue(':ln', $last_name, PDO::PARAM_STR);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->bindValue(':city', $city, PDO::PARAM_STR);
    $stmt->bindValue(':l', $language, PDO::PARAM_STR);
    $stmt->bindValue(':date', $created_at, PDO::PARAM_STR);
    $stmt->execute();
}

/** Function that selects the tables needed
 * @param PDO $pdo
 * @return array
 */
function getData(PDO $pdo): int
{
    $sql = "SELECT COUNT(*) FROM contacts";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    return (int)$stmt->fetchColumn();
}


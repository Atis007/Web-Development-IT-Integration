<?php
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
    } catch (\PDOException $e) {
        var_dump($e->getCode());
        throw new \PDOException($e->getMessage());
    }

    return $pdo;
}


/**
 * Returns all categories from the database.
 *
 * @return array List of categories with keys:
 *               - no: sequential number
 *               - name: category name
 *               - datetime: creation date/time
 *               - id_category: unique ID
 */
function getCategories(): array
{
    $sql = "SELECT id_category, name, date_time FROM categories ORDER BY date_time DESC";
    $stmt = $GLOBALS['pdo']->prepare($sql);
    $stmt->execute();

    $data = [];
    $number = 1;

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $data[] = [
            'no' => $number,
            'name' => $row['name'],
            'datetime' => $row['date_time'],
            'id_category' => $row['id_category']
        ];
        $number++;
    }

    return $data;
}

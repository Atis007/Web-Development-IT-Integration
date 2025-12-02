<?php

$GLOBALS['pdo'] = connectDatabase($dsn, $pdoOptions);

/**
 * Establishes PDO database connection.
 *
 * @param string $dsn
 * @param array  $pdoOptions
 * @return PDO
 * @throws PDOException
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
 * Retrieves a list of product categories from the database.
 *
 * @global PDO $pdo Database connection instance
 * @return array Returns an associative array of categories
 */
function getCategoriesData(): array
{
    $pdo = $GLOBALS['pdo'];

    $sql = "SELECT id_category, name 
            FROM task12categories
            ORDER BY name";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function insertIntoProducts(string $id, string $name, int $price): void{
    $pdo = $GLOBALS['pdo'];

    $sql = "INSERT INTO task12products (id_category, name, price) VALUES (?,?,?)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id, $name, $price]);
}

function getProductsData(array $columns = []): array{
    $pdo = $GLOBALS['pdo'];

    $valid = ['id_product','name','price','id_category'];

    $requested = array_intersect($columns, $valid);

    $cols = empty($requested) ? '*' : implode(', ', $requested);

    $sql = "SELECT $cols from task12products ORDER BY name";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function deleteProduct(int $id): void{
    $pdo = $GLOBALS['pdo'];

    $sql = "DELETE FROM task12products WHERE id_product = ?";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
}
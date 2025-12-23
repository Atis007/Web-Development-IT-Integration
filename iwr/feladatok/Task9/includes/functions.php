<?php
declare(strict_types=1);

require 'config.php';

$GLOBALS['pdo'] = connectDatabase($dsn, $pdoOptions);

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

function insertIntoTokens(PDO $pdo, string $token, int $restriction, string $expire): void
{
    $sql = "INSERT INTO tokens (token, restriction_number, date_expire) VALUES (:token, :restriction, :expire)";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':token', $token);
    $stmt->bindParam(':restriction', $restriction, PDO::PARAM_INT);
    $stmt->bindParam(':expire', $expire);

    $stmt->execute();
}

function getTokenByValue(PDO $pdo, string $token): ?array
{
    $sql = "SELECT * FROM tokens WHERE token = :token LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':token', $token);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result ?: null;
}

function logTokenUsage(PDO $pdo, int $tokenId, string $requestUrl): void
{
    $sql = "INSERT INTO token_usages (id_token, request_url, date_time) VALUES (:id_token, :request_url, NOW())";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_token', $tokenId, PDO::PARAM_INT);
    $stmt->bindParam(':request_url', $requestUrl);
    $stmt->execute();
}

function getTokenUsageCountForToday(PDO $pdo, int $tokenId): int
{
    $sql = "SELECT COUNT(*) AS total FROM token_usages WHERE id_token = :id_token AND DATE(date_time) = CURDATE()";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_token', $tokenId, PDO::PARAM_INT);
    $stmt->execute();

    return (int)$stmt->fetchColumn();
}

function getAllProducts(PDO $pdo): array
{
    $sql = "SELECT p.id_product, c.name AS category_name, p.name, p.price, p.amount, p.date_added
            FROM products p
            LEFT JOIN categories c ON c.id_category = p.id_category
            ORDER BY p.id_product";

    $stmt = $pdo->query($sql);

    return $stmt->fetchAll();
}

function getProductById(PDO $pdo, int $id): ?array
{
    $sql = "SELECT p.id_product, c.name AS category_name, p.id_category, p.name, p.price, p.amount, p.date_added
            FROM products p
            LEFT JOIN categories c ON c.id_category = p.id_category
            WHERE p.id_product = :id LIMIT 1";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result ?: null;
}

function getAllCategories(PDO $pdo): array
{
    $sql = "SELECT id_category, name, date_added FROM categories ORDER BY id_category";
    $stmt = $pdo->query($sql);

    return $stmt->fetchAll();
}

function getCategoryById(PDO $pdo, int $categoryId): ?array
{
    $sql = "SELECT * FROM categories WHERE id_category = :id LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $categoryId, PDO::PARAM_INT);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result ?: null;
}

function getCategoryByName(PDO $pdo, string $categoryName): ?array
{
    $sql = "SELECT * FROM categories WHERE name = :name LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name', $categoryName);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result ?: null;
}

function getProductsByCategoryId(PDO $pdo, int $categoryId): array
{
    $sql = "SELECT id_product, name, price, amount, date_added
            FROM products
            WHERE id_category = :id
            ORDER BY id_product";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $categoryId, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll();
}

function createProduct(PDO $pdo, array $payload): int
{
    $sql = "INSERT INTO products (id_category, name, price, amount, date_added)
            VALUES (:id_category, :name, :price, :amount, NOW())";

    $stmt = $pdo->prepare($sql);

    if (isset($payload['id_category'])) {
        $stmt->bindValue(':id_category', $payload['id_category'], PDO::PARAM_INT);
    } else {
        $stmt->bindValue(':id_category', null, PDO::PARAM_NULL);
    }

    $stmt->bindValue(':name', $payload['name']);
    $stmt->bindValue(':price', $payload['price']);
    $stmt->bindValue(':amount', $payload['amount'], PDO::PARAM_INT);

    $stmt->execute();

    return (int)$pdo->lastInsertId();
}

function deleteProduct(PDO $pdo, int $productId): bool
{
    $sql = "DELETE FROM products WHERE id_product = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $productId, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->rowCount() > 0;
}

function fetchRandomToken(PDO $pdo): ?array
{
    $sql = "SELECT * FROM tokens ORDER BY RAND() LIMIT 1";
    $stmt = $pdo->query($sql);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result ?: null;
}

function getTokenCount(PDO $pdo): int
{
    $sql = "SELECT COUNT(*) FROM tokens";
    $stmt = $pdo->query($sql);

    return (int)$stmt->fetchColumn();
}

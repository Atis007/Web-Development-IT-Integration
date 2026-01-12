<?php
declare(strict_types=1);

namespace MyApp\Repository;

use Database\Db;
use MyApp\Model\Product;
use PDO;


class ProductRepository
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Db::getInstance();
    }
    /** @param Product[] $products */
    public function insertMany(array $products): int {
        $sql = "INSERT INTO productstask5(name, category, price, amount)
                VALUES(:name, :category, :price, :amount)";
        $stmt = $this->pdo->prepare($sql);

        foreach ($products as $product) {
            if (!$product instanceof Product) {
                throw new \InvalidArgumentException('Array must contain Product objects');
            }

            $stmt->execute([
                'name' => $product->name,
                'category' => $product->category,
                'price' => $product->price,
                'amount' => $product->amount
            ]);
        }
        return count($products);
    }

    public function listAll(): array
    {
        $sql = "SELECT * FROM productstask5";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function searchByName(string $query): array {
        $sql = "SELECT name, category, price, amount FROM productstask5 WHERE name LIKE :name";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':name', "%$query%", PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function deleteById(int $id): bool {
        $sql = "DELETE FROM productstask5 WHERE id_product = :id LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}

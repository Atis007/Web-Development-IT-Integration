<?php

namespace MyApp;

use Database\Db;
use PDO;

class User
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Db::getInstance();
    }

    public function getUserById(int $id): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id_user = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch();
    }

    public function createUser(string $email): int
    {
        $stmt = $this->pdo->prepare("INSERT INTO users (email) VALUES (:email)");
        $stmt->bindValue(':email', $email);
        $stmt->execute();

        return $this->pdo->lastInsertId();
    }
}

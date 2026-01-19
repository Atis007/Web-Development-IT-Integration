<?php
declare(strict_types=1);

namespace App\models;

use App\core\Model;

final class QuoteModel extends Model
{
    public function all(): array
    {
        $stmt = $this->db->query("SELECT id, text, author FROM quotes ORDER BY id DESC");
        return $stmt->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT id, text, author FROM quotes WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();

        return $row ?: null;
    }

//    public function create(string $title, string $author): int
//    {
//        $stmt = $this->db->prepare(
//            "INSERT INTO books (title, author) VALUES (:title, :author)"
//        );
//        $stmt->execute([
//            'title' => $title,
//            'author' => $author,
//        ]);
//
//        return (int)$this->db->lastInsertId();
//    }
}

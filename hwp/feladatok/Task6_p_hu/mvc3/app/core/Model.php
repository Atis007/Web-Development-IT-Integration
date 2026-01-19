<?php
declare(strict_types=1);

namespace App\core;

use PDO;

abstract class Model
{
    protected PDO $db;

    public function __construct(array $config)
    {
        $this->db = Database::pdo($config);
    }
}

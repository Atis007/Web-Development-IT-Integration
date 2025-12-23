<?php

namespace Database;

use PDO;
use PDOException;
use Dotenv\Dotenv;

class Db
{
    private static ?PDO $instance = null;

    // Private constructor to prevent direct instantiation
    private function __construct()
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../'); // Adjust path if necessary
        $dotenv->load();

        $host = $_ENV['DB_HOST'] ?? throw new \Exception('DB_HOST is not set.');
        $dbname = $_ENV['DB_NAME'] ?? throw new \Exception('DB_NAME is not set.');
        $user = $_ENV['DB_USER'] ?? throw new \Exception('DB_USER is not set.');
        $pass = $_ENV['DB_PASSWORD'] ?? throw new \Exception('DB_PASSWORD is not set.');

        try {
            self::$instance = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
            self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$instance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    // Singleton pattern to get PDO instance
    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            // Initialize PDO instance if it doesn't exist
            new self();  // Will call the constructor to establish the connection
        }

        return self::$instance;  // Return the PDO object for use in other classes
    }
}

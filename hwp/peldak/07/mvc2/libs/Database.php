<?php

namespace Mvc\libs;

class Database
{

    private static $host = 'localhost';
    private static $db_name = 'nwp';
    private static $username = 'root';
    private static $password = '';
    private static $conn = null;

    public static function connect()
    {
        try {
            self::$conn = mysqli_connect(self::$host, self::$username, self::$password, self::$db_name);
            if (!self::$conn) {
                throw new \Exception('MySQL Connection Database Error');
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }

        return self::$conn;
    }
}
<?php
declare(strict_types=1);

use JetBrains\PhpStorm\NoReturn;

require 'config.php';

$GLOBALS['pdo'] = connectToDatabase($dsn, $pdoOptions);

/**
 * Attempt to establish a PDO database connection.
 *
 * @param string $dsn Full PDO DSN string (mysql:host=...;dbname=...)
 * @param array $pdoOptions Additional PDO attributes such as error mode, fetch mode etc.
 *
 * @return PDO                 Returns an active PDO instance on success.
 *
 * @throws PDOException        If the connection fails.
 */
function connectToDatabase(string $dsn, array $pdoOptions): PDO
{
    try {
        $pdo = new PDO($dsn, PARAMS['USER'], PARAMS['PASSWORD'], $pdoOptions);
    } catch (PDOException $e) {
        var_dump($e->getCode());
        throw new PDOException($e->getMessage());
    }

    return $pdo;
}

function getCategories(string $cat = " na2t5u25re spo12r54t funn82y cake2! 8sea au#!tumn!"): array{
    $cat_array = explode(" ", $cat);

    $cat_temp = array_filter(array_map(function ($word){
        if(strlen($word) > 4 && ctype_alnum($word)){
            return $word;
        }
        return null;
    }, $cat_array)
    );

    return array_values($cat_temp); //reindex array after filtering
}
function createUsers(array $names, array $levels): array{
    $cleanNames = array_map(function ($name) {
        $name = preg_replace('/[^a-zA-Z]/', '', $name);
        return ucfirst(strtolower($name));
    }, $names);

    $users = [];
    $usedUsernames = [];
    $usedLevels = [];

    $i=0;
    do {
        $name = $cleanNames[array_rand($cleanNames)];

        $baseUsername = 'user' . strtolower($name);
        $username = $baseUsername;

        if (in_array($username, $usedUsernames, true)) {
            $username .= rand(10, 200);
        }
        $usedUsernames[] = $username;

        $password = time() . $username;
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        do {
            $level = $levels[array_rand($levels)];
        } while (in_array($level, $usedLevels, true));

        $usedLevels[] = $level;

        $users[] = [
            'username'        => $username,
            'password'        => $password,
            'hashed_password' => $hashedPassword,
            'age'             => rand(18, 47),
            'name'            => $name,
            'email'           => $username . '@company.com',
            'level'           => $level
        ];
        $i++;
    } while ($i<3);

    return $users;
}

function checkUserExist(PDO $pdo, string $username, string $password): array{
    $sql = "SELECT id_user, password, level FROM users WHERE username = :username";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['username' => $username]);

    $user = $stmt->fetch();

    if($user && password_verify($password, $user['password'])){
        addToLogs($pdo, (int)$user['id_user']);

        $name = ucfirst(preg_replace('/^user|\d+/', '', $username));

        return [
            'id_user' => $user['id_user'],
            'level' => $user['level'],
            'name' => $name,
            'message' => 'Successful login.'
        ];
    }

    saveError($pdo, $username, $password);
    return [
        'id_user' => null,
        'level' => null,
        'name' => null,
        'message' => 'Failed to login!'
    ];
}

function saveError(PDO $pdo, string $name, string $password): void{
    $sql="INSERT INTO errors (username, password, date_time) VALUES(:username, :password, NOW())";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'username' => $name,
        'password' => $password
    ]);

}

function addToLogs(PDO $pdo, int $idUser): void{
    $sql="INSERT INTO logs (id_user, date_time_added) VALUES(:idUser, NOW())";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'idUser' => $idUser,
    ]);
}


#[NoReturn]
function redirectFn(string $fileName, string $message): void{
    if($fileName === ''){
        $fileName = 'index';
    }
    header("Location:" . $fileName . ".php?error=" . urlencode($message));
    exit;
}

function listCategories(PDO $pdo): array{
    $sql="SELECT DISTINCT id_category, name FROM categories LIMIT 3";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
}

function addToImages(PDO $pdo, int $idUser, int $idCategory, string $file, string $description): void{
    $sql = "INSERT INTO photos (id_user, id_category, file, description, date_time_added) VALUES(:idUser, :idCategory, :file, :description, NOW())";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'idUser' => $idUser,
        'idCategory' => $idCategory,
        'file' => $file,
        'description' => $description
    ]);
}
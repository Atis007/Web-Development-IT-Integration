<?php
declare(strict_types=1);

use JetBrains\PhpStorm\NoReturn;

require 'config.php';

$GLOBALS['pdo'] = connectToDatabase($dsn, $pdoOptions);
$GLOBALS['roles'] = $roles;
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

function createUsers(int $number): void{
    $pdo = $GLOBALS['pdo'];
    $faker=Faker\Factory::create();

    $startDate = '2025-01-11';
    $endDate = '2026-01-11';

    for($i = 0; $i < $number; $i++){
        if($i===0){
            $randomRole='supervisor';
        } else {
            $randomRole = $faker->randomElement($GLOBALS['roles']);
        }
        $data = [
            "email" => $faker->email,
            "name" => $faker->name,
            "address" => $faker->address,
            "dateStarted" => $faker->dateTimeBetween($startDate, $endDate)->format('Y-m-d H:i:s')
        ];
        if($randomRole !== "user"){
            $password = $faker->password();
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            $sql = "INSERT INTO users (email, password, clear_password, name, address, role, date_time_added) VALUES (:email, :password, :clear_password, :name, :address, :role, :dateTimeAdded)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':email' => $data['email'],
                ':password' => $hashedPassword,
                ':clear_password' => $password,
                ':name' => $data['name'],
                ':address' => $data['address'],
                ':role' => $randomRole,
                ":dateTimeAdded" => $data['dateStarted'],
            ]);
        } else {
            $sql = "INSERT INTO users (email, name, address, role, date_time_added) VALUES (:email, :name, :address, :role, :dateTimeAdded)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':email' => $data['email'],
                ':name' => $data['name'],
                ':address' => $data['address'],
                ':role' => $randomRole,
                ":dateTimeAdded" => $data['dateStarted'],
            ]);
        }
    }
}

function createProjects(int $number): void{
    $pdo = $GLOBALS['pdo'];
    $faker=Faker\Factory::create();

    $startDate = '2025-01-11';
    $endDate = '2026-01-11';

    for($i = 0; $i < $number; $i++){
        $data = [
            "title" => ucfirst($faker->word()),
            "description" => $faker->sentence(5),
            "dateStarted" => $faker->dateTimeBetween($startDate, $endDate)->format('Y-m-d H:i:s')
        ];
        $sql = "INSERT INTO projects (title, description, date_started, date_time_added) VALUES (:title, :description, :date_started, NOW())";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':title' => $data['title'],
            ':description' => $data['description'],
            ':date_started' => $data['dateStarted'],
        ]);
    }
}

function loginUser(PDO $pdo, string $email, string $password): array{
    $sql = "SELECT id_user, role, password FROM users WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['email' => $email]);

    $user = $stmt->fetch();

    if($user && password_verify($password, $user['password'])){
        return [
            'id_user' => $user['id_user'],
            'role' => $user['role'],
        ];
    }
    return [
        'id_user' => null,
        'role' => null,
    ];
}

function checkUserExist(PDO $pdo, int $id): bool{
    $sql = "SELECT id_user FROM users WHERE id_user = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);

    $user = $stmt->fetch();

    if($user ){
        return true;
    }
    return false;
}

#[NoReturn]
function redirectFn(string $fileName, string $message): void{
    if($fileName === ''){
        $fileName = 'index';
    }
    header("Location:" . $fileName . ".php?error=" . urlencode($message));
    exit;
}

function filterText(string $text): string{
    $words = explode(' ', $text);

    $filteredText = array_filter($words, function($word) {
        return !preg_match('/\d/', $word);
    });

    return implode(' ', $filteredText);
}

function getUsers(PDO $pdo): array{
    $sql = "SELECT id_user, name, email FROM users WHERE role = 'user'";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
}

function updateUser(PDO $pdo, int $id, string $city, int $salary, string $password, string $biography): array{
    $sql = "UPDATE users SET salary = :salary, password = :pw, clear_password = :password, biography = :biography";

    $pw = password_hash($password, PASSWORD_BCRYPT);

    $params = [
        ':id_user' => $id,
        ':salary' => $salary,
        ':pw' => $pw,
        ':password' => $password,
        ':biography' => $biography,
    ];

    if($city !== ''){
        $sql .= ", city = :city ";
        $params[':city'] = $city;
    }

    $sql .= " WHERE id_user = :id_user";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    $updatedData = [
        'id_user' => $id,
        'salary' => $salary,
        'biography' => $biography,
        'password_updated' => $password
    ];

    if ($city !== '') {
        $updatedData['city'] = $city;
    }

    return $updatedData;
}

function getProjects(PDO $pdo): array{
    $sql = "SELECT * FROM projects";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
}

function updateProject(PDO $pdo, int $id, string $task, string $description): void{
    $sql = "UPDATE projects SET title = :task, description = :description WHERE id_project = :id_project";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':task' => $task,
        ':description' => $description,
        ':id_project' => $id,
    ]);
}

/* 13. Feladat: Saját feladatok lekérdezése (időrendben csökkenő) */
function getMyTasks(PDO $pdo, int $userId): array {
    // A tábla: tasks, a dátum mező: date_time_added
    $sql = "SELECT * FROM tasks WHERE id_user = :id_user ORDER BY date_time_added DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id_user' => $userId]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/* 14. Feladat: Összes felhasználó lekérdezése (név szerint növekvő) */
function getAllUsers(PDO $pdo): array {
    // A tábla: users, a rendezés a 'name' mező alapján történik
    $sql = "SELECT * FROM users ORDER BY name ASC";

    $stmt = $pdo->query($sql);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
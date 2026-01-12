<?php
declare(strict_types=1);

use JetBrains\PhpStorm\NoReturn;
use PDO;
use PDOException;

require 'config.php';

$GLOBALS['pdo'] = connectToDatabase($dsn, $pdoOptions);
$GLOBALS['roles'] = $roles;

/**
 * Establish a PDO connection using the provided parameter set.
 *
 * @param array $params     Host, user, password, database, charset parameters.
 * @param array $pdoOptions PDO options array.
 * @return PDO              Active PDO connection.
 */
function connectToDatabase(string $dsn, array $pdoOptions): PDO
{
    try {
        $pdo = new PDO($dsn, PARAMS['USER'], PARAMS['PASSWORD'], $pdoOptions);
    } catch (PDOException $e) {
        throw new PDOException($e->getMessage(), (int)$e->getCode());
    }

    return $pdo;
}

function createUsers(int $number): void{
    $pdo = $GLOBALS['pdo'];
    $faker = Faker\Factory::create();

    $now = new DateTimeImmutable();
    $startDate = $now->modify('-1 year');

    for($i = 0; $i < $number; $i++){
        if($i===0){
            $randomRole='supervisor';
        } else {
            $randomRole = $faker->randomElement($GLOBALS['roles']);
        }
        $data = [
            'email' => $faker->unique()->email(),
            'name' => $faker->name(),
            'address' => $faker->address(),
            'role' => $randomRole,
            'date_time_added' => $startDate->format('Y-m-d H:i:s'),
            'status' => 'active',
        ];

        if ($randomRole !== 'user') {
            $password = $faker->password(10, 16);
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            $sql = "INSERT INTO users (email, password, clear_password, name, address, role, date_time_added, status) VALUES (:email, :password, :clear_password, :name, :address, :role, :date_time_added, :status)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':email' => $data['email'],
                ':password' => $hashedPassword,
                ':clear_password' => $password,
                ':name' => $data['name'],
                ':address' => $data['address'],
                ':role' => $data['role'],
                ':date_time_added' => $data['date_time_added'],
                ':status' => $data['status'],
            ]);
        } else {
            $sql = "INSERT INTO users (email, name, address, role, date_time_added, status) VALUES (:email, :name, :address, :role, :date_time_added, :status)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':email' => $data['email'],
                ':name' => $data['name'],
                ':address' => $data['address'],
                ':role' => $data['role'],
                ':date_time_added' => $data['date_time_added'],
                ':status' => $data['status'],
            ]);
        }
    }
}

/**
 * Create projects with start dates from the past year.
 *
 * @param int $number Number of projects to create.
 */
function createProjects(int $number): void
{
    $pdo = $GLOBALS['pdo'];
    $faker = Faker\Factory::create();

    $now = new DateTimeImmutable();
    $startDate = $now->modify('-1 year');

    for ($i = 0; $i < $number; $i++) {
        $data = [
            'title' => ucfirst($faker->word()),
            'description' => $faker->sentence(6),
            'date_started' => $faker->dateTimeBetween($startDate, $now)->format('Y-m-d H:i:s'),
        ];

        $sql = "INSERT INTO projects (title, description, date_started, date_time_added) VALUES (:title, :description, :date_started, NOW())";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':title' => $data['title'],
            ':description' => $data['description'],
            ':date_started' => $data['date_started'],
        ]);
    }
}

/**
 * Authenticate a user by email/password and require active status.
 *
 * @param PDO    $pdo      PDO connection.
 * @param string $email    Email address.
 * @param string $password Plain text password.
 * @return array|null      User id and role on success, null otherwise.
 */
function loginUser(PDO $pdo, string $email, string $password): ?array
{
    $sql = "SELECT id_user, role, password, status FROM users WHERE email = :email LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':email' => $email]);

    $user = $stmt->fetch();

    if (!$user || ($user['status'] ?? 'inactive') !== 'active') {
        return null;
    }

    if (!empty($user['password']) && password_verify($password, $user['password'])) {
        return [
            'id_user' => (int)$user['id_user'],
            'role' => $user['role'],
        ];
    }

    return null;
}

/**
 * Check if a user exists by id.
 *
 * @param PDO $pdo PDO connection.
 * @param int $id  User id.
 * @return bool    True if exists.
 */
function checkUserExist(PDO $pdo, int $id): bool
{
    return getUserById($pdo, $id) !== null;
}

/**
 * Fetch a single user by id.
 *
 * @param PDO $pdo PDO connection.
 * @param int $id  User id.
 * @return array|null User row or null.
 */
function getUserById(PDO $pdo, int $id): ?array
{
    $sql = "SELECT * FROM users WHERE id_user = :id LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
    $user = $stmt->fetch();

    return $user === false ? null : $user;
}

/**
 * Redirect helper with message.
 *
 * @param string $fileName Target file (without .php).
 * @param string $message  Message to attach as error param.
 */

function redirectFn(string $fileName, string $message): never
{
    if ($fileName === '') {
        $fileName = 'index';
    }
    header('Location:' . $fileName . '.php?error=' . urlencode($message));
    exit;
}

/**
 * Strip words containing any digit from the provided text.
 *
 * @param string $text Input text.
 * @return string      Filtered text.
 */
function filterText(string $text): string
{
    $words = explode(' ', $text);

    $filteredText = array_filter($words, static function ($word) {
        return !preg_match('/\d/', $word);
    });

    return implode(' ', $filteredText);
}

/**
 * Require an authenticated, active user and (optionally) a specific role set.
 * Returns the user row for downstream use.
 *
 * @param PDO   $pdo          PDO connection.
 * @param array $allowedRoles Allowed roles list (empty means any).
 * @return array              User row.
 */
function assertAuthenticated(PDO $pdo, array $allowedRoles = []): array
{
    if (!isset($_SESSION['id_user'], $_SESSION['role'])) {
        redirectFn('index', 'Please login first!');
    }

    $user = getUserById($pdo, (int)$_SESSION['id_user']);
    if (!$user || ($user['status'] ?? 'inactive') !== 'active') {
        redirectFn('index', 'Session expired or user inactive.');
    }

    if ($user['role'] !== $_SESSION['role']) {
        redirectFn('index', 'Session role mismatch.');
    }

    if (!empty($allowedRoles) && !in_array($user['role'], $allowedRoles, true)) {
        redirectFn('index', 'Unauthorized access.');
    }

    return $user;
}

/**
 * Get users who have role "user".
 *
 * @param PDO $pdo PDO connection.
 * @return array   List of users.
 */
function getUsers(PDO $pdo): array
{
    $sql = "SELECT id_user, name, email FROM users WHERE role = 'user' ORDER BY name ASC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
}

/**
 * Update user fields that come from the edit form.
 *
 * @param PDO    $pdo       PDO connection.
 * @param int    $id        User id.
 * @param string $city      City (optional empty string means no change).
 * @param int    $salary    Salary.
 * @param string $password  Plain password.
 * @param string $biography Biography text.
 * @param string $status    Active/inactive flag.
 * @return array            Updated data snapshot.
 */
function updateUser(PDO $pdo, int $id, string $city, int $salary, string $password, string $biography, string $status): array
{
    $sql = 'UPDATE users SET salary = :salary, password = :pw, clear_password = :password, biography = :biography, status = :status';

    $pw = password_hash($password, PASSWORD_BCRYPT);

    $params = [
        ':id_user' => $id,
        ':salary' => $salary,
        ':pw' => $pw,
        ':password' => $password,
        ':biography' => $biography,
        ':status' => $status,
    ];

    if ($city !== '') {
        $sql .= ', city = :city';
        $params[':city'] = $city;
    }

    $sql .= ' WHERE id_user = :id_user';
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    $updatedData = [
        'id_user' => $id,
        'salary' => $salary,
        'biography' => $biography,
        'password_updated' => $password,
        'status' => $status,
    ];

    if ($city !== '') {
        $updatedData['city'] = $city;
    }

    return $updatedData;
}

/**
 * Fetch all projects.
 *
 * @param PDO $pdo PDO connection.
 * @return array   Projects list.
 */
function getProjects(PDO $pdo): array
{
    $sql = 'SELECT * FROM projects ORDER BY title ASC';
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
}

/**
 * Fetch a single project by id.
 *
 * @param PDO $pdo PDO connection.
 * @param int $id  Project id.
 * @return array|null Project row or null.
 */
function getProjectById(PDO $pdo, int $id): ?array
{
    $stmt = $pdo->prepare('SELECT * FROM projects WHERE id_project = :id LIMIT 1');
    $stmt->execute([':id' => $id]);
    $project = $stmt->fetch();
    return $project === false ? null : $project;
}

/**
 * Insert a task for a user and project.
 *
 * @param PDO    $pdo         PDO connection.
 * @param int    $userId      User id.
 * @param int    $projectId   Project id.
 * @param string $title       Task title.
 * @param string $description Task description.
 */
function addTask(PDO $pdo, int $userId, int $projectId, string $title, string $description): void
{
    $sql = 'INSERT INTO tasks (id_user, id_project, title, description, date_time_added) VALUES (:id_user, :id_project, :title, :description, NOW())';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':id_user' => $userId,
        ':id_project' => $projectId,
        ':title' => $title,
        ':description' => $description,
    ]);
}

/**
 * Get tasks for a user ordered by creation time desc.
 *
 * @param PDO $pdo   PDO connection.
 * @param int $userId User id.
 * @return array Tasks with project titles.
 */
function getMyTasks(PDO $pdo, int $userId): array
{
    $sql = 'SELECT t.*, p.title AS project_title FROM tasks t LEFT JOIN projects p ON p.id_project = t.id_project WHERE t.id_user = :id_user ORDER BY t.date_time_added DESC';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id_user' => $userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Get all users ordered by name.
 *
 * @param PDO $pdo PDO connection.
 * @return array   Users list.
 */
function getAllUsers(PDO $pdo): array
{
    $sql = 'SELECT * FROM users ORDER BY name ASC';
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
<?php

declare(strict_types=1);

$GLOBALS['pdo'] = connectToDatabase($dsn, $pdoOptions);

/**
 * Establish a PDO connection using the provided parameter set.
 *
 * @param string $dsn
 * @param array $pdoOptions
 * @return PDO
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

/**
 * returns a greeting and a random message based on the actual hour
 *
 * @return array
 */
function returnRandomMessage(): array
{
    $hour = (int)date("G");

    if ($hour >= 5 && $hour < 10) {
        $greeting = "Good Morning!";
        $options = [
            "Start your day with a strong coffee and a fresh pastry!",
            "No time for breakfast? We've got you covered.",
            "A productive day starts with a delicious meal.",
            "Wake up your taste buds with our breakfast menu!",
            "Fuel up for the day ahead. Order now!"
        ];
        return [
            'greeting' => $greeting,
            'message' => $options[rand(0, count($options) - 1)],
        ];
    } elseif ($hour >= 10 && $hour < 18) {
        $greeting = "Good Day!";
        $options = [
            "Hard at work? You deserve a delicious lunch break.",
            "Skip the cooking, go for the pizza!",
            "Fuel your day with our tasty menu options.",
            "Lunch time is the best time! What are you craving?",
            "Hungry? Our drivers are ready to go."
        ];
        return [
            'greeting' => $greeting,
            'message' => $options[rand(0, count($options) - 1)]
        ];
    } elseif ($hour >= 18 && $hour < 22) {
        $greeting = "Good Evening!";
        $options = [
            "Too tired to cook? Let us handle dinner tonight.",
            "Movie night? A pizza is the perfect companion.",
            "Relax and enjoy a feast delivered right to your door.",
            "Treat yourself to a great burger after a long day.",
            "Dinner is served! Check out our specials."
        ];
        return [
            'greeting' => $greeting,
            'message' => $options[rand(0, count($options) - 1)]
        ];
    } else {
        $greeting = "Still Awake?";
        $options = [
            "Late night cravings? We are still open!",
            "It's never too late for a good pizza.",
            "Midnight snack attack? We're on our way.",
            "Studying late? You need brain food!",
            "The city sleeps, but we don't. Order now!"
        ];
        return [
            'greeting' => $greeting,
            'message' => $options[rand(0, count($options) - 1)]
        ];
    }
}


function getCategories(PDO $pdo): array
{
    $sql = "SELECT * FROM categories ORDER BY name";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getProducts(PDO $pdo, int $id): array
{
    $sql = "SELECT id, name, description, price FROM products WHERE category_id = :id ORDER BY name";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function redirectFn(string $messageType, string $message, string $routeName = 'home'): never
{
    if ($routeName === 'index') $routeName = '';

    header('Location: ' . BASE_URL . $routeName . '?' . $messageType . '=' . urlencode($message));
    exit;
}

function loginUser(PDO $pdo, string $email, string $password): ?array
{
    $sql = "SELECT id, fullname, role, password FROM users WHERE email = :email LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':email' => $email]);

    $user = $stmt->fetch();

    if (!$user) {
        return null;
    }

    if (!empty($user['password']) && password_verify($password, $user['password'])) {
        return [
            'id_user' => (int)$user['id'],
            'fullname' => $user['fullname'],
            'role' => $user['role'],
        ];
    }

    return null;
}

function registerUser(PDO $pdo, string $email, string $password, string $fullName): false|int{
    $sql = "INSERT INTO users (email, password, fullname) VALUES (:email, :password, :fullName)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':email' => $email,
        ':password' => password_hash($password, PASSWORD_BCRYPT),
        ':fullName' => $fullName
    ]);

    $id = $pdo->lastInsertId();
    if(is_numeric($id)) {
        return (int)$id;
    }

    return false;
}

function countOrdersBetween(PDO $pdo, DateTimeImmutable $start, DateTimeImmutable $end): int
{
    $sql = "SELECT COUNT(*) FROM orders WHERE order_date >= :start AND order_date < :end";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':start' => $start->format('Y-m-d H:i:s'),
        ':end' => $end->format('Y-m-d H:i:s'),
    ]);
    return (int)$stmt->fetchColumn();
}

function countRevenueBetween(PDO $pdo, DateTimeImmutable $start, DateTimeImmutable $end): int
{
    $sql = "SELECT total FROM orders WHERE order_date >= :start AND order_date < :end";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':start' => $start->format('Y-m-d H:i:s'),
        ':end' => $end->format('Y-m-d H:i:s'),
    ]);
    return array_sum($stmt->fetchAll(PDO::FETCH_COLUMN, 0));
}
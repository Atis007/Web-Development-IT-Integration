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

function getAllProductsWithCategory(PDO $pdo): array
{
    $productsStmt = $pdo->query(
        "SELECT p.id, p.name, p.description, p.price, c.name AS category_name, p.category_id
	 FROM products p
	 JOIN categories c ON c.id = p.category_id
	 ORDER BY c.name, p.name"
    );
    return $productsStmt->fetchAll();
}

function redirectFn(string $messageType, string $message, string $routeName = 'home'): never
{
    if ($routeName === 'index') $routeName = '';

    header('Location: ' . BASE_URL . $routeName . '?' . $messageType . '=' . urlencode($message));
    exit;
}

function logEvent(PDO $pdo, string $eventType, string $description): void
{
    try {
        $stmt = $pdo->prepare(
            "INSERT INTO system_logs (event_type, description) VALUES (:event_type, :description)"
        );
        $stmt->execute([
            ':event_type' => $eventType,
            ':description' => $description,
        ]);
    } catch (PDOException $e) {
        // Logging should never block the main flow.
    }
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

function registerUser(PDO $pdo, string $email, string $password, string $fullName): false|int
{
    $sql = "INSERT INTO users (email, password, fullname) VALUES (:email, :password, :fullName)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':email' => $email,
        ':password' => password_hash($password, PASSWORD_BCRYPT),
        ':fullName' => $fullName
    ]);

    $id = $pdo->lastInsertId();
    if (is_numeric($id)) {
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

function createOrder(PDO $pdo, int $userId, array $items, int $totalPrice): int
{
    $details = '';
    foreach ($items as $item) {
        $details .= $item['name'] . ' x' . $item['quantity'] . "\n";
    }

    $sql = "INSERT INTO orders (user_id, order_details, total) VALUES (:uid, :details, :price)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':uid' => $userId,
        ':details' => $details,
        ':price' => $totalPrice,
    ]);

    return (int)$pdo->lastInsertId();
}

function createNewProduct(PDO $pdo, int $categoryId, string $name, string $description, int $price): array
{
    $sql = "INSERT INTO products (category_id, name, description, price) VALUES (:category_id, :name, :description, :price)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':category_id' => $categoryId,
        ':name' => $name,
        ':description' => $description,
        ':price' => $price,
    ]);

    if ($pdo->lastInsertId()) {
        $status = [
            'statusMessage' => 'Product created.',
            'statusType' => 'success'
        ];
    } else {
        $status = [
            'statusMessage' => 'Product creation failed.',
            'statusType' => 'error'
        ];
    }

    return $status;
}

function updateProduct(PDO $pdo, int $productId, int $categoryId, string $name, string $description, int $price): array
{
    $sql = "UPDATE products SET category_id = :category_id, name = :name, description = :description, price = :price WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':category_id' => $categoryId,
        ':name' => $name,
        ':description' => $description,
        ':price' => $price,
        ':id' => $productId,
    ]);

    if ($stmt->rowCount() > 0) {
        return [
            'statusMessage' => 'Product updated.',
            'statusType' => 'success'
        ];
    } else {
        return [
            'statusMessage' => 'No changes made or product not found.',
            'statusType' => 'error'
        ];
    }
}

function deleteProduct(PDO $pdo, int $productId): array
{
    $sql = "DELETE FROM products WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $productId]);

    if ($stmt->rowCount() > 0) {
        return [
            'statusMessage' => 'Product deleted.',
            'statusType' => 'success'
        ];
    } else {
        return [
            'statusMessage' => 'Product not found or already deleted.',
            'statusType' => 'error'
        ];
    }
}

function insertMessage(PDO $pdo, string $name, string $email, string $message): array
{
    $sql = "INSERT INTO contact_messages (name, email, message) VALUES (:name, :email, :message)";
    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':name' => $name,
        ':email' => $email,
        ':message' => $message
    ]);

    if ($pdo->lastInsertId()) {
        $status = [
            'statusMessage' => 'Message sent successfully.',
            'statusType' => 'success'
        ];
    } else {
        $status = [
            'statusMessage' => 'Message sending failed.',
            'statusType' => 'contactError'
        ];
    }

    return $status;
}

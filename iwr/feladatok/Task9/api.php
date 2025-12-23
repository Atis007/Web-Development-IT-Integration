<?php
declare(strict_types=1);

require __DIR__ . '/includes/functions.php';

header('Content-Type: application/json; charset=UTF-8');

$pdo = $GLOBALS['pdo'];
$method = $_SERVER['REQUEST_METHOD'];
$requestPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '';
$segments = array_values(array_filter(explode('/', $requestPath)));
$apiIndex = array_search('api', $segments, true);

if ($apiIndex === false) {
    sendJsonResponse(404, ['error' => 'Endpoint not found']);
}

$resourceSegments = array_slice($segments, $apiIndex + 1);

$tokenValue = extractBearerToken();
$tokenRow = validateToken($pdo, $tokenValue);
$tokenId = (int)$tokenRow['id_token'];

$usageToday = getTokenUsageCountForToday($pdo, $tokenId);
if ($usageToday >= (int)$tokenRow['restriction_number']) {
    logTokenUsage($pdo, $tokenId, $_SERVER['REQUEST_URI']);
    sendJsonResponse(429, ['error' => 'Too Many Requests']);
}

logTokenUsage($pdo, $tokenId, $_SERVER['REQUEST_URI']);

try {
    routeRequest($pdo, $method, $resourceSegments);
} catch (InvalidArgumentException $exception) {
    sendJsonResponse(400, ['error' => $exception->getMessage()]);
} catch (RuntimeException $exception) {
    sendJsonResponse(404, ['error' => $exception->getMessage()]);
} catch (Throwable $exception) {
    sendJsonResponse(500, ['error' => 'Server error', 'details' => $exception->getMessage()]);
}

function routeRequest(PDO $pdo, string $method, array $segments): void
{
    $resource = $segments[0] ?? '';

    switch ($resource) {
        case 'products':
            handleProducts($pdo, $method, $segments);
            break;
        case 'categories':
            handleCategories($pdo, $method, $segments);
            break;
        default:
            throw new RuntimeException('Resource not found');
    }
}

function handleProducts(PDO $pdo, string $method, array $segments): void
{
    $idSegment = $segments[1] ?? null;

    if ($method === 'GET' && $idSegment === null) {
        $products = getAllProducts($pdo);
        sendJsonResponse(200, ['data' => $products]);
    }

    if ($method === 'GET' && $idSegment !== null) {
        if (!ctype_digit($idSegment)) {
            throw new InvalidArgumentException('Product identifier must be numeric');
        }

        $product = getProductById($pdo, (int)$idSegment);
        if (!$product) {
            throw new RuntimeException('Product not found');
        }

        sendJsonResponse(200, ['data' => $product]);
    }

    if ($method === 'POST' && $idSegment === null) {
        $payload = validateProductPayload($pdo, getJsonPayload());
        $newId = createProduct($pdo, $payload);
        $product = getProductById($pdo, $newId);

        sendJsonResponse(201, ['message' => 'Product created', 'data' => $product]);
    }

    if ($method === 'DELETE' && $idSegment !== null) {
        if (!ctype_digit($idSegment)) {
            throw new InvalidArgumentException('Product identifier must be numeric');
        }

        $deleted = deleteProduct($pdo, (int)$idSegment);
        if (!$deleted) {
            throw new RuntimeException('Product not found');
        }

        sendJsonResponse(200, ['message' => 'Product deleted']);
    }

    header('Allow: GET, POST, DELETE');
    sendJsonResponse(405, ['error' => 'Method Not Allowed']);
}

function handleCategories(PDO $pdo, string $method, array $segments): void
{
    $secondSegment = $segments[1] ?? null;
    $thirdSegment = $segments[2] ?? null;

    if ($method === 'GET' && $secondSegment === null) {
        $categories = getAllCategories($pdo);
        sendJsonResponse(200, ['data' => $categories]);
    }

    if ($method === 'GET' && $secondSegment !== null && $thirdSegment === 'products') {
        $category = resolveCategory($pdo, $secondSegment);
        if (!$category) {
            throw new RuntimeException('Category not found');
        }

        $products = getProductsByCategoryId($pdo, (int)$category['id_category']);
        sendJsonResponse(200, ['category' => $category, 'products' => $products]);
    }

    header('Allow: GET');
    sendJsonResponse(405, ['error' => 'Method Not Allowed']);
}

function resolveCategory(PDO $pdo, string $value): ?array
{
    if ($value === '') {
        throw new InvalidArgumentException('Category identifier is missing');
    }

    if (ctype_digit($value)) {
        return getCategoryById($pdo, (int)$value);
    }

    return getCategoryByName($pdo, urldecode($value));
}

function validateProductPayload(PDO $pdo, array $data): array
{
    $name = trim((string)($data['name'] ?? ''));
    $price = $data['price'] ?? null;
    $amount = $data['amount'] ?? null;
    $categoryId = $data['id_category'] ?? null;

    if ($name === '') {
        throw new InvalidArgumentException('Product name is required');
    }

    if ($price === null || !is_numeric($price)) {
        throw new InvalidArgumentException('Valid price is required');
    }

    if ($amount === null || !is_numeric($amount)) {
        throw new InvalidArgumentException('Valid amount is required');
    }

    $payload = [
        'name' => $name,
        'price' => number_format((float)$price, 2, '.', ''),
        'amount' => (int)$amount,
    ];

    if ($categoryId === null || $categoryId === '') {
        return $payload;
    }

    if (!ctype_digit((string)$categoryId)) {
        throw new InvalidArgumentException('Category identifier must be numeric');
    }

    $category = getCategoryById($pdo, (int)$categoryId);
    if (!$category) {
        throw new RuntimeException('Category not found');
    }

    $payload['id_category'] = (int)$categoryId;

    return $payload;
}

function getJsonPayload(): array
{
    $content = file_get_contents('php://input');
    $data = json_decode($content, true);

    if (!is_array($data)) {
        throw new InvalidArgumentException('Invalid JSON payload');
    }

    return $data;
}

function extractBearerToken(): string
{
    $header = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
    if ($header === '' && function_exists('getallheaders')) {
        $headers = getallheaders();
        $header = $headers['Authorization'] ?? '';
    }

    if (!preg_match('/Bearer\s+(\S+)/i', $header, $matches)) {
        sendJsonResponse(401, ['error' => 'Missing or invalid Authorization header']);
    }

    return $matches[1];
}

function validateToken(PDO $pdo, string $tokenValue): array
{
    $tokenRow = getTokenByValue($pdo, $tokenValue);
    if (!$tokenRow) {
        sendJsonResponse(401, ['error' => 'Token not recognized']);
    }

    if (!empty($tokenRow['date_expire']) && strtotime($tokenRow['date_expire']) < time()) {
        sendJsonResponse(401, ['error' => 'Token expired']);
    }

    return $tokenRow;
}

function sendJsonResponse(int $statusCode, array $payload): void
{
    http_response_code($statusCode);
    echo json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
}
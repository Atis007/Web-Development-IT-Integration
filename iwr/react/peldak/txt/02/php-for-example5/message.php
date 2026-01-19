<?php
header('Content-Type: application/json; charset=utf-8');

$EXPECTED_TOKEN = '217658fhjUjnJkpSLSLSok9948x7238Mnknfhu4721';

/**
 * Try to read the Authorization header in different ways
 * (some servers expose it differently).
 */
function getAuthorizationHeader(): string {
    // 1) getallheaders (works on Apache; sometimes missing)
    if (function_exists('getallheaders')) {
        $headers = getallheaders();
        foreach ($headers as $key => $value) {
            if (strtolower($key) === 'authorization') {
                return trim($value);
            }
        }
    }

    // 2) Common server variables
    if (!empty($_SERVER['HTTP_AUTHORIZATION'])) {
        return trim($_SERVER['HTTP_AUTHORIZATION']);
    }
    if (!empty($_SERVER['REDIRECT_HTTP_AUTHORIZATION'])) {
        return trim($_SERVER['REDIRECT_HTTP_AUTHORIZATION']);
    }

    return '';
}

$auth = getAuthorizationHeader();

// Expect: "Bearer <token>"
if (!preg_match('/^Bearer\s+(.+)$/i', $auth, $m)) {
    http_response_code(401);
    echo json_encode(['message' => 'Missing Bearer token']);
    exit;
}

$token = trim($m[1]);

if ($token !== $EXPECTED_TOKEN) {
    http_response_code(401);
    echo json_encode(['message' => 'Invalid token']);
    exit;
}

// OPTIONAL: read JSON body (if you send POST JSON from RN)
$body = json_decode(file_get_contents('php://input'), true) ?? [];
$userMessage = isset($body['message']) ? trim((string)$body['message']) : '';

// Demo response (always different)
$data = mt_rand(1, 20000) . time();

sleep(1);

echo json_encode([
    'message' => $userMessage !== ''
        ? "OK ($data). You sent: $userMessage"
        : "OK ($data). No message provided."
]);

<?php
declare(strict_types=1);

/**
 * Fetches data from a given URL using cURL with basic error handling.
 * Returns an associative array containing success status, HTTP code, and response body.
 */
function getCurlData(string $url): array
{
    // https://www.php.net/manual/en/book.curl.php
    // Initialize a cURL session
    $ch = curl_init();
    if ($ch === false) {
        return ['ok' => false, 'error' => 'Failed to initialize cURL', 'status' => 0, 'body' => null];
    }

    // Set essential cURL options
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,                 // Target URL
        CURLOPT_RETURNTRANSFER => true,                 // Return data as a string instead of outputting it
        CURLOPT_FOLLOWLOCATION => true,                 // Follow redirects if any
        CURLOPT_CONNECTTIMEOUT => 5,                    // Maximum time to connect (seconds)
        CURLOPT_TIMEOUT => 10,                   // Maximum execution time (seconds)
    ]);

    // Execute the request
    $body = curl_exec($ch);
    $errno = curl_errno($ch);
    $err = $errno ? curl_error($ch) : '';
    $code = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);

    // Close the cURL session
    curl_close($ch);

    // Handle possible errors
    if ($errno !== 0) {
        return ['ok' => false, 'error' => "cURL error {$errno}: {$err}", 'status' => $code, 'body' => null];
    }
    if ($code < 200 || $code >= 300) {
        return ['ok' => false, 'error' => "Unexpected HTTP status {$code}", 'status' => $code, 'body' => $body];
    }

    // Return successful response
    return ['ok' => true, 'error' => '', 'status' => $code, 'body' => $body];
}

/**
 * Detects the client's IP address from HTTP headers.
 * This function returns the first valid IP found, or 'unknown' if no valid IP is detected.
 * Note: Do not trust forwarded headers unless you are behind a trusted proxy.
 */
function getIpAddress(bool $preferForwarded = false): string
{
    $remote = $_SERVER['REMOTE_ADDR'] ?? '';

    if (!$preferForwarded) {
        return filter_var($remote, FILTER_VALIDATE_IP) ? $remote : 'unknown';
    }

    // Collect potential IPs from headers
    $candidates = [];
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        // Often contains a list: "client, proxy1, proxy2"
        $parts = array_map('trim', explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']));
        $candidates = array_merge($candidates, $parts);
    }
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $candidates[] = trim($_SERVER['HTTP_CLIENT_IP']);
    }
    if (!empty($remote)) {
        $candidates[] = $remote;
    }

    // Return the first valid IP (IPv4 or IPv6)
    foreach ($candidates as $ip) {
        if (filter_var($ip, FILTER_VALIDATE_IP)) {
            return $ip;
        }
    }

    return 'unknown';
}

$ipAddress = getIpAddress();
var_dump($ipAddress);

// Example IP (for testing purposes)
$ipAddress = "103.14.26.0";

// Free API for geolocation (HTTP only, not HTTPS)
$url = "http://ip-api.com/json/{$ipAddress}";
// http://ip-api.com/json/103.14.26.0
//$url = "http://localhost/iws_2025/01/5-IP_API/test2.php";

$response = getCurlData($url);
var_dump($response);


if ($response['ok'] && is_string($response['body'])) {
    $data = json_decode($response['body'], true);
    var_dump($data);


    if (json_last_error() === JSON_ERROR_NONE && is_array($data)) {
        var_dump($data);
    } else {
        var_dump(['json_error' => json_last_error_msg(), 'raw' => $response['body']]);
    }
} else {
    var_dump(['fetch_error' => $response['error'], 'status' => $response['status']]);
}

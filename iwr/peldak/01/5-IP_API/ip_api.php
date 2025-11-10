<?php
/**
 * Services:
 * 1. ip-api.com         (no key, HTTP only)
 * 2. iplocate.io        (HTTPS, requires API key)
 * 3. ipqualityscore.com (HTTPS, requires API key)
 */

$ipAddress = "103.14.26.0"; // Example IP (Mexico)
//$ipAddress = "127.0.0.1"; // Localhost

// ------------------------------------------------------
// Helper function: send HTTP GET request using cURL
// ------------------------------------------------------
function getCurlData(string $url): ?string
{
    $ch = curl_init();
    if (!$ch) return null;

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);

    $result = curl_exec($ch);
    $ok = !curl_errno($ch);
    curl_close($ch);

    return $ok && is_string($result) ? $result : null;
}

// ------------------------------------------------------
// 1) ip-api.com (no API key required, but HTTP only!)
// ------------------------------------------------------
$fields = "country,proxy,isp";
$urlApi0 = "http://ip-api.com/json/$ipAddress?fields=$fields";

$response0 = getCurlData($urlApi0);
if ($response0) {
    $data0 = json_decode($response0, true);

    var_dump($data0);

    echo "<h3>ip-api.com</h3>";
    echo "Country: " . ($data0['country'] ?? 'N/A') . "<br>";
    echo "ISP: " . ($data0['isp'] ?? 'N/A') . "<br>";
    echo "Proxy: " . (isset($data0['proxy']) ? ($data0['proxy'] ? 'Yes' : 'No') : 'N/A') . "<hr>";
} else {
    echo "<h3>ip-api.com</h3>Request failed<hr>";
}

// ------------------------------------------------------
// 2) iplocate.io (requires free API key)
// ------------------------------------------------------
$iplocateApiKey = "ac4c3c3345b37c09b10bc99e6266a39b"; // Example key
$urlApi1 = "https://www.iplocate.io/api/lookup/$ipAddress?apikey=$iplocateApiKey";

$response1 = getCurlData($urlApi1);
if ($response1) {
    $data1 = json_decode($response1, true);

    var_dump($data1);

    echo "<h3>iplocate.io</h3>";
    echo "Country: " . ($data1['country'] ?? 'N/A') . "<br>";
    echo "ISP: " . ($data1['org'] ?? 'N/A') . "<br>";
    $isProxy = $data1['threat']['is_proxy'] ?? null;
    echo "Proxy: " . ($isProxy === null ? 'N/A' : ($isProxy ? 'Yes' : 'No')) . "<hr>";
} else {
    echo "<h3>iplocate.io</h3>Request failed<hr>";
}

// ------------------------------------------------------
// 3) ipqualityscore.com (requires API key)
// ------------------------------------------------------
$ipqsApiKey = "6aa41289da3bcd3e222cf27e1385af68"; // Example key

/*
 Parameters in the IPQualityScore request:

 • $apiKey – your personal API key
 • $ipAddress – IP address you want to analyze

 • strictness=0
   Uses the lowest strictness level (0–3) for fraud scoring.
   Increasing this value expands the number of checks performed.
   Levels 2+ have a higher risk of false positives.

 • allow_public_access_points=true
   Allows connections from public or corporate networks such as
   universities, hotels, businesses, and institutions.

 • lighter_penalties=true
   Reduces scoring and proxy detection for mixed-quality IP addresses
   to prevent false positives.

 • mobile=true
   Forces the IP to be scored as a mobile device.
   Passing the "user_agent" parameter automatically detects
   the device type instead.
*/

$mobile = "true";
$urlApi2 = "https://ipqualityscore.com/api/json/ip/$ipqsApiKey/$ipAddress"
    . "?strictness=0&allow_public_access_points=true&lighter_penalties=true&mobile=$mobile";

$response2 = getCurlData($urlApi2);
if ($response2) {
    $data2 = json_decode($response2, true);

    var_dump($data2);

    echo "<h3>ipqualityscore.com</h3>";
    echo "Country: " . ($data2['country_code'] ?? 'N/A') . "<br>";
    echo "ISP: " . ($data2['ISP'] ?? 'N/A') . "<br>";
    echo "Proxy: " . (isset($data2['proxy']) ? ($data2['proxy'] ? 'Yes' : 'No') : 'N/A') . "<br>";
    echo "TOR: " . (isset($data2['tor']) ? ($data2['tor'] ? 'Yes' : 'No') : 'N/A') . "<br>";
    echo "Bot: " . (isset($data2['is_bot']) ? ($data2['is_bot'] ? 'Yes' : 'No') : 'N/A') . "<hr>";
} else {
    echo "<h3>ipqualityscore.com</h3>Request failed<hr>";
}
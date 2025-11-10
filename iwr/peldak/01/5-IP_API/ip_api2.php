<?php
$ipAddress = "103.14.26.0"; // Example IP (Mexico)
//$ipAddress = "8.8.8.8"; // Google DNS
//$ipAddress = $_SERVER['REMOTE_ADDR']; // Real visitor IP


function getCurlData(string $url): ?array
{
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_CONNECTTIMEOUT => 5,
        CURLOPT_TIMEOUT => 10,
        CURLOPT_SSL_VERIFYPEER => false, // skip SSL check for demo
    ]);
    $response = curl_exec($ch);
    $ok = !curl_errno($ch);
    curl_close($ch);

    return $ok ? json_decode($response, true) : null;
}

// ------------------------------------------------------
// 1) ip-api.com  (HTTP only, no API key)
// ------------------------------------------------------
$url1 = "http://ip-api.com/json/$ipAddress?fields=status,country,isp,proxy";
$data1 = getCurlData($url1);

echo "<h3>1) ip-api.com</h3>";
if ($data1) {
    echo "Country: " . ($data1['country'] ?? 'N/A') . "<br>";
    echo "ISP: " . ($data1['isp'] ?? 'N/A') . "<br>";
    echo "Proxy: " . (isset($data1['proxy']) ? ($data1['proxy'] ? 'Yes' : 'No') : 'N/A') . "<hr>";
} else {
    echo "Request failed<hr>";
}

// ------------------------------------------------------
// 2) ipwho.is (HTTPS, no API key)
// Docs: https://ipwhois.io/documentation
// ------------------------------------------------------
$url2 = "https://ipwho.is/$ipAddress";
$data2 = getCurlData($url2);

echo "<h3>2) ipwho.is</h3>";
if ($data2) {
    echo "Country: " . ($data2['country'] ?? 'N/A') . "<br>";
    echo "ISP: " . ($data2['connection']['isp'] ?? 'N/A') . "<br>";
    echo "Proxy: " . (isset($data2['security']['proxy']) ? ($data2['security']['proxy'] ? 'Yes' : 'No') : 'N/A') . "<br>";
    echo "VPN: " . (isset($data2['security']['vpn']) ? ($data2['security']['vpn'] ? 'Yes' : 'No') : 'N/A') . "<br>";
    echo "Tor: " . (isset($data2['security']['tor']) ? ($data2['security']['tor'] ? 'Yes' : 'No') : 'N/A') . "<hr>";
} else {
    echo "Request failed<hr>";
}

// ------------------------------------------------------
// 3) proxycheck.io (HTTPS, limited free use, no key needed)
// Docs: https://proxycheck.io/api/
// ------------------------------------------------------
$url3 = "https://proxycheck.io/v2/$ipAddress?vpn=1&asn=1";
$data3 = getCurlData($url3);

echo "<h3>3) proxycheck.io</h3>";
if ($data3 && isset($data3[$ipAddress])) {
    $info = $data3[$ipAddress];
    echo "Country: " . ($info['country'] ?? 'N/A') . "<br>";
    echo "ISP: " . ($info['provider'] ?? 'N/A') . "<br>";
    echo "Proxy: " . (($info['proxy'] ?? 'no') === 'yes' ? 'Yes' : 'No') . "<br>";
    echo "Type: " . ($info['type'] ?? 'N/A') . "<br>"; // e.g., VPN, TOR, Residential
    echo "ASN (Autonomous System Number): " . ($info['asn'] ?? 'N/A') . "<hr>";
} else {
    echo "Request failed<hr>";
}



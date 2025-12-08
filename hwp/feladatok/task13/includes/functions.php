<?php
declare(strict_types=1);

use JetBrains\PhpStorm\NoReturn;

require 'config.php';
$GLOBALS['pdo'] = connectDatabase($dsn, $pdoOptions);

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
function connectDatabase(string $dsn, array $pdoOptions): PDO
{
    try {
        $pdo = new PDO($dsn, PARAMS['USER'], PARAMS['PASSWORD'], $pdoOptions);
    } catch (\PDOException $e) {
        var_dump($e->getCode());
        throw new \PDOException($e->getMessage());
    }

    return $pdo;
}

/**
 * Get the client's IP address as a validated string.
 *
 * Note: HTTP_* values may be spoofed. Use REMOTE_ADDR unless you trust your proxy network.
 *
 * @return string IPv4/IPv6 address in string format, or "unknown" if invalid.
 */
function getIpAddress(): string
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }

    if (!filter_var($ip, FILTER_VALIDATE_IP)) {
        $ip = "unknown";
    }
    return $ip;
}

/**
 * Extract GPS coordinates from EXIF metadata and convert to decimal format.
 *
 * @param array $exif_data EXIF array obtained using exif_read_data().
 *
 * @return array|null       Returns ['latitude' => float, 'longitude' => float] or null if GPS is missing.
 */
function getGpsCoordinatesFromExif(array $exif_data): ?array
{
    if (isset($exif_data['GPS']) && is_array($exif_data['GPS']) && count($exif_data['GPS']) > 0) {

        $latRef = $exif_data['GPS']['GPSLatitudeRef'];
        $latitude = convertGpsToDecimal($exif_data['GPS']['GPSLatitude'], $latRef, 'latitude');

        $lonRef = $exif_data['GPS']['GPSLongitudeRef'];
        $longitude = convertGpsToDecimal($exif_data['GPS']['GPSLongitude'], $lonRef, 'longitude');

        return ['latitude' => $latitude, 'longitude' => $longitude];
    }

    return null;
}

/**
 * Convert GPS coordinates from EXIF format into decimal degrees.
 *
 * @param array $gpsData Array in DMS (degrees/minutes/seconds) form as returned by EXIF.
 * @param string $ref N/S or E/W indicating hemisphere.
 * @param string $type 'latitude' or 'longitude' — affects sign assignment.
 *
 * @return float           Decimal converted coordinate (negative if W or S).
 */
function convertGpsToDecimal(array $gpsData, string $ref, string $type): float
{
    // Degrees
    $parts = explode('/', $gpsData[0]);
    $degrees = $parts[0] / $parts[1];

    // Minutes
    $parts = explode('/', $gpsData[1]);
    $minutes = $parts[0] / $parts[1];

    // Seconds
    $parts = explode('/', $gpsData[2]);
    $seconds = $parts[0] / $parts[1];

    // Convert to decimal: D + (M*60 + S) / 3600
    $seconds += ($minutes * 60);
    $decimal = $degrees + ($seconds / 3600);

    // Apply negative for South or West
    if (($ref === "S" && $type === 'latitude') || ($ref === "W" && $type === 'longitude')) {
        $decimal *= -1;
    }

    return $decimal;
}

/**
 *  Insert a failed upload attempt into the logs table.
 *
 *  This function records the attempted file name and the client's IP address
 *  into the `logs` database table. Intended to be used whenever a validation
 *  or upload condition fails.
 *
 * @param PDO $pdo           Active PDO connection
 * @param string $file_name  Name of the file attempted to be uploaded.
 * @param string $ip_address Client's IP address
 *
 * @return void
 */
function insertIntoLog(PDO $pdo, string $file_name, string $ip_address): void{
    $sql = "INSERT INTO logs (file_name, ip_address) VALUES(?,?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$file_name, $ip_address]);
}

/**
 *  Log the failed upload attempt and immediately redirect the user
 *  back to index.php with an error message.
 *
 *  This helper is used whenever an upload condition fails. It logs the
 *  attempted file name, captures the client's IP address, stores the log,
 *  and then redirects the user back to the upload form displaying
 *  the specific validation error.
 *
 * @param PDO $pdo       Active PDO connection instance.
 * @param array $file    The $_FILES['file'] array or an empty array.
 *                              If the file field was missing, file['name']
 *                              defaults to "NO_FILE".
 * @param string $message Readable error message to display it at index.php
 * @return void
 */
#[NoReturn]
function redirectFn(PDO $pdo, array $file, string $message): void{
    $ip=getIpAddress();
    $file_name = $file["name"] ?? 'NO_FILE';

    insertIntoLog($pdo, $file_name, $ip);

    header("Location: index.php?error=" . urlencode($message));
    exit;
}

function insertIntoImages(PDO $pdo, ?float $lat, ?float $long, string $image): void{
    $sql = "INSERT INTO images (latitude, longitude, image) VALUES(?,?,?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$lat, $long, $image]);
}

function getImages(PDO $pdo): array{
    $sql = "SELECT * FROM images";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
}
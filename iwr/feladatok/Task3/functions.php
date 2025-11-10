<?php
require __DIR__ . '/vendor/autoload.php';

/** Function tries to connect to database using PDO
 * @param string $dsn
 * @param array $pdoOptions
 * @return PDO
 */
function connectDatabase(string $dsn, array $pdoOptions): PDO
{
    try {
        $pdo = new PDO($dsn, PARAMS['USER'], PARAMS['PASSWORD'], $pdoOptions);
    } catch (PDOException $e) {
        var_dump($e->getCode());
        throw new PDOException($e->getMessage());
    }
    return $pdo;
}

function insertIntoLog(PDO $pdo, string $randomName, string $randomNumber): void
{
    $sql = "INSERT INTO task3(random_name, random_number) VALUES(?, ?)";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(1, $randomName, PDO::PARAM_STR);
    $stmt->bindValue(2, $randomNumber, PDO::PARAM_STR);

    $stmt->execute();
}

function getLogData(PDO $pdo): array
{
    $sql = "SELECT random_name, random_number, DATE_FORMAT(date_time, '%d.%m.%Y. %T') as date FROM task3 ORDER BY date_time DESC LIMIT 10";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

function getCurlData(string $url): ?string
{
    $ch = curl_init();
    if (!$ch) return null;

    curl_setopt_array($ch, [
        CURLOPT_URL => $url, ////honnan keri le az adatokat
        CURLOPT_RETURNTRANSFER => true, // false-> kiirja rogton a kepernyore, true-> visszaadja a curl_exec hivasnak, es ellehet menteni egy valtozoba
        CURLOPT_FOLLOWLOCATION => true, //Engedélyezi a HTTP átirányítások automatikus követését.
        //ha a szerver átirányítást küld (pl. 301,302 kód), akkor a cURL magától követi az új URL-t.
        CURLOPT_CONNECTTIMEOUT => 5, //Ennyi másodpercet vár, hogy sikerüljön csatlakozni a szerverhez. Ha 5 másodpercen belül nem tud kapcsolatot létesíteni, megszakad hibával
        CURLOPT_TIMEOUT => 10, //A teljes kérés (kapcsolódás + letöltés) maximális ideje másodpercben. Ha 10 másodperc alatt nem fejeződik be a lekérés, leáll hibával
    ]);

    $result = curl_exec($ch);
    $ok = !curl_errno($ch);
    curl_close($ch);

    return $ok && is_string($result) ? $result : null;
}
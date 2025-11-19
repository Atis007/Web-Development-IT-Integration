<?php
declare(strict_types=1);

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

/** Function that inserting data to the database
 * @param PDO $pdo
 * @param string $name
 * @param string $email
 * @param string $schedules
 * @return void
 */
function insertData(PDO $pdo, string $name, string $email, string $schedules): void
{
    $sql = "INSERT INTO schedules
            (name, email, schedules, created_at)
            VALUES (:n, :e, :schedules, NOW())";

    $stmt = $pdo->prepare($sql);

    $stmt->bindValue(':n', $name, PDO::PARAM_STR);
    $stmt->bindValue(':e', $email, PDO::PARAM_STR);
    $stmt->bindValue(':schedules', $schedules, PDO::PARAM_STR);
    $stmt->execute();
}

/** Processes the text as the task asks
 * @param string $name
 * @param string $email
 * @param string $schedules
 * @return array
 */
function processText(string $name, string $email, string $schedules): array {
    $name = trim(preg_replace('/\s+/', ' ', $name)); ; // preg_replace -> every whitespace → 1 space.
    $email = trim(preg_replace('/\s+/', ' ', $email));

    $name = ucwords($name);

    $scheduleParts = explode(",", $schedules);

    $formattedSchedules = array_map(function ($schedule) {
        $dt = DateTime::createFromFormat('Y-m-d', trim($schedule));
        return $dt ? $dt->format('Y. m. d.') : '';
    }, $scheduleParts);

    $formattedSchedules = array_filter($formattedSchedules);
    $formattedSchedulesString = implode(', ', $formattedSchedules);

    return [$name, $email, $formattedSchedulesString];
}
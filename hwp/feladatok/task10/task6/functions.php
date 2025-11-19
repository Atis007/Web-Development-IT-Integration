<?php
declare(strict_types=1);

/** Function tries to connect to database using PDO
 * @param string $dsn
 * @param array $pdoOptions
 * @return PDO
 */
function connectDatabase(string $dsn, array $pdoOptions): PDO
{

    try {
        $pdo = new PDO($dsn, PARAMS['USER'], PARAMS['PASSWORD'], $pdoOptions);
    } catch (\PDOException $e) {
        throw new RuntimeException('Database connection failed: ' . $e->getMessage(), 0, $e);
    }

    return $pdo;
}

/**
 * @param string $input
 * @return array
 */
function validateInput(string $input): array{
    $errors   = [];
    $warnings = [];

    $trimmedPayload = trim($input);

    if ($trimmedPayload === '') {
        $errors[] = 'The labels textarea cannot be empty.';
        return [
            'rows'     => [],
            'errors'   => $errors,
            'warnings' => $warnings,
        ];
    }

    // Divide into rows (Windows / Linux / Mac line ending)
    $rows = preg_split('/\r\n|\r|\n/', $trimmedPayload);
    if ($rows === false) {
        $errors[] = 'Could not split the input into lines.';
        return [
            'rows'     => [],
            'errors'   => $errors,
            'warnings' => $warnings,
        ];
    }

    // Max. 200 rows
    if (count($rows) > 200) {
        $errors[] = 'Maximum number of rows is 200. You have ' . count($rows) . ' rows.';
    }

    return [
        'rows'     => $rows,
        'errors'   => $errors,
        'warnings' => $warnings,
    ];
}

/**
 * @param array $rows
 * @return array
 */
function processTextList(array $rows): array
{
    $inputCount = count($rows);

    $trimmed = array_map(
        static fn (string $row): string => trim($row),
        $rows
    );

    $nonEmpty = array_filter(
        $trimmed,
        static fn (string $row): bool => $row !== ''
    );

    $splitRows = [];
    foreach ($nonEmpty as $row) {
        $length = mb_strlen($row, 'UTF-8');

        if ($length <= 50) {
            $splitRows[] = $row;
            continue;
        }

        $chunks = mb_str_split($row, 50, 'UTF-8');

        foreach ($chunks as $chunk) {
            $chunk = trim($chunk);
            if ($chunk === '') {
                continue;
            }
            $splitRows[] = $chunk;
        }
    }

    $normalized = array_map(
        static function (string $row): string {

            $lower = mb_strtolower($row, 'UTF-8');

            $collapsed = preg_replace('/\s+/u', ' ', $lower);
            if ($collapsed === null) {
                $collapsed = $lower;
            }

            $withHyphen = str_replace(' ', '-', $collapsed);

            return trim($withHyphen, "- \t\n\r\0\x0B");
        },
        $splitRows
    );

    $seen           = [];
    $uniqueOriginal = [];
    $uniqueCleaned  = [];

    foreach ($normalized as $key => $clean) {
        if ($clean === '') {
            continue;
        }

        if (isset($seen[$clean])) {
            continue;
        }

        $seen[$clean]      = true;
        $uniqueOriginal[]  = $splitRows[$key];
        $uniqueCleaned[]   = $clean;
    }

    $savedCount = count($uniqueCleaned);

    return [
        'original' => $uniqueOriginal,
        'cleaned'  => $uniqueCleaned,
        'counts'   => [
            'input' => $inputCount,
            'saved' => $savedCount,
        ],
    ];
}

/**
 * @param PDO $pdo
 * @param array $original
 * @param array $cleaned
 * @return void
 */
function saveTags(PDO $pdo, array $original, array $cleaned): void
{
    if (count($original) !== count($cleaned)) {
        throw new InvalidArgumentException('Original and cleaned tag counts do not match.');
    }

    if ($original === []) {
        return;
    }

    $pdo->beginTransaction();

    try {
        $sql  = 'INSERT INTO tags (raw_text, clean_text) VALUES (:raw_text, :clean_text)';
        $stmt = $pdo->prepare($sql);

        foreach ($cleaned as $idx => $cleanText) {
            $stmt->execute([
                ':raw_text'   => $original[$idx],
                ':clean_text' => $cleanText,
            ]);
        }

        $pdo->commit();
    } catch (Throwable $e) {
        $pdo->rollBack();
        throw new RuntimeException('Error while saving tags: ' . $e->getMessage(), 0, $e);
    }
}

/**
 *
 * @param PDO $pdo
 * @return array<int, array<string,mixed>>
 */
function getAllTags(PDO $pdo): array
{
    $sql  = 'SELECT id, raw_text, clean_text, created_at FROM tags ORDER BY created_at DESC';
    $stmt = $pdo->query($sql);

    return $stmt->fetchAll();
}
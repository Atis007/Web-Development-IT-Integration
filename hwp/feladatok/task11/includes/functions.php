<?php
$GLOBALS['pdo'] = connectDatabase($dsn, $pdoOptions);

/**
 * Function tries to connect to database using PDO.
 *
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

/**
 * Get bad words list (normalized to lowercase).
 *
 * @param PDO $pdo
 * @return string[]  Array of words (lowercase)
 */
function getBadWords(PDO $pdo): array{
    $sql = "SELECT word FROM bad_words";

    $stmt = $pdo->query($sql);
    $words = $stmt->fetchAll(PDO::FETCH_COLUMN);

    return array_map('strtolower', array_map('trim', $words)); //just the words, not arrays inside an array
}

/**
 * Filter comment: trim, strip tags, htmlspecialchars, replace bad words,
 * insert into comments and count bad word occurrences.
 *
 * @param PDO $pdo
 * @param string $comment
 * @param string[] $badwords  array of lowercase bad words
 * @return string  filtered comment (first letter uppercase)
 */
function filterComment(PDO $pdo, string $comment, array $badwords): string{
    $comment = strip_tags($comment);
    $comment = htmlspecialchars($comment);

    $words = explode(' ', $comment);
    $newWords = [];
    foreach ($words as $word) {
        $helper = strtolower(preg_replace('/[^a-z0-9]/i', '', $word));
        // need to be at least tree letter to work, else it would be: **
        if(strlen($helper)>2 && in_array($helper, $badwords)) {

            updateBadWords($pdo, $helper);

            $firstLetter = $word[0];
            $lastLetter = $word[strlen($word)-1];
            $middle = str_repeat('*', strlen($helper)-2);

            $newWords[] = $firstLetter.$middle.$lastLetter;
        }else {
            $newWords[] = $word;
        }

    }

    $newComment = ucfirst(implode(' ', $newWords));
    insertComments($pdo, $newComment);

    return $newComment;
}

/**
 * Update bad_words.number per word multiple times (aggregated).
 *
 * @param PDO $pdo
 * @param array $counts  ['spam' => 2, 'fake' => 1]
 * @return void
 */
function updateBadWords(PDO $pdo, string $word): void{
    $sql = "UPDATE bad_words SET number = number + 1 WHERE word = :w";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':w', $word, PDO::PARAM_STR);
    $stmt->execute();
}

/**
 * Insert comment into comments table.
 *
 * @param PDO $pdo
 * @param string $comment
 * @return void
 */
function insertComments(PDO $pdo, string $comment): void{
    $sql = "INSERT INTO comments(text, created_at) VALUES(:text, NOW())";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':text', $comment, PDO::PARAM_STR);
    $stmt->execute();
}

/**
 * Get all comments ordered by created_at desc.
 *
 * @param PDO $pdo
 * @return array
 */
function getComments(PDO $pdo): array{
    $sql = "SELECT * FROM comments ORDER BY created_at DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
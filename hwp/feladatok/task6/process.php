<?php
function hasDigit($word)
{
    return preg_match("/\d/", $word) === 1;
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $message = trim($_POST['message'] ?? '');
    $words = explode(" ", $message);

    $filtered = array_filter($words, function ($word) {
        return !hasDigit($word);
    });

    $pool = [
        "alpha", "bravo", "charlie", "delta", "echo",
        "foxtrot", "golf", "hotel", "india", "juliet"
    ];
    $randomPoolWord = $pool[array_rand($pool)];

    if (!empty($filtered)) {
        $randomUserWord = $filtered[array_rand($filtered)];

        $newWord = $randomUserWord . " " . $randomPoolWord;

        foreach ($words as $index => $w) {
            if ($w === $randomUserWord) {
                $words[$index] = $newWord;
                break;
            }
        }

    } else {
        $words[] = $randomPoolWord;
    }

    $modified = implode(" ", $words);
}
?>

<!doctype html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Eredmény</title>
</head>
<body>

<h2>Eredeti szöveg:</h2>
<p><?= htmlspecialchars($message) ?></p>

<h2>Átalakított szöveg:</h2>
<p><?= htmlspecialchars($modified) ?></p>

</body>
</html>

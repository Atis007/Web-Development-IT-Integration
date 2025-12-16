<?php
require 'config.php';
require 'includes/functions.php';

$pdo = connectDatabase($dsn, $pdoOptions);
// Generate 250 rows
for ($i = 0; $i < 250; $i++) {
    $text = generateText();
    $date = generateRandomDate();

    insertText($pdo, $text, $date);
}

echo "Generated and inserted 250 rows into text_data.";

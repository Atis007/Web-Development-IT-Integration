<?php
require 'includes/functions.php';

$pdo = $GLOBALS['pdo'];
$faker=Faker\Factory::create();

$path = __DIR__ . '/../words/20k.txt';
$wordsList = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$operators = ['*','-','+', '/'];

// commented out so it doesn't run unnecessarily
//foreach ($wordsList as $word) {
//    $ops = $operators[$faker->numberBetween(0,count($operators)-1)];
//    $temp = $word . $ops;
//
//    insertIntoWords($pdo, $temp);
//}
//echo "Inserted the words list to the database.";

echo "Word generating and database inserting page";



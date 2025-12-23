<?php
declare(strict_types=1);

require __DIR__ . '/includes/functions.php';

use Faker\Factory;

$pdo = $GLOBALS['pdo'];
$faker = Factory::create();

$requiredTotal = 50;
$currentlyStored = getTokenCount($pdo);

if ($currentlyStored >= $requiredTotal) {
    exit('Token table already contains 50 or more records.' . PHP_EOL);
}

$tokensToCreate = $requiredTotal - $currentlyStored;

for ($i = 0; $i < $tokensToCreate; $i++) {
    $token = $faker->sha256;
    $restriction = $faker->numberBetween(10, 25);
    $expiresAt = $faker->dateTimeBetween('now', '+1 day')->format('Y-m-d H:i:s');

    insertIntoTokens($pdo, $token, $restriction, $expiresAt);
}

echo sprintf('Inserted %d new token(s).', $tokensToCreate) . PHP_EOL;
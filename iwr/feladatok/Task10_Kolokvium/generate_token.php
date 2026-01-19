<?php
date_default_timezone_set('Europe/Belgrade');
require "includes/functions.php";
use Faker\Factory;

$faker = Factory::create();

$token = $faker->regexify('[A-Za-z0-9]{80}');

$expiresAt = date('Y-m-d H:i:s', strtotime('+18 hours'));
//tokenTableInsert($GLOBALS['pdo'], $token, $expiresAt);
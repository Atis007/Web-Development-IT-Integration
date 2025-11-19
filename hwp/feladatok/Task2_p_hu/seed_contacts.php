<?php
require_once 'vendor/autoload.php';
include 'config.php';
include 'functions.php';

$pdo = connectDatabase($dsn, $pdoOptions);

use Faker\Factory;
use Faker\Provider\sr_Latn_RS\Person as SrPerson;
use Faker\Provider\sr_Latn_RS\Address as SrAddress;
use Faker\Provider\hu_HU\Person as HuPerson;
use Faker\Provider\hu_HU\Address as HuAddress;

$fakerSr = Factory::create('sr_Latn_RS');
$fakerSr->addProvider(new SrPerson($fakerSr));
$fakerSr->addProvider(new SrAddress($fakerSr));

$fakerHu = Factory::create('hu_HU');
$fakerHu->addProvider(new HuPerson($fakerHu));
$fakerHu->addProvider(new HuAddress($fakerHu));

$fakers = [
    'sr' => $fakerSr,
    'hu' => $fakerHu,
];

$startDate = new DateTime('2000-01-01 00:00:00');
$endDate = new DateTime();

for ($i = 1; $i <= 1000; $i++) {

    $localeKey = array_rand($fakers);
    $faker = $fakers[$localeKey];

    $firstName = $faker->firstName();
    $lastName = $faker->lastName();
    $email = $faker->email();
    $street = $faker->streetAddress();
    $city = $faker->city();
    $date = $faker->dateTimeBetween($startDate, $endDate)->format('Y.m.d H:i:s');


    echo "#$i [$localeKey] $firstName $lastName email: $email – $street, $city. Date issued: $date<br>";
}

for($i = 1; $i <= 1000; $i++) {}
insertData($pdo, $firstName, $lastName, $email, $street, $city, $date);
getData($pdo);
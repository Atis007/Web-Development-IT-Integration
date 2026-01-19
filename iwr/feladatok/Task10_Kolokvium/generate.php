<?php
require 'includes/functions.php';
$faker=Faker\Factory::create();


$name = $faker->firstName() . " " . $faker->lastName();
$job = $faker->jobTitle();
$email = $faker->unique()->email();
$phone = $faker->phoneNumber();
$workerSalary = $faker->randomElement($GLOBALS['salary']);
$company = $faker->company();

//insertWorkers($GLOBALS['pdo'], $name, $job, $email, $phone, $workerSalary, $company);
//$workers = getWorkers($GLOBALS['pdo']);

/*foreach ($workers as $worker) {
    $fn = createWorkerQrCode($worker['id_worker'], $worker['company_name']);
    insertQrCode($GLOBALS['pdo'], $worker['id_worker'], $fn);
}*/
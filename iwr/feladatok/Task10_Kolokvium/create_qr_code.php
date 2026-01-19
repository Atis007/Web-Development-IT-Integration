<?php
require "includes/functions.php";
use Faker\Factory;

$faker = Factory::create();

$string = '';
for($i = 1; $i < 11; $i++){
    if($i%2===0){
      $string .= ucfirst($faker->randomLetter());
    } else {
        $string .= $faker->randomLetter();
    }
}
//createQrCode($string);
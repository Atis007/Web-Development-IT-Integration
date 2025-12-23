<?php
require_once "includes/functions.php";

$cat_temp = getCategories();
$categories = [];

foreach($cat_temp as $cat){
    $numbersOnly = preg_replace("/[^0-9]/", "", $cat);
    $lettersOnly = preg_replace("/[^a-zA-Z]/", "", $cat);

    $index = rand(1000, 5000) + (int)$numbersOnly;

    $categories[$index] = $lettersOnly;
}

ksort($categories); //sorting by index
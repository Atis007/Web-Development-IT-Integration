<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>php 11</title>
</head>
<body>
<?php

define("CITY", "Subotica");

define("NUMBER", 12);
//define("GREETING", "Welcome to StartIt Center",true);
define("GREETING", "Welcome to StartIt Center");

// Defining case-insensitive constants is deprecated as of PHP 7.3.0. As of PHP 8.0.0, only false is an acceptable value,
// passing true will produce a warning.

define("MY_SCHOOL", "sc");

echo CITY;


echo "<p>" . CITY . "</p>";

echo "<br>" . GREETING . "<br>";
//echo "<br>" . greeting . "<br>";

echo "CITY constant value: " . CITY;
echo "<br>";
echo "NUMBER constant value: " . NUMBER;

$result = 45 + NUMBER;
echo "<p>Result of (45 + NUMBER) is: $result</p>";

const CARS = [
    "Alfa Romeo",
    "BMW",
    "Toyota"
];

echo CARS[2];

define("INPUT1", [
    "Your name",
    "enter your name",
    "Please, enter your name!"
]);


const INPUT2 = [
    "Your password",
    "enter your password",
    "Please, enter your password!"
];

if(1 === 1) {
    define('school','vts');
}


echo '<p><label>' . INPUT1[0] . '</label>
      <input type="text" name="name" id="name" placeholder="' . INPUT1[1] . '">
      <span class="error">' . INPUT1[2] . '</span></p>';


if (defined('CITY')) {
    echo "<p>" . CITY . "</p>";
}


function getValue()
{
    return "CITY";
}

$value = getValue();

echo constant($value);

const SCHOOL = "VTS";
echo SCHOOL;

if(defined('SCHOOL'))
    echo "<br>SCHOOL is defined!";


/*
 As opposed to defining constants using define(), constants defined using the const keyword must be declared at the
top-level scope because they are defined at compile-time. This means that they cannot be declared inside functions,
loops, if statements or try/catch blocks.
 */
// http://php.net/manual/en/reserved.constants.php
// http://php.net/manual/en/language.constants.predefined.php
?>
</body>
</html>
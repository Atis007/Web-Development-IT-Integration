<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>php 32</title>
</head>
<body>
<?php
var_dump(range(10, 19));

foreach (range(0, 9) as $number) {
    $colors0[$number] = "vts";
}

var_dump($colors0);

var_dump(range(0, 9, 2));

foreach (range(0, 9, 2) as $number) {
    $colorsTwo[$number] = "vts";
}

var_dump($colorsTwo);

$colors = ["blue", "blue", "blue", "blue"];
$colors[] = "red";
$colors[] = "red";
$colors[] = "red";
$colors[] = "red";

var_dump($colors);

echo "<br>";
$colors2 = array_fill(0, 5, [1, 2, 3, 4, 5]);
/*

array array_fill ( int $start_index , int $num , mixed $value )
Fills an array with $num entries of the value of the $value parameter, keys starting at the $start_index parameter.

*/
var_dump($colors2);

echo "<br>";
$colors3 = array_fill(4, 3, "black");
$colors3[] = "white";
var_dump($colors3);

$firstNumber = count($colors);
$secondNumber = count($colors2);

echo "<br><br>";
echo "$firstNumber elements in the first array.<br><br>";
echo "$secondNumber elements in the second array. <br><br>";


$keys = ['foo', 5, 10, 'bar'];
$third = array_fill_keys($keys, 'banana');

var_dump($third);
/*
 *  INFO:
 *  https://www.php.net/manual/en/function.range.php
 *  https://www.php.net/manual/en/function.array-fill.php
 *  https://www.php.net/manual/en/function.array-fill-keys.php
 */
?>
</body>
</html>
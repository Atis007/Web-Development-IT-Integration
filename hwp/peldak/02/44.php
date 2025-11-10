<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>php 44</title>
</head>
<body>
<?php
/*
 * ------------------------------------------------------------
 *  PHP Sorting Examples with Associative Arrays
 * ------------------------------------------------------------
 *
 *  asort()  - Sorts an array and maintains index association.
 *  ksort()  - Sorts an array by its keys.
 *  uasort() - Sorts an array with a custom comparison function,
 *             maintaining index association.
 *
 *  Documentation:
 *  https://www.php.net/manual/en/function.asort.php
 *  https://www.php.net/manual/en/function.ksort.php
 *  https://www.php.net/manual/en/function.uasort.php
 * ------------------------------------------------------------
 */

$data_array = ["first" => "e", "second" => "s", "third" => "c", "fourth" => "b"];

echo "Original order of array:<br>";
foreach ($data_array as $key => $value)
    echo "$key = $value<br>";

/*
 * ------------------------------------------------------------
 *  asort()
 * ------------------------------------------------------------
 *  This function sorts an array while maintaining the key-value
 *  association. It is mainly used for associative arrays where
 *  the element order matters.
 */
asort($data_array, SORT_STRING);

echo "<br>Array ordered by <i>asort()</i> function:<br>";
foreach ($data_array as $key => $value)
    echo "$key = $value<br>";

/*
 * ------------------------------------------------------------
 *  ksort()
 * ------------------------------------------------------------
 *  Sorts an array by its keys, maintaining key-to-value
 *  correlation. This is useful for associative arrays.
 */
$data_array2 = ["x" => 5, "a" => 2, "f" => 1];

echo "<br>Original order of array:<br>";
foreach ($data_array2 as $key => $value)
    echo "$key = $value<br>";

ksort($data_array2);

echo "<br>Array ordered by <i>ksort()</i> function:<br>";
foreach ($data_array2 as $key => $value)
    echo "$key = $value<br>";

/*
 * ------------------------------------------------------------
 *  uasort() with a simple custom comparison function
 * ------------------------------------------------------------
 *  This example uses a user-defined comparison:
 *  - returns -1 if $a < $b
 *  - returns 1  if $a > $b
 *  - returns 0  if equal
 *
 *  uasort() keeps the key-value association.
 */
$array = [
    'a' => 'banana',
    'b' => 'apple',
    'c' => 'cherry',
    'd' => 'apricot',
];

uasort($array, function ($a, $b) {
    if ($a == $b) return 0;
    return ($a < $b) ? -1 : 1;
});

echo "<br>Array ordered by <i>uasort()</i> function (custom comparison):<br>";
foreach ($array as $key => $value)
    echo "$key = $value<br>";

?>
</body>
</html>
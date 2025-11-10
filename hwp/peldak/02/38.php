<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>php 38</title>
</head>
<body>

<?php

/*
 *  array_merge
 *  Merges the elements of one or more arrays together so that the values of one are appended to the end of the previous
 *  one. It returns the resulting array.
 *  If the input arrays have the same string keys, then the later value for that key will overwrite the previous one.
 *  If, however, the arrays contain numeric keys, the later value will not overwrite the original value, but will be
 *  appended. Values in the input arrays with numeric keys will be renumbered with incrementing keys starting from zero
 *  in the result array.
 *
 *  array_merge_recursive() merges the elements of one or more arrays together so that the values of one are appended to
 *  the end of the previous one. It returns the resulting array. If the input arrays have the same string keys, then
 *  the values for these keys are merged together into an array, and this is done recursively, so that if one of the
 *  values is an array itself, the function will merge it with a corresponding entry in another array too.
 *  If, however, the arrays have the same numeric key, the later value will not overwrite the original value,
 *  but will be appended.
 */

$first = ["a", "b", "c"];
$second = [1, 2, 3];


$third = array_merge($first, $second);

var_dump($third);

$f1 = ['a' => 23, 'b' => 45, 'd' => 12];

$s1 = ['a' => 43, 'b' => 423, 'c' => 33];

foreach ($s1 as $value) {
    echo "$value <br>";
}

//$third_two = array_merge($f1, $s1);
echo "<pre>third";
$third_two = array_merge_recursive($f1, $s1);
var_dump($third_two);
echo "</pre>";

echo "First array:<br>";

for ($i = 0; $i < count($first); $i++)
    echo "$first[$i] <br>";// 0 1 2

echo "<br>Second array:<br>";

$second = [1, 2, 3];

foreach ($second as $key => $value) // 1,2,3
    echo "$key=$value <br>";

echo "<br>Third array:<br>";

foreach ($third as $value)
    echo "$value <br>";

var_dump($third);
echo "<br>";

$numbers = [1, 5, 3, 6, 789, 34, 23, 45, 11, 89];

$odd = [];
$even = [];

foreach ($numbers as $value) {
    if ($value % 2 == 0)
        $even[] = $value;
    else
        $odd[] = $value;
}

echo "<br>Numbers in the array: ";
var_dump($numbers);

echo "<br><br>Odd numbers in the array: ";
var_dump($odd);

echo "<br><br>Even numbers in the array:";
var_dump($even);

/*
 *  INFO:
 *  https://www.php.net/manual/en/function.array-merge.php
 *  https://www.php.net/manual/en/function.array-merge-recursive.php
 */

?>
</body>
</html>
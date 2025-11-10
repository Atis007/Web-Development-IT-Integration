<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>php 35</title>
</head>
<body>
<?php

$schools[0][1] = "Yale";
$schools[0][2] = "Harvard";

$schools[1][2] = "PHP";
$schools[1][3] = "Oxford";
$schools[1][4] = "Princeton";

$schools[2][0] = "Columbia";

echo "<pre>";
var_dump($schools);
echo "</pre>";

echo "<br>";
echo count($schools); //3
echo "<br>";
echo count($schools[1]); //3
echo "<br>";
echo count($schools, COUNT_RECURSIVE);

// If the optional mode parameter is set to COUNT_RECURSIVE (or 1), count() will recursively count the array.
// This is particularly useful for counting all the elements of a multidimensional array.

/*
 *  INFO:
 *  https://www.php.net/manual/en/function.count.php
 */
?>
</body>
</html>

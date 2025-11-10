<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>php 57</title>
</head>
<body>
<?php

$str1 = "223";
$str2 = "225";

$str3 = "Hello World!";
$str4 = "hello world!";

echo "strcmp($str1, $str2) = " . strcmp($str1, $str2);
// Binary-safe string comparison (case-sensitive).
// Returns 0 if strings are equal, <0 if $str1 < $str2, >0 if $str1 > $str2.

echo "<br>strcasecmp($str3, $str4) = " . strcasecmp($str3, $str4);
// Binary-safe, case-insensitive string comparison.

echo "<br>strnatcmp($str1, $str2) = " . strnatcmp($str1, $str2);
// Natural order comparison for alphanumeric strings (case-sensitive).
// This function compares strings in the way a human would (e.g., "img2" < "img10").

echo "<br>strncmp($str1, $str2, 2) = " . strncmp($str1, $str2, 2);
// Compares up to the first N characters (case-sensitive).
// Similar to strcmp(), but only compares the specified number of characters.

echo "<br>strncasecmp(\"php\", \"PHP024\", 3) = " . strncasecmp("php", "PHP024", 3);
// Same as strncmp(), but case-insensitive.

echo "<br>strcmp(\"php\", \"PHP\") = " . strcmp("php", "PHP");
// Case-sensitive comparison; lowercase 'p' (ASCII 112) > uppercase 'P' (ASCII 80).

/*
Return values for string comparison functions:
  strcmp($a, $b) == 0   → strings are equal
  strcmp($a, $b) < 0    → $a is less than $b
  strcmp($a, $b) > 0    → $a is greater than $b

Examples:
  "ac" < "acc"
  "accc" > "acc"
  "acb" < "acc"
  "bcc" > "acc"
  "1bcc" < "acca"
  "bcc" > "_bcc"
  "bcc" < "bcc;"
  "bcc;" == "bcc;"

Example arrays:
$arr1 = $arr2 = ["img12.png", "img10.png", "img2.png", "img1.png"];

Standard string comparison (strcmp):
Array
(
    [0] => img1.png
    [1] => img10.png
    [2] => img12.png
    [3] => img2.png
)

Natural order string comparison (strnatcmp):
Array
(
    [0] => img1.png
    [1] => img2.png
    [2] => img10.png
    [3] => img12.png
)
*/

?>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>php 60</title>
</head>
<body>
<?php

$str = "webmaster:/php024/";
echo "$str<br>";

// mixed substr_replace ( mixed $string , mixed $replacement , mixed $start [, mixed $length ] )
// substr_replace() replaces a portion of a string defined by the start and optional length with another string.

$k6 = substr_replace($str, "PHP", 0); // Replace everything from index 0 to the end
echo $k6; // PHP

$k7 = substr_replace($str, "PHP", 0, strlen($str)); // Same effect, explicit length
echo "<br>$k7<br>"; // PHP

$k8 = substr_replace($str, "PHP", 0, 0); // Insert at the beginning (before index 0)
echo "$k8<br>"; // PHPwebmaster:/php024/

$k9 = substr_replace($str, "PHP", 11, -1); // Replace from position 11 up to the last character (excluding it)
echo "$k9<br>"; // webmaster:/phPHP/

$k10 = substr_replace($str, "PHP", -7, -1); // Replace starting 7 characters before the end, up to the last character
echo "$k10<br>"; // webmaster:/PHP/

$k11 = substr_replace($str, "", 11, -1); // Remove substring from position 11 up to the last character (excluding it)
echo "$k11<br>"; // webmaster://

echo "<hr>";

$word = "drop database user drop drop drop";

// mixed str_replace ( mixed $search , mixed $replace , mixed $subject [, int &$count ] )
// Replaces all occurrences of 'search' with 'replace' within the given string or array.

$filter = str_replace("drop", "", $word, $count);

echo "Filtered text: $filter<br>"; // "  database user   "
echo "Number of replacements: $count<br>"; // 4
var_dump($word);

?>
</body>
</html>
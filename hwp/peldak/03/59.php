<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>php 59</title>
</head>
<body>
<?php

$text = "webmaster";
$character = "e";

echo "original text: $text <br>";
echo "search character: $character <br><br>";

$pos1 = strpos($text, $character);
//Find the numeric position of the first occurrence of needle in the haystack string.
echo "the first position: $pos1 <br>"; // 1

$pos2 = strrpos($text, $character);
//Find the numeric position of the last occurrence of needle in the haystack string.
echo "the last position: $pos2 <br>"; // 7

echo "<hr>";

// Example of using str_contains (PHP 8.0+)
// Checks whether the haystack string contains the given substring.
// Returns true if found, false otherwise.

if (str_contains($text, $character)) {
    echo "The text '$text' contains the character '$character'.<br>";
} else {
    echo "The text '$text' does NOT contain the character '$character'.<br>";
}

$substring = "master";
if (str_contains($text, $substring)) {
    echo "The text '$text' contains the substring '$substring'.<br>";
} else {
    echo "The text '$text' does NOT contain the substring '$substring'.<br>";
}

?>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>php 62</title>
</head>
<body>
<?php

$text = "PHP (recursive acronym for \"PHP: Hypertext Preprocessor\") is a widely-used open source ";
$text .= "general-purpose scripting language that is especially suited for web development and can be embedded into HTML.";

echo $text;
echo "<hr>";

// wordwrap(string $string, int $width = 75, string $break = "\n", bool $cut = false)
// Wraps a string to a given number of characters using a string break character.

// Default behavior (width = 75, break = "\n", cut = false)
echo nl2br(wordwrap($text)); // converts \n to <br> for browser display

// Example 1: Break lines after every 6 characters (does NOT cut words)
echo "<p>" . wordwrap($text, 6, "<br>\n") . "</p>";

// Example 2: Force breaks exactly after 6 characters (even inside words)
echo "<p>" . wordwrap($text, 6, "<br>\n", true) . "</p>";

?>
</body>
</html>
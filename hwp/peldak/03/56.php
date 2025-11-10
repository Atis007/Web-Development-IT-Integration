<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>php 56</title>
</head>
<body>
<?php

$str = "Subotica";

//echo $str[0];
$px = 16;
$strArray = ["city" => "Subotica", "postalCode" => "24000"];

$l = strlen($str);
echo "The length of string $str is: $l<br><br>";
echo "The first character in string $str is: <b>" . $str[0] . "</b><br>";
echo "The fourth character in string $str is: <b>" . $str[3] . "</b><br>";
$last = $str[strlen($str) - 1];
echo "The last character in string $str is: <b> $last</b><br>";

echo "Our city is {$strArray["city"]} <br>";
// echo "Our city is $strArray["city"]";
//echo "Our city is".$strArray["city"]."<br>";


echo "Font size is {$px}px"; // 16px 16 px


echo "<hr>";

$words = ['Marko Marković', 'Petar Petrović', 'Nagy Róbert', 'Kiss Péter'];

var_dump($words);

foreach ($words as $word) {
    echo "<br>$word has " . strlen($word) . " characters";

}

echo "<hr>";

foreach ($words as $word) {
    echo "<br>$word has " . mb_strlen($word) . " characters";

}

/*


Why do strlen() and var_dump() show larger lengths?

In PHP, the strlen() function does not count characters — it counts bytes in the raw string data.

UTF-8 uses multiple bytes per character for any symbol that’s not part of the basic ASCII set.
For example:

A → 1 byte (0x41)

č → 2 bytes (0xC4 0x8D)

ő → 2 bytes

í → 2 bytes

So while mb_strlen() “understands” that each of these is a single letter, strlen() simply counts the bytes, resulting
in a higher number.

var_dump() displays the string length in bytes, just like strlen(),
but that is not its primary purpose — it is meant for debugging and inspecting variables, not for measuring text length.

 */
?>
</body>
</html>
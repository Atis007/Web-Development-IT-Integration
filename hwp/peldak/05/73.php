<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>php 73</title>
</head>
<body>
<?php

// Create custom timestamps with mktime (hour, minute, second, month, day, year)
$time = mktime(13, 30, 38, 1, 28, 2003);
$time2 = mktime(12, 5, 36, 5, 9, 1945);

echo "Timestamp 1: $time<br>";
echo "Timestamp 2: $time2<br><br>";

// Show which day of the week the given date was
echo "<b>The day was:</b> " . date("l", $time2) . "<br><br>";

// Examples of date rollover handling in PHP
echo date("M-d-Y", mktime(0, 0, 0, 12, 32, 1997)) . "<br>"; // 32nd day rolls into next month
echo date("M-d-Y", mktime(0, 0, 0, 13, 32, 1997)) . "<br>"; // Month 13 rolls into next year
echo date("M-d-Y", mktime(0, 0, 0, 1, 1, 1998))  . "<br>";
echo date("M-d-Y", mktime(0, 0, 0, 5, 9, 1902))  . "<br>";

echo date("D", mktime(0, 0, 0, 12, 26, 2003)) . "<br>";   // Short weekday format (Mon, Tue...)

echo date("M-d-Y", mktime(0, 0, 0, 3, 0, 2008)) . "<br>"; // Day 0 means previous month end

/*
Documentation:
https://www.php.net/manual/en/function.mktime.php

mktime(
    int $hour,
    ?int $minute = null,
    ?int $second = null,
    ?int $month = null,
    ?int $day = null,
    ?int $year = null
): int|false

Note:
Invalid dates automatically normalize to real calendar dates.
*/
?>
</body>
</html>
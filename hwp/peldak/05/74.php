<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>php 74</title>
</head>
<body>
<?php

// Set default timezone for all date/time functions
date_default_timezone_set('Europe/Belgrade');

/*
 strtotime() converts a human-readable date/time string
 into a Unix timestamp (seconds since Jan 1 1970).
 Documentation:
 https://www.php.net/manual/en/function.strtotime
*/

// Current timestamp
echo time() . "<br>";

// Convert a specific time to timestamp (today's date implied)
echo strtotime("21:05:40") . "<br>";

// Difference between two times (in seconds)
echo strtotime("21:05:40") - strtotime("19:00:00") . "<br>";

// Various examples of strtotime()
echo strtotime("now") . "<br>";
echo strtotime("2 days") . "<br>";

// Example using phrases — returns last day of February next year
$future = strtotime("last day of february next year");
echo "<p>" . date("d.m.Y.", $future) . "</p>";

// Demonstrating multiple strtotime formats
echo strtotime("now") . "<br>";
echo strtotime("10 September 2014") . "<br>";
echo strtotime("+1 day") . "<br>";
echo strtotime("+1 week") . "<br>";
echo strtotime("+1 week 2 days 4 hours 2 seconds") . "<br>";
echo strtotime("next Thursday") . "<br>";
echo strtotime("last Monday") . "<br>";

// Example: getting the last Monday of next month
$t = strtotime("last Monday of next month");
echo "<p>Last Monday: " . date("d.m.Y.", $t) . "</p>";

// strtotime() error handling — testing invalid input
$str = 'Not Good';
// $str = "Today";

if (($timestamp = strtotime($str)) === false) {
    echo "<p>The string ($str) is invalid.</p>";
} else {
    echo "$str = " . date('l dS \o\f F Y h:i:s A', $timestamp);
}

?>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>php 72</title>
</head>
<body>
<?php
/*
 Useful references:
 https://www.php.net/manual/en/function.date.php
 https://php.net/manual/en/timezones.php
 https://www.php.net/manual/en/datetime.format.php
*/

// Set the default timezone for all date/time functions
date_default_timezone_set('Europe/Belgrade');

// Current UNIX timestamp
echo "Current UNIX timestamp: " . time() . "<br><br>";

echo "<b>Today's date and time:</b><br>";
echo date("Y.m.d. H:i:s") . "<br>";
echo date("Y.m.d. H:i:s", time()) . "<br>";

// Same as above, just another example call
echo date("Y.m.d. H:i:s");
?>
</body>
</html>
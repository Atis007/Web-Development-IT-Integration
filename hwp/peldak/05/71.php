<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>php 71</title>
</head>
<body>
<?php

// Display current UNIX timestamp
echo "<b>Timestamp</b> = " . time() . "<br><br>";

echo "<pre>";
$datum_array = getdate();

// Display getdate() output
var_dump($datum_array);
echo "</pre>";

// Loop through the returned array elements
foreach ($datum_array as $key => $value) {
    echo "<b>$key</b> = $value<br>";
}

// Display formatted current date
echo "<br><b>Today's date:</b> ";
echo $datum_array['year'] . "." . $datum_array['mon'] . "." . $datum_array['mday'] . ".";

/*
 time()
 -------------------------------
 Returns the current UNIX timestamp.

 A UNIX timestamp is the number of seconds
 elapsed since January 1st, 1970 00:00:00 (GMT).

 This date is known as:
 Unix Epoch / Unix Time / POSIX Time
*/
?>
</body>
</html>
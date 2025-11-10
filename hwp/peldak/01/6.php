<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>php 6</title>
</head>
<body>
<?php

$a = (int)"12 vts";
var_dump($a);

if(is_int($a)) {
    $d = 20+$a;
}
else {
    echo "Value is not integer!";
    $d = 0;
}

var_dump($d);

$a = "school";

$values = ['school', 'city', 'address'];
$school = 1;
$city = 2;
$address = 3;

if(in_array($a, $values)) {
    echo $$a; // echo $school;
}
else {
    echo "unknown value";
}

?>
</body>
</html>
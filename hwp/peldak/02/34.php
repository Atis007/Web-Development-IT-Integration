<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>php 34</title>
</head>
<body>
<?php

$users["name"] = "Peter";
$users["job"] = "webmaster";
$users["age"] = 30;
$users["email"] = "webmaster@php.rs";

echo $users["email"] . "<br>";

//echo $users['school']; //try to uncomment

$users['school'] = 'php';
$users['school'] = null; // try to activate this line

if (isset($users['school'])) {
    echo "school is " . $users['school'];
}

$link = $_GET['link'] ?? "";

?>
</body>
</html>
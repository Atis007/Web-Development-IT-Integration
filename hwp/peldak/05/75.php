<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>75</title>
</head>
<body>
<?php
$times = [
    1699436610,
    1699432610,
    1694436616,
    1699436652,
    -869436610,
    -532036213
];

foreach ($times as $time) {
    $date = date("d.m.Y.", $time);
    $weekday = date("l", $time);
    echo "<p><b>Date:</b> $date — <b>Weekday:</b> $weekday</p>";
}

?>
</body>
</html>
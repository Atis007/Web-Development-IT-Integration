<?php
declare(strict_types=1); // strict requirement
/*
    Enables strict type checking in this file.
    PHP will not automatically convert types (e.g., "5" to 5).
    Function arguments and return types must exactly match their declarations.
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>php 25</title>
</head>
<body>
<?php
$v1 = 4;
$v2 = (int)"4 days"; // 4


if (is_int($v1) and is_int($v2)) {
    echo "Result is " . addNumbers($v1, $v2);
} else {
    echo "Variables are not numeric values!";
}


function addNumbers(int $a, int $b)
{
    return $a + $b;
}

/**
 * Text about function ....
 * @param int $a
 * @param int $b
 * @return int
 */
function addNumbers2(int $a, int $b):int
{
    return $a + $b;
}

echo addNumbers2(6, 6);
//echo addNumbers2(6, "6 days");

?>
</body>
</html>
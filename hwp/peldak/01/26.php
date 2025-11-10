<?php
declare(strict_types=1); // strict requirement
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>php 26</title>
</head>
<body>
<?php
const LANGUAGE = 'PHP';


function setHeight(int $b, int $minheight = 60) {
    echo "The height is : $minheight $b<br>";
    echo "Language is " . LANGUAGE . "<hr>";
}

/**
 * Calculates a custom formula based on given numeric parameters.
 *
 * @param int   $a  First integer parameter.
 * @param int   $b  Second integer parameter.
 * @param array $d  Array of integers to be summed.
 *
 * @return int  The calculated integer result.
 */
function calculateFormula(int $a, int $b, array $d): int {
    $c = 2 * $a + $b ** 3 + array_sum($d);
    return $c;
    // return "vts"; // would cause a type error in strict mode
}

setHeight(350);
//setHeight();
setHeight(135);
setHeight(80);
setHeight(10,30);

$d = [1,2,3];

echo "Result of formula is: ".calculateFormula(1,2,$d);

?>
</body>
</html>
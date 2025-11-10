<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>php 45</title>
</head>
<body>
<?php
/**
 * Increases a given salary by 10%.
 *
 * @param float $salary Current salary value.
 * @return float New salary after 10% raise.
 */
function increaseSalary(float $salary): float
{
    return $salary * 1.10; // increase by 10%
}

$salaries = [800.0, 1200.0, 950.0, 1500.0, 1000.0];

$newSalaries = array_map('increaseSalary', $salaries);

var_dump($newSalaries);

echo "Salaries before and after the raise:<br>";
for ($i = 0; $i < count($salaries); $i++) {
    echo "Developer " . ($i + 1) . ": " . $salaries[$i] . " &euro; &rarr; " . number_format($newSalaries[$i], 2) . " &euro;<br>";
}

echo "<hr>";

/**
 * Extracts all digits from a given word by checking each character.
 * Uses is_numeric() to detect numeric characters.
 *
 * @param string $word Input token (word or mixed string).
 * @return string|null Extracted digits as a string, or null if none found.
 */
function extractDigits(string $word): ?string {
    $digits = '';
    for ($i = 0; $i < strlen($word); $i++) {
        $ch = $word[$i];
        if (is_numeric($ch)) { // is_numberic-et kell hasznalni mert string katakterekbol nezzuk ki a szamokat
            $digits .= $ch;
        }
    }
    return ($digits === '') ? null : $digits;
}

$input = "abc123 test45 !noDigits! 9xyz 00mix55 word7end 4";
$tokens = explode(' ', $input);
var_dump($tokens);

// Apply array_map() to extract digits from each token
$numbers = array_map('extractDigits', $tokens);

echo "Input string: <b>$input</b><br><br>";

echo "Extracted numbers from tokens:\n";
for ($i = 0; $i < count($tokens); $i++) {
    $num = $numbers[$i];
    echo "Token: {$tokens[$i]} &rarr; " . ($num === null ? 'no digits' : $num) . "<br>";
}


/*
 *  INFO:
 *  https://www.php.net/manual/en/function.array-map.php
 *  https://www.php.net/manual/en/function.explode.php
 *  https://www.php.net/manual/en/function.number-format.php
 *  https://www.php.net/manual/en/function.is-numeric.php
 */
 ?>
</body>
</html>
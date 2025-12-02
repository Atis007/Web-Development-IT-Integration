<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>php 63</title>
</head>

<body>
<?php
// https://www.php.net/manual/en/function.var-export
/*
 * Arrow functions have the basic form:
 *
 *      fn (argument_list) => expression;
 *
 * They support (almost) the same features as anonymous functions, except that:
 *  - variables from the parent scope are always captured automatically by value
 *  - the body can contain only a single expression (which is implicitly returned)
 *
 * The following arrow function:
 *
 *      fn (arguments) => expression;
 *
 * is functionally equivalent to this anonymous function:
 *
 *      function (arguments) {
 *          return expression;
 *      }
 */

$a = [1, 2, ["a", "b", "c"]];
$configs = ['db_name' => 'nwp', 'host' => 'localhost', 'user' => 'root', 'pass' => ''];
// var_export() outputs a parsable string representation of a variable
// (unlike var_dump(), which focuses more on verbose debugging output).
var_export($a);
//$t = var_export($a, true);
//echo "<br>".$t;

$code = var_export($configs, true);
file_put_contents("config.php", "<?php  $code;");

$y = 1;

// Arrow function that uses $y from the parent scope (captured by value)
$fn1 = fn($x) => $x + $y;

// Equivalent anonymous function using "use ($y)" to capture $y by value.
$fn2 = function ($x) use ($y) {
    // Changing $y here (if uncommented) would only affect the local copy,
    // not the original $y outside.
    // $y = 12;
    return $x + $y;
};

echo "<hr>";
var_export($fn1(3)); // 3 + 1 = 4
echo "<hr>";
echo $fn2(2);        // 2 + 1 = 3
var_dump($y);        // int(1) – original $y is unchanged
echo "<hr>";

// Example: function that returns an arrow function (a closure)
function multiplier($x)
{
    // $x is captured automatically by value inside the arrow function
    return fn($y) => $x * $y;
}

$double = multiplier(2); // returns fn ($y) => 2 * $y

echo $double(10); // 20
echo "<hr>";

// Arrow function for equality comparison (loose comparison)
$eq = fn($a, $b) => $a == $b;

echo $eq(100, '100'); // 1 (true), because == performs type juggling
echo "<hr>";

// Strict comparison example with arrow function
$eqStrict = fn($a, $b) => $a === $b;

echo $eqStrict(100, '100'); // prints nothing (false) – different types (int vs string)
echo "<hr>";


// ------------------------------------------------------------
//  USE EXAMPLES (only for anonymous functions, NOT arrow)
// ------------------------------------------------------------

// 1) use ($var) → captures variable by value
$increment = 10;
$list = [1, 2, 3];

$resultUseValue = array_map(function($item) use ($increment) {
    return $item + $increment; // does NOT modify $increment
}, $list);

var_dump($resultUseValue);    // array(11, 12, 13)
var_dump($increment);         // still 10
echo "<hr>";

// 2) use (&$var) → captures by reference (allows modification)
$sum = 0;
$list2 = [2, 4, 6];

array_map(function($n) use (&$sum) {
    $sum += $n; // modifies $sum outside the function
}, $list2);

echo "Sum (by reference) = $sum"; // 12
echo "<hr>";

// 3) Closure that remembers state using use (&)
$makeCounter = function () {
    $count = 0; // closure remembers this value
    return function() use (&$count) {
        return ++$count;
    };
};

$counter = $makeCounter();
echo $counter(); // 1
echo $counter(); // 2
echo $counter(); // 3
echo "<hr>";


// 4) Same array_map with arrow (auto by value, reference impossible)
$list3 = [10, 20, 30];
$resultsArrow = array_map(fn($item) => $item * 2, $list3);

var_dump($resultsArrow);
// array(20, 40, 60)
echo "<hr>";

?>
</body>
</html>
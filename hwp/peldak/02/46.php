<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>php 46</title>
</head>
<body>
<?php

/**
 * Converts temperature from Celsius to Fahrenheit.
 *
 * @param float $tempC Temperature in Celsius.
 * @return float Temperature in Fahrenheit.
 */
function celsiusToFahrenheit(float $tempC): float
{
    return $tempC * 1.8 + 32;
}

/**
 * Returns true if the temperature is higher than 20°C.
 *
 * @param float $tempC Temperature in Celsius.
 * @return bool True if temperature > 20°C, otherwise false.
 */
function isWarmerThan20(float $tempC): bool
{
    return $tempC > 20;
}

/**
 * Displays an HTML table with city names and temperatures.
 *
 * @param array<string, float> $citiesC Array of cities and temperatures in °C.
 * @param array<string, float> $citiesF Array of cities and temperatures in °F.
 * @return void
 */
function displayTable(array $citiesC, array $citiesF): void
{
    echo "<h3>City Temperatures</h3>";
    echo "<table>";
    echo "<tr><th>City</th><th>Temperature (°C)</th><th>Temperature (°F)</th></tr>";

    foreach ($citiesC as $city => $tempC) {
        echo "<tr>";
        echo "<td>$city</td>";
        echo "<td>$tempC °C</td>";
        echo "<td>" . round($citiesF[$city], 1) . " °F</td>";
        echo "</tr>";
    }

    echo "</table>";
}

// --- Main program ---

$cities = [
    "Subotica" => 18,
    "Belgrade" => 23,
    "Novi Sad" => 21,
    "Niš" => 19,
    "Kragujevac" => 25
];

// 1. Convert all temperatures to Fahrenheit (array_map)
$citiesF = array_map('celsiusToFahrenheit', $cities);

// 2. Filter only cities with temperature above 20°C (array_filter)
$warmCities = array_filter($cities, 'isWarmerThan20');

/*
 *  Iterates over each value in the array passing them to the callback function. If the callback function returns true,
 *  the current value from array is returned into the result array.
 *  Array keys are preserved, and may result in gaps if the array was indexed. The result array can be reindexed using
 *  the array_values() function.
 */

// 3. Display results
displayTable($warmCities, $citiesF);
/*
 *  INFO:
 *  https://www.php.net/manual/en/function.array-filter.php
 *  https://www.php.net/manual/en/function.round.php
 *  https://www.php.net/manual/en/function.array-values.php
 */

var_dump(array_values($warmCities));
?>
</body>
</html>
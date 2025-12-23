<?php

class FuelEconomy
{
// Calculate the fuel efficiency
    public function calculate(int|float $distance, int|float $gas): float
    {
        return $distance / $gas;
    }
}

$dataFromCars = [
    [50, 10],
    [50, 0],
    [50, -3],
    [30, 5]
];

foreach ($dataFromCars as $data => $value) {
    $fuelEconomy = new FuelEconomy();
    echo $fuelEconomy->calculate($value[0], $value[1]) . "<br>";
}
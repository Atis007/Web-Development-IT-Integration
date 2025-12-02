<?php

/**
 * Returns the price of a product by its name.
 *
 * @param string $name Product name
 *
 * @return int|null  Price if found, otherwise null
 */
function get_price(string $name): ?int
{
    $products = [
        "book" => 20,
        "pen" => 10,
        "pencil" => 5
    ];

    return $products[$name] ?? null;
}
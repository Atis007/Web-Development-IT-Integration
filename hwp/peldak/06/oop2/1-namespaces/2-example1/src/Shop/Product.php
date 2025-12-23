<?php
namespace Shop;

/**
 * Simple product model
 */
class Product {

    public string $name;
    public float $price;

    public function __construct(string $name, float $price) {
        $this->name  = $name;
        $this->price = $price;
    }

    public function getFormattedPrice(): string {
        return "$" . number_format($this->price, 2);
    }
}

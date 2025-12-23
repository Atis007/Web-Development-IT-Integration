<?php
declare(strict_types=1);

namespace MyApp\Model;

class Product
{
    public function __construct(
        public string     $name,
        public string     $category,
        public float      $price,
        public int        $amount,
    ) {}
}
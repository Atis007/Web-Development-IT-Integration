<?php
declare(strict_types=1);

namespace MyApp\Seeder;

use Faker\Factory;
use Faker\Generator;
use MyApp\Model\Product;

class ProductSeeder
{
    const array CATEGORIES = [
        'Smartphone',
        'Laptop',
        'Tablet',
        'Smart TV',
        'Wireless Headphones',
        'Smart Watch',
        'Bluetooth Speaker',
        'Gaming Console',
    ];

    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function generate(int $count): array {
        $products = [];

        for ($i = 0; $i < $count; $i++) {
            $products[] = new Product(
                name:     ucwords($this->faker->words(2, true)),
                category: $this->faker->randomElement(self::CATEGORIES),
                price:    $this->faker->randomFloat(2, 200, 5000),
                amount:   $this->faker->numberBetween(0, 250),
            );
        }
        return $products;
    }
}
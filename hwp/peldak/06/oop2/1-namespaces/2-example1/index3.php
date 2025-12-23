<?php

require 'autoload.php';

use Shop\Product;

$product = new Product("Laptop", 999.99);

echo $product->name;                // Laptop
echo $product->getFormattedPrice(); // $999.99
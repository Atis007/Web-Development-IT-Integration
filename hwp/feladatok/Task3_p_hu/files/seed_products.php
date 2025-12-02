<?php

require_once 'includes/functions.php';

global $pdo;
[$productName, $productPrice, $randomDescription, $randomCategory, $randomDate] = generateData();

insertProducts($pdo, $productName, $productPrice, $randomDescription, $randomCategory, $randomDate);
echo "<p>One new product was created and inserted to the database.</p>";
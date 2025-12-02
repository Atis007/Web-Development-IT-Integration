<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

$categ = getCategoriesData();
$allowedIds = array_column($categ, 'id_category');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    exit('Request method must be POST');
}

$categoryId = trim($_POST["id_category"]);
$productName = trim($_POST["name_product"]);
$price = trim($_POST["price"]);

if(strlen($productName)<3){
    exit('Product name is too short');
}

if(filter_var($price, FILTER_VALIDATE_INT) === false || $price < 0){
    exit('Not a valid price');
}
$priceInt = (int)$price;

if(!in_array($categoryId, $allowedIds)){
    exit('Not a valid category');
}

insertIntoProducts($categoryId, $productName, $prisceInt);
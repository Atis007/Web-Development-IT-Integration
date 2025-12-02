<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    exit('Request method must be POST');
}

$form = $_POST['form_type'];

if($form === 'add_product'){
    $categoryId = trim($_POST["id_category"]);
    $productName = trim($_POST["name_product"]);
    $price = trim($_POST["price"]);

    if(strlen($productName)<3){
        exit('Product name is too short');
    }

    if(filter_var($price, FILTER_VALIDATE_INT) === false || $price < 0){
        exit('Not a valid price');
    }

    $categ = getCategoriesData();
    $allowedIds = array_column($categ, 'id_category');
    if(!in_array($categoryId, $allowedIds)){
        exit('Not a valid category');
    }

    insertIntoProducts($categoryId, $productName, (int)$price);

    exit('Product added');
}

if($form === 'delete_product'){
    $id_product = trim($_POST["id_product"]);

    if(filter_var($id_product, FILTER_VALIDATE_INT) === false){
        exit('Invalid id');
    }

    deleteProduct((int)$id_product);

    exit('Product deleted');
}
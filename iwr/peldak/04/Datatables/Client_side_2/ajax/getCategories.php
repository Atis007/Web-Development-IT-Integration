<?php
header('Content-Type: application/json; charset=utf-8');
require __DIR__ . '/../includes/config.php';
require __DIR__ . '/../includes/functions.php';


echo json_encode(
    ['data' => getCategories()],
    JSON_UNESCAPED_UNICODE
);

//echo json_encode(
//    ['data' => getCategories()]
//);
<?php
header("Content-type: application/json");

$response = ["message" => "Hello World!"];
echo json_encode($response);
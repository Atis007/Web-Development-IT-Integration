<?php
$url = "http://localhost/iws_2025/06/API/3_example/api/products";
$ch = curl_init($url);

$data = ['name' => 'VTS', 'email' => 'it@vts.su.ac.rs'];


curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

$headers = [];
$headers[] = 'Content-Type:application/json';
$token = "121212";
$headers[] = "Authorization: Bearer " . $token;
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);

//echo $result;
var_dump(json_decode($result, true));

curl_close($ch);


$data = [
    "message" => "mess",
    "status_code" =>   201,
    "data" => ['id_user' => 1, 'name' => 'vts']
];

echo json_encode($data);


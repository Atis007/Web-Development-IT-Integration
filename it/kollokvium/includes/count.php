<?php
switch ($treatment) {
    case "acupuncture":
        $price=1000;
        break;
    case "chinese_herbs":
        $price=1200;
        break;
    case "nutritional_counseling":
        $price=2500;
        break;
    case "fertility_counseling":
        $price=2800;
        break;
    case "massage_therapy":
        $price=3500;
        break;
    case "cupping":
        $price=4200;
        break;
    default:
        header('Location:home.php?error=Not a valid treatment.');
        exit;
}

if($pickup === 'yes'){
    $price += 1000;
}

$dateArray = explode('-', $date);
$day = (int)$dateArray[2];
if($day >= 1 && $day <= 5){
    $discount = $price * 0.05;
    $price -= $discount;
}

$finalPrice = $price + ($price * PDV);
<?php

// how to use image from example 3 with custom param

$ourParamId = 1234;
$ourParamId = mt_rand(200,4000);

echo '<img src="3.php?id='.$ourParamId.'" alt="qr code">';
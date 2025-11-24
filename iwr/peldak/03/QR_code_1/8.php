<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=10, user-scalable=no">
    <title>QR code example 8</title>
    <style>

        body {
            background-color: #000;
        }

        #box {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        img {
            margin: 10px;
        }

    </style>
</head>
<body>
<div id="box">
    <?php

    require 'phpqrcode/qrlib.php';

    require 'config.php';

    // how to configure silent zone (frame) size

    $tempDir = EXAMPLE_TMP_SERVERPATH;

    $codeContents = '123456DEMO';

    // generating

    // frame config values below 4 are not recommended !!!
    QRcode::png($codeContents, $tempDir . '8_4.png', QR_ECLEVEL_L, 8, 4);
    QRcode::png($codeContents, $tempDir . '8_6.png', QR_ECLEVEL_L, 8, 6);
    QRcode::png($codeContents, $tempDir . '8_12.png', QR_ECLEVEL_L, 8, 12);

    // displaying
    echo '<img src="' . EXAMPLE_TMP_URLRELPATH . '8_4.png" alt="qr 1">';
    echo '<img src="' . EXAMPLE_TMP_URLRELPATH . '8_6.png" alt="qr 2">';
    echo '<img src="' . EXAMPLE_TMP_URLRELPATH . '8_12.png" alt="qr 3">';

    ?>
</div>
</body>
</html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=10, user-scalable=no">
    <title>QR code example 7</title>
    <style>

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

    // how to configure pixel "zoom" factor

    $tempDir = EXAMPLE_TMP_SERVERPATH;

    $codeContents = '123456DEMO';

    // generating
    QRcode::png($codeContents, $tempDir . '7_1.png', QR_ECLEVEL_L, 1);
    QRcode::png($codeContents, $tempDir . '7_2.png', QR_ECLEVEL_L, 2);
    QRcode::png($codeContents, $tempDir . '7_3.png', QR_ECLEVEL_L, 3);
    QRcode::png($codeContents, $tempDir . '7_4.png', QR_ECLEVEL_L, 4);
    QRcode::png($codeContents, $tempDir . '7_8.png', QR_ECLEVEL_L, 8);
    QRcode::png($codeContents, $tempDir . '7_10.png', QR_ECLEVEL_L, 10);
    QRcode::png($codeContents, $tempDir . '7_16.png', QR_ECLEVEL_L, 16);

    // displaying
    echo '<img src="' . EXAMPLE_TMP_URLRELPATH . '7_1.png" alt="QR code1">';
    echo '<img src="' . EXAMPLE_TMP_URLRELPATH . '7_2.png" alt="QR code2">';
    echo '<img src="' . EXAMPLE_TMP_URLRELPATH . '7_3.png" alt="QR code3">';
    echo '<img src="' . EXAMPLE_TMP_URLRELPATH . '7_4.png" alt="QR code4">';
    echo '<img src="' . EXAMPLE_TMP_URLRELPATH . '7_8.png" alt="QR code5">';
    echo '<img src="' . EXAMPLE_TMP_URLRELPATH . '7_10.png" alt="QR code6">';
    echo '<img src="' . EXAMPLE_TMP_URLRELPATH . '7_16.png" alt="QR code7">';

    ?>
</div>
</body>
</html>
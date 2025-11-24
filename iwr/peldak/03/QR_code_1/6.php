<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=10, user-scalable=no">
    <title>QR code example 6</title>
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

    include 'phpqrcode/qrlib.php';

    include 'config.php';

    // how to save PNG codes to server

    $tempDir = EXAMPLE_TMP_SERVERPATH;

    $codeContents = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Proin nibh augue, suscipit a';

    // generating
    QRcode::png($codeContents, $tempDir . '6_L.png');
    //QRcode::png($codeContents, $tempDir . '6_L.png', QR_ECLEVEL_L);
    QRcode::png($codeContents, $tempDir . '6_M.png', QR_ECLEVEL_M);
    QRcode::png($codeContents, $tempDir . '6_Q.png', QR_ECLEVEL_Q);
    QRcode::png($codeContents, $tempDir . '6_H.png', QR_ECLEVEL_H);

    // end displaying
    echo '<img src="' . EXAMPLE_TMP_URLRELPATH . '6_L.png" alt="6_L">';
    echo '<img src="' . EXAMPLE_TMP_URLRELPATH . '6_M.png" alt="6_M">';
    echo '<img src="' . EXAMPLE_TMP_URLRELPATH . '6_Q.png" alt="6_Q">';
    echo '<img src="' . EXAMPLE_TMP_URLRELPATH . '6_H.png" alt="6_H">';

    /*

    QR Code has error correction capability to restore data if the code is dirty or damaged.
    Four error correction levels are available for users to choose according to the operating environment.
    Raising this level improves error correction capability but also increases the amount of data QR Code size.

    To select error correction level, various factors such as the operating environment and QR Code size need to be considered.

    Level Q or H may be selected for factory environment where QR Code get dirty, whereas Level L may be selected for clean
    environment with the large amount of data. Typically, Level M (15%) is most frequently selected.


     */

    ?>
</div>
</body>
</html>
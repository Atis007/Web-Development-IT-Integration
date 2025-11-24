<?php
if($_SERVER["REQUEST_METHOD"] === "POST") {

    $source = isset($_POST['source']) ?? '';

    $data = isset($_POST['data']) ? trim($_POST['data']) : '';

    if (empty($data)) {
        $errorMsg = "A(z) " . strtoupper($source) . " mező kitöltése kötelező!";
        header("Location: index.php?error=" . urlencode($errorMsg));
        exit();
    }

    switch ($source) {
        case 'phone':
            $message = "Sikeres Phone rögzítés: " . $data;
            break;

        case 'sms':
            $message = "Sikeres SMS küldés erre: " . $data;
            break;

        case 'url':
            $message = "Sikeres URL rögzítés: " . $data;
            break;

        default:
            header("Location: index.php?error=Ismeretlen űrlap típus!");
            exit();
    }

    header("Location: index.php?success=" . urlencode($message));
    exit();

} else {
    header("Location: index.php");
    exit();
}

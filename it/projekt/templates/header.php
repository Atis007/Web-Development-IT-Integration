<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$assetBase = BASE_URL . 'assets/';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="author" content="Tóth Attila">
    <meta name="description" content="<?php echo $metaDescription ?? 'Personal site - web showcase and project collection.'; ?>">
    <meta name="robots" content="<?php echo $metaRobots ?? 'index, follow'; ?>">
    <title><?php echo $title ?? "IT Project"; ?></title>
    <link rel="stylesheet" href="<?php echo $assetBase; ?>css/style.css">
</head>
<body>
<header class="site-header">
    <div class="container">
        <?php include PROJECT_ROOT . '/templates/navbar.php'; ?>
    </div>
</header>

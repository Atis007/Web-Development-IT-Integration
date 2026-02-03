<?php
$basePath = $basePath ?? '/iskola/it/feladatok/';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="author" content="Tóth Attila">
    <meta name="description" content="<?php echo isset($metaDescription) ? $metaDescription : 'Saját honlap - webes bemutató és feladatok gyűjteménye.'; ?>">
    <meta name="robots" content="<?php echo isset($metaRobots) ? $metaRobots : 'index, follow'; ?>">
    <title><?php echo isset($title) ? $title : "Exercise Page"; ?></title>
    <link rel="stylesheet" href="<?php echo $basePath; ?>includes/style.css">
</head>
<body>
<header>
    <?php include __DIR__ . '/navbar.php'; ?>
</header>

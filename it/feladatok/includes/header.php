<?php
$rootBase = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/') . '/';
$inFeladatok = strpos($_SERVER['SCRIPT_NAME'], '/feladatok/') !== false;
if ($inFeladatok) {
    $rootBase = preg_replace('#/feladatok/?$#', '/', $rootBase);
}
$feladatokBase = $rootBase . 'feladatok/';

$cssPath = $feladatokBase . 'includes/style.css';
$projektPath = $rootBase . 'projekt/public/';
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
    <link rel="stylesheet" href="<?php echo $cssPath; ?>">
</head>
<body>
<header>
    <?php include dirname(__FILE__) . '/navbar.php'; ?>
</header>

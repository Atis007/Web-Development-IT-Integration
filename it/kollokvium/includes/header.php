<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $title ?? 'Title'; ?></title>
    <link href="includes/style/styles.css" rel="stylesheet">
</head>

<body>
    <header>
        <div class="row space-between container-header">
            <div class="logo-text-container">
                <span contenteditable="true">
                    <img src="pictures/logo.png" alt="logo" width="75" height="75">
                </span>
                <div class="site-title">
                    <p><span class="greenText">Alternative</span>Medicine</p>
                    <p>Acupuncture, Traditional Chinese Medicine, Chinese Herbs.</p>
                </div>
            </div>
            <div class="header-image" contenteditable="true">
                <img src="pictures/Header.png" alt="header flowers">
            </div>
        </div>
    </header>

    <hr class="green-line">

    <main>
        <nav>
            <?php require 'navbar.php'; ?>
        </nav>
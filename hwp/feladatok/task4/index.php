<?php
declare(strict_types=1);

$lang = $_GET['lang'] ?? 'hu';

$allowed = ['hu', 'en'];

if (!in_array($lang, $allowed, true)) {
    $lang = 'hu';
}

require_once __DIR__ . "/lang/lang_$lang.php";
?>
<!doctype html>
<html lang="<?= htmlspecialchars($lang) ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= htmlspecialchars(LANG['form_title']) ?></title>
</head>
<body>
<p><?= htmlspecialchars($lang) ?></p>
<a href="?lang=hu">HU</a> | <a href="?lang=en">EN</a>;

<h1><?= htmlspecialchars(LANG['form_name']) ?></h1>

<form method="post">
    <label>
        <?= htmlspecialchars(LANG['label_name']) ?>
        <input type="text" name="name">
    </label>
    <br><br>

    <label>
        <?= htmlspecialchars(LANG['label_email']) ?>
        <input type="email" name="email">
    </label>
    <br><br>

    <label>
        <?= htmlspecialchars(LANG['label_message']) ?>
        <textarea name="message"></textarea>
    </label>
    <br><br>

    <button type="submit">
        <?= htmlspecialchars(LANG['btn_submit']) ?>
    </button>
</form>

</body>
</html>
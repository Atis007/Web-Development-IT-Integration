<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'MVC3') ?></title>
    <style>
        body { font-family: Arial, sans-serif; margin: 24px; }
        nav a { margin-right: 12px; }
        code { background: #f4f4f4; padding: 2px 6px; border-radius: 4px; }
        input { padding: 6px; width: min(420px, 100%); }
        button { padding: 8px 12px; }
    </style>
</head>
<body>
    <nav>
        <a href="<?= htmlspecialchars(url('home/index')) ?>">Home</a>
        <a href="<?= htmlspecialchars(url('book/index')) ?>">Books</a>
        <a href="<?= htmlspecialchars(url('quote/index')) ?>">Quotes</a>
    </nav>
    <hr>
    <?= $content ?>
</body>
</html>

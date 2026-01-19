<h1><?= htmlspecialchars($title ?? '') ?></h1>

<p><strong>Quote:</strong> <?= htmlspecialchars($quote['text']) ?></p>
<p><strong>Author:</strong> <?= htmlspecialchars($quote['author']) ?></p>

<p><a href="<?= htmlspecialchars(url('quote/index')) ?>">
    ← Back to list
</a></p>

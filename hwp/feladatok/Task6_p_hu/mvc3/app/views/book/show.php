<h1><?= htmlspecialchars($title ?? '') ?></h1>

<p><strong>Title:</strong> <?= htmlspecialchars($book['title']) ?></p>
<p><strong>Author:</strong> <?= htmlspecialchars($book['author']) ?></p>

<p><a href="<?= htmlspecialchars(url('book/index')) ?>">← Back to list</a></p>

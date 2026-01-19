<h1><?= htmlspecialchars($title ?? '') ?></h1>

<p><a href="<?= htmlspecialchars(url('book/create')) ?>">+ Add a new book</a></p>

<?php if (empty($books)): ?>
    <p>No books found.</p>
<?php else: ?>
    <ul>
        <?php foreach ($books as $b): ?>
            <li>
                <a href="<?= htmlspecialchars(url('book/show/' . (int)$b['id'])) ?>">
                    <?= htmlspecialchars($b['title']) ?>
                </a>
                — <?= htmlspecialchars($b['author']) ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<h1><?= htmlspecialchars($title ?? '') ?></h1>

<!--<p><a href="--><?php //= htmlspecialchars(url('book/create')) ?><!--">+ Add a new book</a></p>-->

<?php if (empty($quotes)): ?>
    <p>No quotes found.</p>
<?php else: ?>
    <ul>
        <?php foreach ($quotes as $q): ?>
            <li>
                <a href="<?= htmlspecialchars(url('quote/show/' . (int)$q['id'])) ?>">
                    <?= htmlspecialchars($q['text']) ?>
                </a>
                — <?= htmlspecialchars($q['author']) ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

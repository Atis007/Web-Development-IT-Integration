<h1><?= htmlspecialchars($title ?? '') ?></h1>

<?php if (!empty($error)): ?>
    <p style="color: red;"><strong><?= htmlspecialchars($error) ?></strong></p>
<?php endif; ?>

<form method="post" action="<?= htmlspecialchars(url('book/store')) ?>">
    <p>
        <label>
            Title<br>
            <input type="text" name="title" required>
        </label>
    </p>
    <p>
        <label>
            Author<br>
            <input type="text" name="author" required>
        </label>
    </p>
    <button type="submit">Save</button>
</form>

<p><a href="<?= htmlspecialchars(url('book/index')) ?>">← Back to list</a></p>

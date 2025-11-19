<?php
declare(strict_types=1);

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/functions.php';

$pdo = null;
$tags = [];
$dbError = null;

try {
    $pdo = connectDatabase($dsn, $pdoOptions);
    $tags = getAllTags($pdo);
} catch (RuntimeException $e) {
    $dbError = $e->getMessage();
}

$title = 'Task 10 - Tags';
include 'includes/header.php';
?>

<div class="card shadow-sm mb-4">
    <div class="card-body">

        <h3 class="card-title mb-3">Enter your labels</h3>

        <form action="process.php" method="POST">

            <div class="mb-3">
                <label for="text" class="form-label fw-semibold">Write the labels (one per line)</label>
                <textarea class="form-control" name="text" id="text" rows="6" required></textarea>
            </div>

            <div class="d-flex gap-2">
                <button type="reset" class="btn btn-outline-secondary">Reset</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>

        </form>

    </div>
</div>

<h3 class="mb-3">Saved tags</h3>

<?php if ($dbError !== null): ?>
    <div class="alert alert-danger">
        <?php echo htmlspecialchars($dbError, ENT_QUOTES, 'UTF-8'); ?>
    </div>

<?php elseif (empty($tags)): ?>
    <div class="alert alert-info">
        There are no saved tags in the database yet.
    </div>

<?php else: ?>

    <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Raw text</th>
                <th>Clean text</th>
                <th>Date</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($tags as $tag): ?>
                <tr>
                    <td><?php echo (int) $tag['id']; ?></td>
                    <td><?php echo htmlspecialchars($tag['raw_text'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($tag['clean_text'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($tag['created_at'], ENT_QUOTES, 'UTF-8'); ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

<?php endif; ?>

<?php include 'includes/footer.php'; ?>

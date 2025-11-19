<?php
declare(strict_types=1);

include 'config.php';
include 'functions.php';

$title = "Task 10 - Process";
include "includes/header.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $payload = (string) ($_POST['text'] ?? '');

    $validation = validateInput($payload);
    $rows       = $validation['rows'];
    $errors     = $validation['errors'];
    $warnings   = $validation['warnings'];

    $pdo  = null;
    $tags = [];
    $processingCounts = null;

    try {
        $pdo = connectDatabase($dsn, $pdoOptions);
    } catch (RuntimeException $e) {
        $errors[] = $e->getMessage();
    }

    if (empty($errors) && $pdo instanceof PDO) {

        $processed = processTextList($rows);
        $processingCounts = $processed['counts'];

        if ($processed['cleaned'] === []) {
            $errors[] = 'There were no tags to save (empty lines / only duplicates after processing).';
        } else {
            try {
                saveTags($pdo, $processed['original'], $processed['cleaned']);
            } catch (RuntimeException $e) {
                $errors[] = $e->getMessage();
            }
        }

        if (empty($errors)) {
            $tags = getAllTags($pdo);
        }
    }

} else {
    exit("Invalid request");
}
?>

<h1 class="mb-4">Tags Processing</h1>

<p>
    <a href="index.php" class="btn btn-secondary">← Back to form</a>
</p>

<!-- ERROR ALERTS -->
<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <h5 class="alert-heading">Errors:</h5>
        <ul class="mb-0">
            <?php foreach ($errors as $error): ?>
                <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<!-- WARNING ALERTS -->
<?php if (!empty($warnings)): ?>
    <div class="alert alert-warning">
        <h5 class="alert-heading">Warnings:</h5>
        <ul class="mb-0">
            <?php foreach ($warnings as $warning): ?>
                <li><?php echo htmlspecialchars($warning, ENT_QUOTES, 'UTF-8'); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<!-- SUMMARY -->
<?php if ($processingCounts !== null): ?>
    <div class="alert alert-info">
        <h5 class="alert-heading">Process summary</h5>
        <p class="mb-1">Number of original lines: <strong><?php echo (int)$processingCounts['input']; ?></strong></p>
        <p class="mb-0">Number of saved (clean, unique) tags: <strong><?php echo (int)$processingCounts['saved']; ?></strong></p>
    </div>
<?php endif; ?>

<!-- TAG TABLE -->
<?php if (!empty($tags)): ?>
    <h2 class="mt-4 mb-3">Current contents of the table</h2>

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

<?php elseif (empty($errors)): ?>
    <div class="alert alert-info mt-4">
        There are no tags saved in the database yet.
    </div>
<?php endif; ?>

<!-- ORIGINAL INPUT -->
<h2 class="mt-5">Original submitted content (read-only)</h2>
<pre class="border p-3 bg-light"><?php echo htmlspecialchars($payload, ENT_QUOTES, 'UTF-8'); ?></pre>

<?php include "includes/footer.php"; ?>

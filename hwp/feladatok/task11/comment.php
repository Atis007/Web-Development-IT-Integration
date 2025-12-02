<?php
declare(strict_types=1);
global $pdo;
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';

$title = 'Task11 - Comment';
include_once 'includes/header.php';

$comment = trim($_POST["comment"]) ?? "";

if(!$comment){ // same as $comment === '', just shorter
    header("Location: index.php?error=empty_comment");
    exit;
}
$badwords = getBadWords($pdo);

filterComment($pdo, $comment, $badwords);

echo"<h1>The comments inside the database:</h1><br>";

$cleanComments = getComments($pdo);

echo '
<table border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse; width: 80%; font-family: Arial; margin: 20px 0;">
    <thead style="background: #f0f0f0;">
        <tr>
            <th>#</th>
            <th>Comment</th>
            <th>Created at</th>
        </tr>
    </thead>
    <tbody>
';
foreach ($cleanComments as $index => $row) {
    echo "
        <tr>
            <td>" . ($index + 1) . "</td>
            <td>" . ($row['text']) . "</td>
            <td>" . ($row['created_at']) . "</td>
        </tr>
    ";
}
echo "
    </tbody>
</table>
";

include_once 'includes/footer.php';


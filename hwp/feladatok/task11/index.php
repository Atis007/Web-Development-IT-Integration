<?php
$title = 'Task11 - Homepage';
include_once 'includes/header.php'; ?>
<form action="comment.php" method="post">
    <label for="comment">Enter your comment:</label><br>
    <textarea name="comment" id="comment" rows="10" cols="50" required></textarea><br>
    <button type="submit">Submit Comment</button>
</form>
<?php

$error = $_GET['error'] ?? "";

if ($error == 1) {
    echo '<p class="error">Please, enter you comment!</p>';
}

?>
<?php include_once 'includes/footer.php'; ?>
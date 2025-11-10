<?php
$title = "Task 8 Homepage";
include 'includes/header.php';
?>
<form action="process.php" method="POST">
    <label for="text">Write inside the textarea</label><br>
    <textarea name="text" id="text" rows="3" cols="40" required></textarea><br>
    <button type="reset">Reset</button>
    <button type="submit">Submit</button>
</form>
<?php include 'includes/footer.php'; ?>
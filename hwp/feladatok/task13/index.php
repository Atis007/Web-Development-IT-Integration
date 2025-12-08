<?php
include_once 'includes/header.php';

if(isset($_GET['error']))
    echo "<p style='color:red; font-weight: bold'>" . htmlspecialchars($_GET['error']) . "</p>";
?>
<form method="post" name="upload" action="add.php" enctype="multipart/form-data">

    <label for="if">File:</label>
    <input type="hidden" name="MAX_FILE_SIZE" value="2097152">
    <input type="file" name="file" id="if" accept="image/jpeg" required><br><br>
    <p><b>Maximum 2MB and only accepts .jpg!</b></p>

    <input type="submit" name="sb" id="sb" value="Upload">
    <input type="reset" name="rb" id="rb" value="Cancel">

</form>
<?php include_once 'includes/footer.php'; ?>

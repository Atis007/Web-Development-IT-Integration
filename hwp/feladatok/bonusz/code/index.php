<?php
include_once 'includes/header.php';

if(isset($_GET['error']))
    echo "<p style='color:red; font-weight: bold'>" . htmlspecialchars($_GET['error']) . "</p>";
?>
<form method="post" action="check.php">
    <label for="searchedTerm">Keresett szo:</label>
    <input id="searchedTerm" type="text" name="searchedTerm" required>

    <div class="d-flex flex-row mt-3 gap-3">
        <input type="submit" value="Submit">
        <input type="reset" value="Reset">
    </div>
</form>
<?php include_once 'includes/footer.php';?>

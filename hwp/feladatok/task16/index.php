<?php
$title = "Login";
include 'includes/header.php';

if(isset($_GET['error']))
    echo "<p style='color:red; font-weight: bold'>" . htmlspecialchars($_GET['error']) . "</p>";
?>
<form method="post" action="login.php">
    <label for="username">Username:</label>
    <input type="text" name="username" id="username" required>

    <label for="password">Password:</label>
    <input type="password" name="password" id="password" required>

    <input type="submit" name="sb" id="sb" value="Submit">
    <input type="reset" name="rb" id="rb" value="Reset">

</form>
<?php include 'includes/footer.php';?>
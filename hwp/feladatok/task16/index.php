<?php
$title = "Login";
include 'includes/header.php';

if(isset($_GET['error']))
    echo "<p style='color:red; font-weight: bold'>" . htmlspecialchars($_GET['error']) . "</p>";
?>
    <form method="post" action="login.php">

        <label for="email">Email</label>
        <input type="email" name="email" id="email" required>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>

        <input type="submit" name="sb" id="sb" value="Login">
        <input type="reset" name="rb" id="rb" value="Cancel">

    </form>
<?php include 'includes/footer.php';?>
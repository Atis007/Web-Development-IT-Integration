<?php
session_start();
$name = $_SESSION["name"];
echo "<h1>You arre logged in as $name</h1>";?>
<a href="new_photo.php">Upload New Photo</a>
<a href="logout.php">Logout</a>

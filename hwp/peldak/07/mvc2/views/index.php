<!DOCTYPE html>
<html>
<head>
    <title>Hello World</title>
</head>
<body>

<h1>Check our top destinations</h1>
<?php

foreach ($data['allrecords'] as $destination) {


    echo "<h2>".$destination['name']."</h2>";
    echo "<p>";
    echo '<img src="images/'.$destination['image'].'" alt="photo" width="200"><br>';
    echo $destination['description'];
    echo "</p>";
    echo '<hr>';
}
?>

<p><a href="category.php">Categories</a></p>
</body>
</html>
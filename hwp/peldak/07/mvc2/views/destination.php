<!DOCTYPE html>
<html>
<head>
    <title>Hello World</title>
</head>
<body>


<?php
foreach ($data['allrecords'] as $destination) {
    echo '<h1>'.$destination['name'].'</h1>';
    echo '<img src="images/'.$destination['image'].'" alt="photo" width="200"><br>';
    echo $destination['description'];
}
?>
<p><a href="category.php">Categories</a></p>
</body>
</html>
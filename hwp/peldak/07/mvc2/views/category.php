<!DOCTYPE html>
<html>
<head>
    <title>Hello World</title>
</head>
<body>

<h1>Categories</h1>
<?php
foreach ($data['allrecords'] as $category) {
    echo '<a href="destination.php?id_category=' . $category['id_category'] . '">' . $category['name'] . '</a><br>';
}
?>
<p><a href="index.php">Home page</a></p>
</body>
</html>
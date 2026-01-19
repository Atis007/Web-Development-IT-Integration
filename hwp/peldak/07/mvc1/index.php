<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MVC 1</title>
    <style>
        table {
            border:1px solid #000;
            border-collapse: collapse;
        }

        td {
            border:1px solid #000;
            padding: 10px;
        }

    </style>

</head>
<body>
<?php
include_once "controller/Controller.php";

$controller = new Controller();
$controller->invoke();
?>
</body>
</html>
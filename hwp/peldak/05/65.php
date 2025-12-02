<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>php 65</title>
</head>

<body>
<?php
var_dump($_FILES);
if ($_FILES['file']["error"] > 0) {
    echo "Something went wrong during file upload!";
} else {
    if (isset($_FILES["file"]) and is_uploaded_file($_FILES['file']['tmp_name'])) {

        $fileName = $_FILES['file']["name"];
        $fileTemp = $_FILES["file"]["tmp_name"];
        $fileSize = $_FILES["file"]["size"];
        $fileType = $_FILES["file"]["type"];
        $fileError = $_FILES['file']["error"];

        echo "Ime poslate datoteke / A feltöltött fájl neve: $fileName <br />";
        echo "Privremena lokacija datoteke / Az ideiglenes fájl eljárási útja: $fileTemp <br />";
        echo "Veličina poslate datoteke u bajtovima / A feltöltött fájl mérete bájtban: $fileSize <br />";
        echo "Tip poslate datoteke / A feltöltött fájl típusa: $fileType <br />";
        echo "Kod greške / Hibakód: $fileError <br />";

        /*
                 if(exif_imagetype($fileTemp)  2  OR 3
                if size <=102400

                 if jpg and png images
                 <= 100kb -> images/small/
                 else
                 others


                 */

        $directory = "files";

        $upload = "$directory/$fileName"; // "files/ime fajla"


        if (!is_dir($directory))
            mkdir($directory);

        if (!file_exists($upload)) {
            if (move_uploaded_file($fileTemp, $upload)) {
                echo "Upload of $fileName was successful!";
            } else
                echo "<p><b>Error!</b></p>";
        } else
            echo "<p><b>File with this name already exists!</b></p>";
    }
}
?>
</body>
</html>
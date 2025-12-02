<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>php 64</title>
</head>

<body>
<?php

// Debug output of the entire $_FILES array
echo "<h2>Raw \$_FILES output</h2>";
echo "<pre>";
var_dump($_FILES);
echo "</pre>";

// Simple error check for the upload
if ($_FILES['file']["error"] > 0) {
    echo "<p><b>Something went wrong during file upload!</b></p>";
} else {
    if (is_uploaded_file($_FILES['file']['tmp_name'])) {

        $file_name = $_FILES['file']["name"];
        $file_temp = $_FILES["file"]["tmp_name"];
        $file_size = $_FILES["file"]["size"];
        $file_type = $_FILES["file"]["type"];
        $file_error = $_FILES['file']["error"];
        $full_path = $_FILES['file']["full_path"]; // Available as of PHP 8.1.0

        // --------------------------------------------
        // EXIF IMAGE TYPE DEMONSTRATION
        // exif_imagetype() returns an integer code that
        // represents the detected image format.
        // Example: 1 = GIF, 2 = JPEG, 3 = PNG, ...
        // --------------------------------------------
        $img_type = exif_imagetype($file_temp);
        echo "<h2>EXIF image type value</h2>";
        echo "exif_imagetype() returned: <b>$img_type</b><br><br>";

        // If exif_imagetype() returns false, the file is NOT a valid image
        if (!$img_type)
            exit("File is not a picture!");


        echo "<h2>Uploaded file information</h2>";
        echo "A feltöltött fájl neve: $file_name <br />";
        echo "Az ideiglenes fájl eljárási útja: $file_temp <br />";
        echo "A feltöltött fájl mérete bájtban: $file_size <br />";
        echo "A feltöltött fájl típusa: $file_type <br />";
        echo "Hibakód: $file_error <br /><br />";

        // Short legend for common EXIF image type codes
        echo "<h3>Common EXIF image type codes</h3>";
        echo "<ul>";
        echo "<li>1 – GIF</li>";
        echo "<li>2 – JPEG</li>";
        echo "<li>3 – PNG</li>";
        echo "<li>6 – BMP</li>";
        echo "<li>17 – ICO</li>";
        echo "</ul>";


        // Extract file extension
        $ext_temp = explode(".", $file_name);
        $extension = end($ext_temp);

        if (isset($_POST['alias'])) {
            $alias = $_POST['alias'];
        } else {
            $alias = "";
        }

        // New file name, including timestamp and alias
        $new_file_name = Date("YmdHis") . "-$alias.$extension";
        // Example: 20191112134305-vts.jpg
        $directory = "images";

        $upload = "$directory/$new_file_name"; // images/20191112134305-vts.jpg

        // Create directory if it does not exist
        if (!is_dir($directory))
            mkdir($directory);

        // Check if file with this name already exists
        if (!file_exists($upload)) {
            if (move_uploaded_file($file_temp, $upload)) {

                echo "<h2>Image size information</h2>";

                $size = getimagesize($upload);
                var_dump($size);
                echo "<br>";

                foreach ($size as $key => $value)
                    echo "$key = $value<br>";

                // $size[3] already contains width="..." height="..."
                echo "<h2>Preview</h2>";
                echo "<img src=\"$upload\" $size[3] alt=\"$file_name\">";

            } else {
                echo "<p><b>Error while moving uploaded file!</b></p>";
            }
        } else {
            echo "<p><b>File with this name already exists!</b></p>";
        }
    }

    /*
     ----------------------------------------------------------------------
     ADDITIONAL NOTES FOR STUDENTS
     ----------------------------------------------------------------------

     exif_imagetype() returns an integer constant, for example:

     IMAGETYPE_GIF        = 1
     IMAGETYPE_JPEG       = 2
     IMAGETYPE_PNG        = 3
     IMAGETYPE_SWF        = 4
     IMAGETYPE_PSD        = 5
     IMAGETYPE_BMP        = 6
     IMAGETYPE_TIFF_II    = 7
     IMAGETYPE_TIFF_MM    = 8
     IMAGETYPE_JPC        = 9
     IMAGETYPE_JP2        = 10
     IMAGETYPE_JPX        = 11
     IMAGETYPE_JB2        = 12
     IMAGETYPE_SWC        = 13
     IMAGETYPE_IFF        = 14
     IMAGETYPE_WBMP       = 15
     IMAGETYPE_XBM        = 16
     IMAGETYPE_ICO        = 17

0 - UPLOAD_ERR_OK
    Minden rendben

1 - UPLOAD_ERR_INI_SIZE
    A fájl mérete meghaladja a php.ini-ben beállított upload_max_filesize értéket.

2 - UPLOAD_ERR_FORM_SIZE
    A fájl mérete meghaladja a MAX_FILE_SIZE rejtett mezőben megadott értéket.

3 - UPLOAD_ERR_PARTIAL
    A fájl csak részben töltődött fel.

4 - UPLOAD_ERR_NO_FILE
    A fájl nem töltődött fel.


     upload_max_filesize = 2M (php.ini)

     ----------------------------------------------------------------------
    */
}
?>
</body>
</html>

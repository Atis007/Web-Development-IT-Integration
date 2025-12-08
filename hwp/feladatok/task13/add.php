<?php
require 'includes/functions.php';
$pdo = $GLOBALS["pdo"];
if($_SERVER["REQUEST_METHOD"] !== "POST"){
    redirectFn($pdo, [], "Only POST requests are allowed!");
}

$file = $_FILES["file"];

if(!isset($file)){
    redirectFn($pdo, [], "Upload a file!");
}

if ($file["error"] > 0) {
    redirectFn($pdo, $file, "Something went wrong during upload!");
}

$exif_data = exif_read_data($file["tmp_name"], 0, true);

if($exif_data === false){
    redirectFn($pdo, $file, "EXIF error: This is not a valid JPG image!");
}

if(!isset($exif_data["FILE"]["MimeType"]) || $exif_data["FILE"]["MimeType"] !== "image/jpeg"){
    $file_name = $file["name"];
    $ip_address = $_SERVER["REMOTE_ADDR"];
    insertIntoLog($pdo, $file_name, $ip_address);
    redirectFn($pdo, $file, "File is not a JPG image!");
}

$maxSileSize = 2 * 1024 * 1024; //2MB

if($file["size"] > $maxSileSize){
    redirectFn($pdo,  $file,"File is too big! Maximum file size is 2MB!");
}

// if we are here the checks are all passed.
$originalFileName = $file["name"];
$fileTemp = $file["tmp_name"];
$fileSize = $file["size"];
$fileType = $file["type"];
$fileError = $file["error"];

echo "A feltöltött fájl neve: $originalFileName <br />";
echo "Az ideiglenes fájl eljárási útja: $fileTemp <br />";
echo "A feltöltött fájl mérete bájtban: $fileSize <br />";
echo "A feltöltött fájl típusa: $fileType <br />";
echo "Hibakód: $fileError <br />";

$directory = "pictures";
if(!is_dir($directory)){
    mkdir($directory);
}

$helperArray = explode(".", $originalFileName);
$type = end($helperArray);

$uniqueName = uniqid('uploaded_') . "." . $type ;
$upload = "$directory/$uniqueName";

if (!file_exists($upload)) {
    if (move_uploaded_file($fileTemp, $upload)) {
        echo "Upload of $originalFileName was successful!";

        $coordinateArray = getGpsCoordinatesFromExif($exif_data);

        if($coordinateArray === null){
            $lat = null;
            $long = null;
        } else {
            $lat = $coordinateArray["latitude"];
            $long = $coordinateArray["longitude"];
        }

        insertIntoImages($pdo, $lat, $long, $uniqueName);
    } else
        echo "<p><b>Error!</b></p>";
} else
    echo "<p><b>File with this name already exists!</b></p>";

$data = getImages($pdo);
$i=1; ?>
<table >
    <thead>
        <tr>
            <th>No</th>
            <th>Image's latitude</th>
            <th>Image's longitude</th>
            <th>Image name</th>
            <th>Image</th>
            <th>Google maps</th>
            <th>Date uploaded</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($data as $d):{
        $lat = $d["latitude"] ?? 'No data';
        $long = $d["longitude"] ?? 'No data';
        $dir = "pictures/" . $d['image'];

        if($lat !== 'No data' && $long !== 'No data'){
            $maps = "<a href=\"https://www.google.com/maps?q={$d['latitude']},{$d['longitude']}\" target=\"_blank\">Open Map</a>";
        } else {
            $maps = "No GPS data";
        }

        echo "<tr>";
                echo "<td>$i</td>";
                echo "<td>".$lat."</td>";
                echo "<td>".$long."</td>";
                echo "<td>".$d['image']."</td>";
                echo "<td><img src=\"$dir\" width=\"120\" alt=\"{$d['image']}\">".$dir."</td>";
                echo "<td>".$maps."</td>";
                echo "<td>".$d['date_time']."</td>";
            }
        echo "</tr>";
        $i++;
        endforeach?>
    </tbody>
</table>

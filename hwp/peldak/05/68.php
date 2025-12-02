<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>EXIF</title>
</head>

<body>
<?php

$picture = "WP_000099.jpg";


$exif_data = exif_read_data("$picture", 0, true);

//$exif_data = exif_read_data("$picture");
// http://php.net/manual/en/function.exif-read-data.php

echo '<pre>';
print_r($exif_data);
echo '</pre>';
$lat = 0;
$long = 0;

function getGpsCoordinatesFromExif($exif_data) {
    if (isset($exif_data['GPS']) && is_array($exif_data['GPS']) && count($exif_data['GPS']) > 0) {
        // Extract latitude data
        $latRef = $exif_data['GPS']['GPSLatitudeRef'];
        $latitude = convertGpsToDecimal($exif_data['GPS']['GPSLatitude'], $latRef, 'latitude');

        // Extract longitude data
        $lonRef = $exif_data['GPS']['GPSLongitudeRef'];
        $longitude = convertGpsToDecimal($exif_data['GPS']['GPSLongitude'], $lonRef, 'longitude');

        return ['latitude' => $latitude, 'longitude' => $longitude];
    }

    return null;  // Return null if no GPS data exists
}

function convertGpsToDecimal($gpsData, $ref, $type) {
    // Convert the GPS data (degrees, minutes, seconds) to decimal format

    $degrees = $gpsData[0];
    $parts = explode('/', $degrees);
    $degrees = $parts[0] / $parts[1];

    $minutes = $gpsData[1];
    $parts = explode('/', $minutes);
    $minutes = $parts[0] / $parts[1];

    $seconds = $gpsData[2];
    $parts = explode('/', $seconds);
    $seconds = $parts[0] / $parts[1];

    // Convert to decimal format
    $min_sec = $minutes * 60;
    $seconds += $min_sec;
    $total = $seconds / 3600;
    $decimal = $total + $degrees;

    // Apply reference (N/S for latitude, E/W for longitude)
    if (($ref == "S" && $type == 'latitude') || ($ref == "W" && $type == 'longitude')) {
        $decimal *= -1;
    }

    return $decimal;
}
$coordinates = getGpsCoordinatesFromExif($exif_data);

if ($coordinates) {
    echo "Latitude: " . $coordinates['latitude'] . "<br>";
    echo "Longitude: " . $coordinates['longitude'] . "<br>";
} else {
    echo "No GPS data found.";
}

echo "<p><img src=\"$picture\" alt=\"picture\" width=\"50%\" height=\"50%\"></p>";

if ($lat != 0 and $long != 0) {
    echo "<p><b>GPS: $lat, $long</b></p>";
    echo "<a href=\"https://maps.google.com/maps?q=$lat,$long\">Show on Google Maps #1</a><br>";
    echo "<a href=\"https://maps.google.com/maps?q=$lat,$long&t=h\">Show on Google Maps #2</a>";
/*
 Map Types Available in Google Maps

    Roadmap (default)
        Parameter: t=m or leave blank
        Description: The standard Google Maps style, showing streets, city names, parks, and other geographic features.
        Use Case: General navigation, everyday use.

    Satellite
        Parameter: t=k
        Description: Aerial satellite imagery without street names.
        Use Case: Best for viewing physical terrain, landscapes, and detailed aerial views.

    Hybrid
        Parameter: t=h
        Description: Satellite imagery overlaid with road and location labels.
        Use Case: Useful for combining the street and label information of the roadmap with the terrain details of the satellite view.

    Terrain
        Parameter: t=p
        Description: Shows physical terrain information such as elevation, mountains, and vegetation.
        Use Case: Ideal for areas where the landscape or topography is essential, like hiking or environmental research.

 */
}
?>
</body>
</html>
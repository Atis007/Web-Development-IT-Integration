<?php

/*
   ---------------------------------------------
   ABOUT EXIF (Exchangeable Image File Format)
   ---------------------------------------------
   EXIF is a metadata standard used mainly in
   digital photography. It stores information
   inside image files such as:
     - camera model
     - manufacturer
     - date and time the photo was taken
     - exposure settings (ISO, shutter speed)
     - orientation (rotation)
     - GPS coordinates
     - embedded thumbnail
     - software used to edit the image

   PHP can read EXIF metadata using the exif
   extension. The most commonly used function
   is exif_read_data(), which extracts EXIF
   headers from an image file.

   IMPORTANT:
   EXIF metadata is primarily found in:
     • JPEG (JPG)
     • TIFF
   Most other formats (PNG, GIF, BMP, WEBP)
   DO NOT contain EXIF metadata.

   Smartphones and digital cameras almost always
   embed EXIF into JPEG photos.
*/

$exif_data = exif_read_data('WP_000099.jpg');

var_dump($exif_data);

//echo '<pre>';
//print_r($exif_data);
//echo '</pre>';
// exif_read_data - Reads the EXIF headers from JPEG or TIFF
// https://www.php.net/exif_read_data

echo $exif_data["Model"];
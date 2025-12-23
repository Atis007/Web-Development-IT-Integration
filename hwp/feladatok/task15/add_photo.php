<?php
declare(strict_types=1);

session_start();
require 'includes/functions.php';

$pdo = $GLOBALS['pdo'];

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirectFn('', 'Only POST requests are allowed!');
}

if (
    empty($_POST['category_id']) ||
    empty($_POST['description']) ||
    empty($_SESSION['id_user']) ||
    !isset($_FILES['photo'])
) {
    redirectFn('new_photo', 'All fields are required.');
}

/**
 * Required inputs
 */
$idUser      = (int)$_SESSION['id_user'];
$idCateg     = (int)$_POST['category_id'];
$description = trim((string)$_POST['description']);

$file = $_FILES['photo'];

/**
 * Upload-level checks
 */
if (!isset($file) || !is_array($file)) {
    redirectFn('new_photo', 'Upload a file!');
}

if ($file['error'] === UPLOAD_ERR_NO_FILE) {
    redirectFn('new_photo', 'Upload a file!');
}

if ($file['error'] !== UPLOAD_ERR_OK) {
    redirectFn('new_photo', 'Something went wrong during upload!');
}

if (!is_uploaded_file($file['tmp_name'])) {
    redirectFn('new_photo', 'Invalid upload (tmp file not recognized).');
}

/**
 * Size check
 */
$maxFileSize = 2 * 1024 * 1024; // 2MB
if ($file['size'] > $maxFileSize) {
    redirectFn('new_photo', 'File is too big! Maximum file size is 2MB!');
}

/**
 * Type checks (PNG) - do NOT use EXIF for PNG, validate via finfo + imagecreatefrompng
 */
$finfo = new finfo(FILEINFO_MIME_TYPE);
$mime  = $finfo->file($file['tmp_name']);

if ($mime !== 'image/png') {
    redirectFn('new_photo', 'File is not a PNG image!');
}

// Extra sanity check (prevents some spoofed files)
$img = @imagecreatefrompng($file['tmp_name']);
if ($img === false) {
    redirectFn('new_photo', 'Invalid PNG file.');
}
imagedestroy($img);

/**
 * Debug info (leave if you want, but ideally remove in production)
 */
$originalFileName = $file['name'];
$fileTemp         = $file['tmp_name'];
$fileSize         = $file['size'];
$fileType         = $file['type'];
$fileError        = $file['error'];

echo "A feltöltött fájl neve: $originalFileName <br />";
echo "Az ideiglenes fájl eljárási útja: $fileTemp <br />";
echo "A feltöltött fájl mérete bájtban: $fileSize <br />";
echo "A feltöltött fájl típusa: $fileType <br />";
echo "Hibakód: $fileError <br />";

/**
 * Upload directory
 */
$directory = 'photos';
if (!is_dir($directory)) {
    if (!mkdir($directory, 0755, true)) {
        redirectFn('new_photo', 'Cannot create upload directory!');
    }
}

/**
 * Safe extension
 */
$ext = strtolower(pathinfo($originalFileName, PATHINFO_EXTENSION));
if ($ext !== 'png') {
    // even if someone renames, we enforce .png for your naming
    $ext = 'png';
}

/**
 * Unique filename
 */
$uniqueName = time() . rand(100, 500) . $idUser . '.' . $ext;
$upload     = $directory . '/' . $uniqueName;

/**
 * Move + DB insert
 */
if (!file_exists($upload)) {
    if (move_uploaded_file($fileTemp, $upload)) {
        echo "Upload of $originalFileName was successful!";

        // your function signature requires description too
        addToImages($pdo, $idUser, $idCateg, $uniqueName, $description);

        // optional: redirect back with success message
        // redirectFn('new_photo', 'Upload successful!');
    } else {
        echo "<p><b>Error!</b></p>";
    }
} else {
    echo "<p><b>File with this name already exists!</b></p>";
}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>php 43</title>
</head>
<body>
<?php
/*
 * ------------------------------------------------------------
 *  PHP sort() and rsort() with various sorting flags
 * ------------------------------------------------------------
 *
 *  SORT_REGULAR       - compares items normally (no type conversion)
 *  SORT_NUMERIC       - compares items numerically
 *  SORT_STRING        - compares items as strings
 *  SORT_LOCALE_STRING - compares strings based on the current locale (if defined)
 *  SORT_NATURAL       - compares strings using "natural ordering" (like natsort)
 *  SORT_FLAG_CASE     - can be combined with SORT_STRING or SORT_NATURAL
 *                       for case-insensitive sorting
 *
 * ------------------------------------------------------------
 *  Documentation:
 *  https://www.php.net/manual/en/function.sort.php
 *  https://www.php.net/manual/en/function.rsort.php
 * ------------------------------------------------------------
 */

$data_array = [1, "a", 3, "A", "c", "Z", "z", "B"];

echo "Original order of array:<br>";
foreach ($data_array as $k) {
    echo "$k <br>";
}

echo "<br>Array ordered by the <i>sort</i> function (locale-aware flag used but no locale set)<br>";
sort($data_array, SORT_LOCALE_STRING);
foreach ($data_array as $k) {
    echo "$k <br>";
}

echo "<br>Array ordered by <i>rsort</i> function<br>";
rsort($data_array);
foreach ($data_array as $k) {
    echo "$k <br>";
}

echo "<br>Array ordered by <i>natural, case-insensitive sort</i> function<br>";
sort($data_array, SORT_NATURAL | SORT_FLAG_CASE); // equivalent to natcasesort()
var_dump($data_array);

// natcasesort() – same as SORT_NATURAL | SORT_FLAG_CASE but keeps original keys
echo "<br><br>Array ordered by <i>natcasesort()</i> function (keys preserved)<br>";
$copy = [1, "a", 3, "A", "c", "Z", "z", "B"];
natcasesort($copy);
foreach ($copy as $k) {
    echo "$k <br>";
}

echo "<hr><b>Example with file names:</b><br>";

$files = ["file2.txt", "File10.txt", "file1.txt", "File20.txt", "file11.txt", "file3.txt"];

echo "<br><b>Original order:</b><br>";
print_r($files);

// 1SORT_STRING (case-sensitive)
$copy1 = $files;
sort($copy1, SORT_STRING);
echo "<br><br><b>Sorted with SORT_STRING (case-sensitive):</b><br>";
print_r($copy1);

// SORT_NATURAL (case-sensitive)
$copy2 = $files;
sort($copy2, SORT_NATURAL);
echo "<br><br><b>Sorted with SORT_NATURAL (case-sensitive):</b><br>";
print_r($copy2);

// SORT_NATURAL | SORT_FLAG_CASE (case-insensitive)
$copy3 = $files;
sort($copy3, SORT_NATURAL | SORT_FLAG_CASE);
echo "<br><br><b>Sorted with SORT_NATURAL | SORT_FLAG_CASE (case-insensitive):</b><br>";
print_r($copy3);

// natcasesort() (same logic, but keeps original keys)
$copy4 = $files;
natcasesort($copy4);
echo "<br><br><b>Sorted with natcasesort() (keys preserved):</b><br>";
print_r($copy4);

/*
 When you sort strings in PHP using sort() (or any normal string comparison like SORT_STRING),
 PHP compares character by character based on their ASCII (Unicode) numeric values.

 Each character — like A, a, Z, z — has a numeric code behind it.

 All uppercase letters (A–Z) come before lowercase letters (a–z) because their ASCII codes are smaller.
A - 65
B- 66
a - 97
b - 98
 */


?>
</body>
</html>
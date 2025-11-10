<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>php 30</title>
</head>
<body>
<?php

/**
 * Returns a formatted string describing a student.
 *
 * @param int    $age      Student's age.
 * @param int    $mark     Student's mark (grade).
 * @param string $school   School name (default: "Subotica Tech").
 * @param string $city     City name (default: "Subotica").
 * @param string $country  Country name (default: "Serbia").
 *
 * @return string  Formatted HTML paragraph.
 */
function getString(
    int $age,
    int $mark,
    string $school = "Subotica Tech",
    string $city = "Subotica",
    string $country = "Serbia"
): string {
    return "<p>I'm $age years old, studying at $school in $city, $country. My mark is $mark.</p>";
}

// Positional arguments (in order)
echo getString(22, 5);

// Named arguments can be used in any order,
// but they must come *after* any positional arguments.
// This allows skipping optional parameters and improves readability.
echo getString(age: 21, mark: 10, school: "Óbuda University", country: "Hungary");
echo getString(22, mark: 12, school: "FTN", city: "Novi Sad");

// Error example:
// Named arguments cannot appear before positional arguments.
// echo getString(school: "VTS", 22, 5);



?>
</body>
</html>
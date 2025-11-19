<?php
// Faker resources:
// https://packagist.org/packages/fakerphp/faker
// https://github.com/FakerPHP/Faker
// https://fakerphp.org/

require_once 'vendor/autoload.php';

/*
=====================================================
IMPORTANT NOTE ABOUT TEXT/SENTENCE/PARAGRAPH LOCALIZATION
=====================================================

When using Faker with certain locales (including sr_RS, sr_Latn_RS, hu_HU),
the following text generators may NOT be fully localized:

  - $faker->text()
  - $faker->sentence()
  - $faker->paragraph()
  - $faker->realText()

If the locale does not include a native "lorem" provider,
Faker will fall back to a pseudo-Latin or English lorem generator.

Meaning:
Even if a Serbian or Hungarian locale is selected, text output may appear in
Latin-based lorem ipsum, not in Serbian/Hungarian language.

Name, Address, Person and similar providers are usually correctly localized,
but "lorem text" generation may not be.

Sources:
 - FakerPHP Providers Documentation: https://fakerphp.org/formatters/text-and-paragraphs/
 - Fallback behavior of lorem provider: https://faker.readthedocs.io/en/master/providers/faker.providers.lorem.html
 - Laravel/Faker localization issue reference: https://github.com/laravel/framework/issues/28410

=====================================================
*/

// Create default Faker (en_US)
$faker = Faker\Factory::create();

// Generate a random date between two dates
$startDate = '1976-01-01';
$endDate = '2024-01-01';

// Using dateTimeBetween() to generate a random date within a given range
$randomDate = $faker->dateTimeBetween($startDate, $endDate);

// Output generated values
echo "Random Date: " . $randomDate->format('Y-m-d') . "<br>";

echo $faker->password() . "<br>";

echo "Name: " . $faker->name() . "<br>";
echo "Email: " . $faker->email() . "<br>";
echo "Text: " . $faker->text();

// Providers list reference:
// https://github.com/FakerPHP/Faker/tree/2.0/src/Provider

echo "<hr>";

// Serbian (Latin, Serbia)
$faker = Faker\Factory::create('sr_Latn_RS');
echo "<h3>sr_Latn_RS</h3>";
echo "Name: " . $faker->name() . "<br><br>";
echo "Email: " . $faker->email() . "<br><br>";
echo "Text: " . $faker->text() . "<br><br>";
echo "Sentence: " . $faker->sentence() . "<br><br>";
echo "Paragraph: " . $faker->paragraph() . "<br><br>";
echo "Real text: " . $faker->realText(200);

echo "<hr>";

// Serbian (Cyrillic, Serbia)
$faker = Faker\Factory::create('sr_RS');
echo "<h3>sr_RS (Cyrillic)</h3>";
echo "Name: " . $faker->name() . "<br><br>";
echo "Email: " . $faker->email() . "<br><br>";
echo "Text: " . $faker->text() . "<br><br>";
echo "Sentence: " . $faker->sentence() . "<br><br>";
echo "Paragraph: " . $faker->paragraph() . "<br><br>";
echo "Real text: " . $faker->realText(200);

echo "<hr>";

// Hungarian (Hungary)
$faker = Faker\Factory::create('hu_HU');
echo "<h3>hu_HU</h3>";
echo "Name: " . $faker->name() . "<br><br>";
echo "Email: " . $faker->email() . "<br><br>";
echo "Text: " . $faker->text() . "<br><br>";
echo "Sentence: " . $faker->sentence() . "<br><br>";
echo "Paragraph: " . $faker->paragraph() . "<br><br>";
echo "Real text: " . $faker->realText(200);

echo "<hr>";

// Adding optional providers for Serbian (Latin)
$faker->addProvider(new Faker\Provider\sr_Latn_RS\Person($faker));
$faker->addProvider(new Faker\Provider\sr_Latn_RS\Address($faker));
echo "<strong>Serbian Latin provider extended:</strong><br>";
echo "Address: " . $faker->streetAddress() . ", " . $faker->city() . "<br>";
echo "Person: " . $faker->firstNameMale() . " " . $faker->lastName();

echo "<hr>";

// Adding optional providers for Hungarian
$faker->addProvider(new Faker\Provider\hu_HU\Person($faker));
$faker->addProvider(new Faker\Provider\hu_HU\Address($faker));
echo "<strong>Hungarian provider extended:</strong><br>";
echo "Address: " . $faker->streetAddress() . ", " . $faker->city() . "<br>";
echo "Person: " . $faker->firstNameMale() . " " . $faker->lastName();

echo "<hr>";
<?php
/*


const vs. define()

    const are always case-sensitive
    define() has has a case-insensitive option.

    Defining case-insensitive constants is deprecated as of PHP 7.3.0. As of PHP 8.0.0, only false is an acceptable
    value, passing true will produce a warning.

    const cannot be created inside another block scope, like inside a function or inside an if statement.
    define can be created inside another block scope.


 */


class Person
{
    public bool $isAlive = true;
    public string $firstname;
    public string $lastname;

    const strong = false;

    public function __construct(string $firstname, string $lastname)
    {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
    }
}

class Ninja extends Person
{
    const strong = true;

    public function getStrong(): bool
    {
        return $this::strong;
    }
}

$teacher = new Person("Boring", "Teacher");
$student = new Person("Clever", "Mind");
$ninja = new Ninja("Big", "Master");

if (Ninja::strong) // Ninja::strong === true
    echo "Ninja lives forever!";

echo "<p>Ninja lives in digital world: " . $ninja->getStrong() . "</p>";

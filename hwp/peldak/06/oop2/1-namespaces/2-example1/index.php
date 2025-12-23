<?php

require 'autoload.php';

$appUser   = new App\User();
$adminUser = new Admin\User();

echo $appUser->name . "<br>";   // John Doe
echo $adminUser->name;          // System Admin

/*
 A namespace is like a virtual folder for classes.
 It allows classes with the same name to exist
 without causing conflicts.

 In this example, both App\User and Admin\User
 have the same class name (User), but they belong
 to different namespaces, so PHP can distinguish
 between them.

 Namespaces help organize code into logical groups,
 such as App, Admin, Database, or Service.
 This makes large projects easier to understand
 and maintain.

 The "use" keyword (not shown here) can be used
 to import a class and avoid writing the full
 namespace path every time.

 Namespaces are a core concept in modern PHP
 development and are required when using
 Composer, PSR-4 autoloading, and frameworks.
 */
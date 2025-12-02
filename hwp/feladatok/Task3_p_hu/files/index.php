<?php
require_once 'includes/functions.php';

/*
 Using a .env file improves the security and flexibility of the application.

 Advantages of using .env:
 - Sensitive information (DB host, user, password) is not hard-coded.
 - Configuration is separated from the application logic.
 - Easy to change settings for different environments
   (development, testing, production).
 - Prevents accidental leakage of credentials when code is shared or deployed.

 Role of .gitignore:
 - The .env file should always be added to .gitignore so that it is NOT
   committed to Git repositories.
 - This protects passwords and API keys from being exposed on GitHub or
   shared with other developers.

 In short:
 .env = stores sensitive configuration
 .gitignore = ensures that .env never leaves your local machine
*/


$faker = Faker\Factory::create();

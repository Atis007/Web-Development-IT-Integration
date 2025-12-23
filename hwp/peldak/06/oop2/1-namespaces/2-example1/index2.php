<?php

require 'autoload.php';

use App\User;
use Admin\User as AdminUser;

$user = new User();
$admin = new AdminUser();

echo $user->getRole()."<br>";   // User
echo $admin->getRole(); // Administrator


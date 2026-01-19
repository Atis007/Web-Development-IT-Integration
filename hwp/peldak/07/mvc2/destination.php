<?php
require "libs/Controller.php";
require "libs/Database.php";
require "controllers/Destination.php";
require "models/Destination.php";

use Mvc\controllers;
use Mvc\models;

$index = new controllers\Destination();
$model = new models\Destination();

$index->index();

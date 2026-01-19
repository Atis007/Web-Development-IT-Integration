<?php
require "libs/Controller.php";
require "libs/Database.php";
require "controllers/Index.php";
require "models/Destination.php";

use Mvc\controllers;
use Mvc\models;

$index = new controllers\Index();
$model = new models\Destination();

$index->index();
$index->view->render('index');
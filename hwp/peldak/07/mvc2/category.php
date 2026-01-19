<?php
require "libs/Controller.php";
require "libs/Database.php";
require "controllers/Category.php";
require "models/Category.php";

use Mvc\controllers;
use Mvc\models;

$index = new controllers\Category();
$model = new models\Category();

$index->index();
$index -> view->render('category');
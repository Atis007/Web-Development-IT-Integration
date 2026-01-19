<?php
namespace Mvc\controllers;

use Mvc\libs\Controller;
use Mvc\models\Category as model;

class Category extends Controller
{
    public $categoryModel;

    function __construct() {
        parent::__construct();
        $this->categoryModel = new model();

    }

    function index() {

        $allrecords = $this->categoryModel->getAllCategory();
        $this->view->assign('data', $allrecords);
        $this->view->render('category', compact('allrecords'));
    }

}

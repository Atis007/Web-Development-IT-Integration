<?php

namespace Mvc\libs;
require_once 'libs/View.php';


class Controller
{

    public $model;
    public View $view;

    public function __construct()
    {
        $this->view = new View();
    }
}
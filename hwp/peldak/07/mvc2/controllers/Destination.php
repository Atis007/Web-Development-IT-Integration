<?php
namespace Mvc\controllers;

use Mvc\libs\Controller;
use Mvc\models\Destination as model;

class Destination extends Controller
{
    public $destinationModel;
    function __construct() {
        parent::__construct();
        $this->destinationModel = new model();

    }

    function index() {
        if(isset($_GET['id_category'])) {
            $allrecords = $this->destinationModel->getDestinationCategory($_GET['id_category']);
            $this->view->assign('data', $allrecords);
            $this->view->render('destination', compact('allrecords'));
        }
        else {
            $this->view->render('destinationIndex');
        }
    }

}

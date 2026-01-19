<?php
namespace Mvc\controllers;

use Mvc\libs\Controller;
use Mvc\models\Destination;

class Index extends Controller
{
    public $destinationModel;

    function __construct() {
        parent::__construct();
        $this->destinationModel = new Destination();
    }

    function index() {

        $allrecords = $this->destinationModel->getAllDestinations();
        $this->view->assign('data', $allrecords);
        $this->view->render('index', compact('allrecords'));
    }

}

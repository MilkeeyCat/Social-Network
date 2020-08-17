<?php

namespace app\controllers;

class MainController extends \app\core\Controller
{
    public function indexAction()
    {
        $this->view->render();
    }
}
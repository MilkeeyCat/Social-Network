<?php

namespace app\controllers;

class AuthController extends \app\core\Controller
{
    public function registerAction()
    {
        if ($this->method === 'GET') {
            $this->view->render();
        } else if ($this->method === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);

            $model = $this->loadModel('auth');

            $model->registerUser($data);
        }
    }

    public function loginAction()
    {
        $this->view->render();
    }
}
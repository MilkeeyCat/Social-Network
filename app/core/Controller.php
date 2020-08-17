<?php

namespace app\core;

use app\core\View;

abstract class Controller
{

    public $route;
    public $view;
    public $model;
    public $acl;
    public $permissionToPage;
    public $method;

    public function __construct($route)
    {
        $this->route = $route;
        $this->permissionToPage = $this->checkAcl();
        $this->view = new View($route);
        $this->model = $this->loadModel($this->route['controller']);
    }

    public function loadModel($name)
    {
        $path = 'app\models\\' . ucfirst($name);
        if(class_exists($path)) {
            return new $path;
        }
    }

    public function checkAcl()
    {
        $file = 'app\acl\\' . $this->route['controller'] . '.php';
        if(file_exists($file)) {
            $this->acl = require_once $file;
        }

        if($this->inAcl('all')) {
            return true;
        } else if (isset($_SESSION['auth']['id']) && $this->inAcl('auth')) {
            return true;
        } else if (!isset($_SESSION['auth']['id']) && $this->inAcl('guest')) {
            return true;
        } else if (isset($_SESSION['admin']) && $this->inAcl('admin')) {
            return true;
        }
        return false;
    }

    public function inAcl($key)
    {
        return @in_array($this->route['action'], $this->acl[$key]);
    }
}

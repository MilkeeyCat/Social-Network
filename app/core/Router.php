<?php

namespace app\core;

use app\core\View;

/*
* Simple Router
*/

class Router
{
    protected $routes = [];
    protected $params = [];

    public function __construct()
    {
        $routes = require_once 'app/config/routes.php';
        foreach ($routes as $route => $params) {
            $this->add($route, $params);
        }
    }

    public function add($route, $params)
    {
        $route = "#^$route$#";

        $this->routes[$route] = $params;
    }

    public function match()
    {
        $url = trim($_SERVER['REQUEST_URI'], '/');
        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $url, $matches)) {
                $this->params = $params;
                $params = array_filter($matches, "is_string", ARRAY_FILTER_USE_KEY);
                foreach ($params as $key => $val) {
                    $this->params[$key] = $val;
                }
                return true;
            }
        }
        return false;
    }

    public function run()
    {
        if ($this->match()) {
            $controller_name = ucfirst($this->params['controller']);
            $controller_path = "\app\controllers\\{$controller_name}Controller";

            if (class_exists($controller_path)) {
                $action = $this->params['action'] . 'Action';
                if (method_exists($controller_path, $action)) {
                    $controller = new $controller_path($this->params);
                    $controller->method = $_SERVER['REQUEST_METHOD'];
                    if ($controller->permissionToPage || $controller->permissionToPage == null) {
                        $controller->$action();
                    }
                    return false;
                } else {
                    echo 1;
                    View::errorCode(404);
                }
            } else {
                echo 2;
                View::errorCode(404);
            }
        } else {
            echo 3;
            View::errorCode(404);
        }
    }
}

<?php

namespace app\core;

use App\Controllers\MainController;

require_once 'app/lib/vendor/autoload.php';

class View
{

    public $path = '';
    public static $twig = null;
    public $route;

    public function __construct($route)
    {
        $this->path = @$route['controller'] . '/' . @$route['action'];
        $this->route = $route;
        $loader = new \Twig\Loader\FilesystemLoader('app/views/');
        self::$twig = new \Twig\Environment($loader);
    }

    public function render($vars = [])
    {
        if (file_exists('app/views/' . $this->path . '.html')) {
            $template = self::$twig->load($this->path . '.html');
            echo $template->render(array_merge($vars, [
                'static' => STATIC_DIR
            ]));
        } else {
            echo 'View not found';
        }
        exit;
    }

    public static function errorCode($status_code)
    {
        $view = new View([]);
        http_response_code($status_code);
        if (file_exists(BASE_DIR . "/app/views/errors/$status_code.html")) {
            $template = $view::$twig->load("errors/$status_code.html");
            echo $template->render();
            exit;
        }
    }

    public function redirect($redirect_url)
    {
        header('Location: ' . $redirect_url);
    }

    public function message($status, $message)
    {
        exit(json_encode(['status' => $status, 'message' => $message]));
    }
}

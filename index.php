<?php

header("Content-Type: text/html; charset=utf-8");

require_once 'app/lib/Dev.php';
require_once 'app/lib/functions.php';

define('STATIC_DIR', '/public');
define('BASE_DIR', $_SERVER['DOCUMENT_ROOT']);

use app\core\Router;

spl_autoload_register(function ($classname) {
    $path = str_replace('\\', '/', $classname) . '.php';
    if (file_exists(BASE_DIR . '/' . $path)) {
        require_once $path;
    }
});

$route = new Router;

$route->run();
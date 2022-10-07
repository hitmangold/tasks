<?php

class Route
{
    static function start()
    {
        $controller_name = 'Main';
        $routes = explode('/', $_SERVER['REQUEST_URI']);
        $key = array_key_last($routes);
        if (!empty($routes[$key])) {
            $controller_name = $routes[$key];
        }
        if($controller_name == 'index'){
            $controller_name = 'Main';
        }
        if ($routes[$key-1] == 'images' || $routes[$key-1] == 'css') return true;
        $model_name = 'Model_' . $controller_name;
        $controller_name = 'Controller_' . $controller_name;
        if (file_exists('models/' . $model_name . '.php')) {
            require_once("models/".$model_name . '.php');
        }
        if (file_exists('controllers/' . $controller_name . '.php')) {
            require_once('controllers/' . $controller_name . '.php');
        } else {
            Route::ErrorPage404();
        }
        $controller = new Controller_Main();
        $controller->view();
    }
    static function ErrorPage404()
    {
        $host = 'http://' . $_SERVER['HTTP_HOST'] . '/';
        header('HTTP/1.1 404 Not Found');
        header("Status: 404 Not Found");
        header('Location:' . $host . '404');
    }
}
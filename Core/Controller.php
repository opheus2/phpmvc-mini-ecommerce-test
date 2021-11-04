<?php

namespace App\core;

use App\Core\Middlewares\BaseMiddleware;

class Controller
{
    public string $layout = 'main';
    public string $action = '';

    /** 
     * @var \App\Core\Middlewares\BaseMiddleware[] 
     */
    protected array $middlewares = [];

    public function setLayout($layout)
    {
        $this->layout = $layout;
    }

    public function render($view, array $params = [], array $errors = [])
    {
        return Application::$app->view->renderView($view, $params, $errors);
    }

    public function redirect(string $url)
    {
        return Application::$app->response->redirect($url);
    }

    public function registerMiddleWare(BaseMiddleware $middleware)
    {
        $this->middlewares[] = $middleware;
    }

    /**
     * Get the value of middlewares
     *
     * @return  \App\Core\Middlewares\BaseMiddleware[]
     */ 
    public function getMiddlewares()
    {
        return $this->middlewares;
    }
}

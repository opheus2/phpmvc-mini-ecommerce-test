<?php

namespace App\core;

use App\Core\BaseMiddleware;

class Controller
{
    public string $layout = 'main';
    public string $action = '';

    /** 
     * @var \App\Core\BaseMiddleware[] 
     */
    protected array $middlewares = [];

    public function setLayout($layout)
    {
        $this->layout = $layout;
    }
    
    /**
     * Render page templating
     *
     * @param  mixed $view
     * @param  mixed $params
     * @param  mixed $errors
     */
    public function render($view, array $params = [], array $errors = [])
    {
        return app()->view->renderView($view, $params, $errors);
    }
    
    /**
     * redirect to another url/path
     *
     * @param  mixed $url
     */
    public function redirect(string $url)
    {
        return app()->response->redirect($url);
    }
    
    /**
     * add a middleware to the controller
     *
     * @param  mixed $middleware
     * @return void
     */
    public function registerMiddleWare(BaseMiddleware $middleware)
    {
        $this->middlewares[] = $middleware;
    }

    /**
     * Get the value of middlewares
     *
     * @return  \App\Core\BaseMiddleware[]
     */ 
    public function getMiddlewares()
    {
        return $this->middlewares;
    }
}

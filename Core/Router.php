<?php

namespace App\core;

use App\Core\Exceptions\NotFoundException;

class Router
{
    protected array $routes = [];
    public Response $response;
    public $request;

    /**
     * __construct
     *
     * @param  mixed $request
     * @param  mixed $response
     * @return void
     */
    public function __construct($request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function get($path, $callback)
    {
        $this->routes['GET'][$path] = $callback;
    }

    public function post($path, $callback)
    {
        $this->routes['POST'][$path] = $callback;
    }

    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->method();
        $callback = $this->routes[$method][$path] ?? false;
        if ($callback === false) 
        {
            throw new NotFoundException("Page not found");
        }

        if (is_string($callback)) 
        {
            return app()->view->renderView($callback);
        }

        if (is_array($callback)) 
        {
            /**@var \App\core\Controller $controller */
            $controller = new $callback[0]();
            app()->controller = $controller;
            $controller->action = $callback[1];

            $callback[0] = $controller;

            foreach ($controller->getMiddlewares() as $middleware) 
            {
                $middleware->execute();
            }
        }

        return call_user_func($callback, $this->request, $this->response);
    }
}

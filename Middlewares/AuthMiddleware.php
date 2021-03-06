<?php

namespace App\Middlewares;

use orpheusohms\phpmvc\Application;
use orpheusohms\phpmvc\BaseMiddleware;

class AuthMiddleware extends BaseMiddleware
{
    public array $actions = [];
    /**
     * Class constructor.
     */
    public function __construct(array $actions = [])
    {
        $this->actions = $actions;
    }

    public function execute()
    {
        if (Application::isGuest()) 
        {
            if (empty($this->actions) || in_array(app()->controller->action, $this->actions)) 
            {
                app()->response->redirect('/login');
            }
        }
    }
}

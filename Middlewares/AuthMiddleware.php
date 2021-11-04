<?php

namespace App\Middlewares;

use App\Core\Application;
use App\Core\BaseMiddleware;

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
        if (Application::isGuest()) {
            if (empty($this->actions) || in_array(Application::$app->controller->action, $this->actions)) {
                Application::$app->response->redirect('/login');
            }
        }
    }
}

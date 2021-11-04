<?php

use App\Core\Application;

if (!function_exists('app')) {
    function app()
    {
        return Application::$app;
    }
}

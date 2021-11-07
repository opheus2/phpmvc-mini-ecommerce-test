<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Currency;
use App\Models\ProductRating;
use orpheusohms\phpmvc\Request;
use orpheusohms\phpmvc\Controller;
use App\Middlewares\AuthMiddleware;

class UserController extends Controller
{
    /**
     * Class constructor.
     */
    public function __construct()
    {
        $this->registerMiddleWare(new AuthMiddleware());
    }
    
    /**
     * Return the user object
     *
     */
    public function __invoke()
    {
        //pass the user obj to model
        $user = User::findOne(['id' => app()->session->get('user')]);

        return json_encode([
            'user' => $user
        ]);
    }
}

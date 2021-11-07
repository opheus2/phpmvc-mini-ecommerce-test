<?php

namespace App\Controllers;

use App\Models\Product;
use orpheusohms\phpmvc\Controller;
use orpheusohms\phpmvc\View;
use App\Models\Currency;
use App\Middlewares\AuthMiddleware;
use App\Models\ProductRating;
use App\Models\User;

class ShopController extends Controller
{
    /**
     * Instantiate constructor with middleware
     */
    public function __construct()
    {
        $this->registerMiddleWare(new AuthMiddleware());
    }

    /**
     * __invoke show shop page
     *
     * 
     */
    public function __invoke()
    {
        //pass the user obj to model
        $user = User::findOne(['id' => app()->session->get('user')]);
        return $this->render('shop', [ 'user' => json_encode($user)]);
    }
}

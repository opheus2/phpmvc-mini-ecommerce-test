<?php

namespace App\Controllers;

use App\core\Controller;
use App\Middlewares\AuthMiddleware;
use App\Models\Product;

class ShopController extends Controller
{
    /**
     * Class constructor.
     */
    public function __construct()
    {
        $this->registerMiddleWare(new AuthMiddleware());
    }

    public function __invoke()
    {
        $products = Product::getAll();
        // echo '<pre>';
        // var_dump($products);
        // echo '</pre>';
        // exit;
        return $this->render('shop', [
            'products' => $products
        ]);
    }
}

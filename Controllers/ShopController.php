<?php

namespace App\Controllers;

use App\Models\Product;
use App\core\Controller;
use App\Models\Currency;
use App\Middlewares\AuthMiddleware;
use App\Models\User;

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
        $productsWithCurrency = [];
        $products = Product::getAll();
        foreach ($products as $product) {
            $product['currency'] = Currency::findOne(['id' => $product['currency_id']]);
            $productsWithCurrency[] = $product;
        }
        
        if (!app()->session->get('_cart')) {
            app()->session->create('_cart', []);
        }
        
        $user = User::findOne(['id' => app()->session->get('user')]);

        return $this->render('shop', [
            'products' => $productsWithCurrency,
            'user' => $user
        ]);
    }
}

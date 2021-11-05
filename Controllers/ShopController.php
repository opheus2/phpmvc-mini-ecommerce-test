<?php

namespace App\Controllers;

use App\Models\Product;
use App\core\Controller;
use App\Core\View;
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
     * __invoke view all shop products
     * list all products for php template rendering
     *
     * @return View
     */
    public function __invoke(): View
    {
        $productsWithRelations = [];
        $products = Product::getAll();
        foreach ($products as $product) {
            //add currency data to products array
            $product['currency'] = Currency::findOne(['id' => $product['currency_id']]);

            //add all product ratings relationship
            $product['ratings'] = ProductRating::findAll(['id' => $product['product_id']]);
            $productsWithRelations[] = $product;
        }
        
        //instantiate the _cart session if no session exists for cart
        if (!app()->session->get('_cart')) {
            app()->session->create('_cart', []);
        }

        //pass the user obj to model
        $user = User::findOne(['id' => app()->session->get('user')]);

        return $this->render('shop', [
            'products' => $productsWithRelations,
            'user' => $user
        ]);
    }
}

<?php

namespace App\Controllers;

use App\core\Request;
use App\Models\Product;
use App\core\Controller;
use App\Models\Currency;

class CartController extends Controller
{
    public function index()
    {
        $productsWithCurrency = [];
        $products = Product::getAll();
        foreach ($products as $product) {
            $product['currency'] = Currency::findOne(['id' => $product['currency_id']]);
            $productsWithCurrency[] = $product;
        };
    }

    public function addProductToCart(Request $request)
    {
        $id = $request->getBody()['id'];
        $carts = app()->session->get('_carts');
        if (isset($carts[$id])) {
            $carts[$id]['quantity'] += 1;
            $carts[$id]['total_price'] = floatval($carts[$id]['amount'] * $carts[$id]['quantity']);
            app()->session->create('_cart', $carts);
            return true;
        }

        $product = Product::findOne(['id' => $id]);
        if (!empty($product)) {
            $carts[$id] = $product;
            $carts[$id]['quantity'] = 1;
            $carts[$id]['total_price'] = $product['amount'];
            app()->session->create('_cart', $carts);
            return true;
        }
        
        return false;
    }

    public function removeProductFromCart(Request $request)
    {
        $id = $request->getBody()['id'];
        $carts = app()->session->get('_carts');
        unset($carts[$id]);
        app()->session->create('_cart', $carts);

        return true;
    }

    public function updateProductQuantity(Request $request)
    {
        $id = $request->getBody()['id'];
        $quantity = $request->getBody()['quantity'];
        $carts = app()->session->get('_carts');
        if (isset($carts[$id])) {
            $carts[$id]['quantity'] = $quantity;
            $carts[$id]['total_price'] = floatval($quantity * $carts[$id]['amount']);
            app()->session->create('_cart', $carts);
            return true;
        }
        return false;
    }
}

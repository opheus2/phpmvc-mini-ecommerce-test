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
        return json_encode(app()->session->get('_cart'));
    }

    public function addProductToCart(Request $request)
    {
        $id = $request->getBody()['id'];
        $carts = app()->session->get('_cart');
        if (isset($carts[$id])) {
            $carts[$id]['quantity'] += 1;
            $carts[$id]['total_price'] = floatval($carts[$id]['amount'] * $carts[$id]['quantity']);
            app()->session->create('_cart', $carts);
            return json_encode([
                'status' => true
            ]);
        }

        $product = (array) Product::findOne(['id' => $id]);
        $product['currency'] = (array) Currency::findOne(['id' => $product['currency_id']]);
        if (!empty($product)) {
            $carts[$id] = $product;
            $carts[$id]['quantity'] = 1;
            $carts[$id]['total_price'] = $product['amount'];
            app()->session->create('_cart', $carts);
            return json_encode([
                'status' => true
            ]);
        }

        return json_encode([
            'status' => false
        ]);
    }

    public function removeProductFromCart(Request $request)
    {
        $id = $request->getBody()['id'];
        $carts = app()->session->get('_cart');
        unset($carts[$id]);
        app()->session->create('_cart', $carts);
        $totalCartItems = array_reduce(
            $carts,
            function ($accumulator, $item) {
                return $accumulator + $item['quantity'];
            },
            0
        );

        return json_encode([
            'status' => true,
            'total_cart_items' => $totalCartItems
        ]);
    }

    public function updateProductQuantity(Request $request)
    {
        $id = $request->getBody()['id'];
        $quantity = $request->getBody()['quantity'];
        $carts = app()->session->get('_cart');
        if (isset($carts[$id])) {
            $carts[$id]['quantity'] = $quantity;
            $carts[$id]['total_price'] = floatval($quantity * $carts[$id]['amount']);
            app()->session->create('_cart', $carts);
            $totalCartItems = array_reduce(
                $carts,
                function ($accumulator, $item) {
                    return $accumulator + $item['quantity'];
                },
                0
            );
            return json_encode([
                'status' => true,
                'total_cart_items' => $totalCartItems
            ]);
        }

        return json_encode([
            'status' => false
        ]);
    }
}

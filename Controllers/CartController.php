<?php

namespace App\Controllers;

use App\core\Request;
use App\Models\Product;
use App\core\Controller;
use App\Models\Currency;
use App\Middlewares\AuthMiddleware;

class CartController extends Controller
{
    /**
     * Class constructor.
     */
    public function __construct()
    {
        $this->registerMiddleWare(new AuthMiddleware());
    }
    
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
                'status' => true,
                'total_cart_items' => $this->getTotalOf($carts, 'quantity'),
                'total_items_cost' => $this->getTotalOf($carts, 'total_price'),
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
                'status' => true,
                'total_cart_items' => $this->getTotalOf($carts, 'quantity'),
                'total_items_cost' => $this->getTotalOf($carts, 'total_price'),
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

        return json_encode([
            'status' => true,
            'total_cart_items' => $this->getTotalOf($carts, 'quantity'),
            'total_items_cost' => $this->getTotalOf($carts, 'total_price'),
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
            return json_encode([
                'status' => true,
                'total_cart_items' => $this->getTotalOf($carts, 'quantity'),
                'total_items_cost' => $this->getTotalOf($carts, 'total_price'),
            ]);
        }

        return json_encode([
            'status' => false
        ]);
    }

    protected function getTotalOf(array $cart, string $field)
    {
        return
            round(
                array_reduce(
                    $cart,
                    function ($accumulator, $item) use ($field) {
                        return $accumulator + $item[$field];
                    },
                    0
                ),
                2
            );
    }
}

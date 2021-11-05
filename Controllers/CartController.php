<?php

namespace App\Controllers;

use App\core\Request;
use App\Models\Product;
use App\core\Controller;
use App\Models\Currency;
use App\Models\ProductRating;
use App\Middlewares\AuthMiddleware;

class CartController extends Controller
{
    /**
     * Instantiate class and register middleware.
     */
    public function __construct()
    {
        $this->registerMiddleWare(new AuthMiddleware());
    }
        
    /**
     * Return all cart session data to cart preview
     * or popup via ajax
     *
     * @return mixed
     */
    public function index()
    {
        return json_encode(app()->session->get('_cart'));
    }
    
    /**
     * Add the product to the cart's session
     *
     * @param  Request $request
     * @return mixed
     */
    public function addProductToCart(Request $request)
    {
        $id = $request->getBody()['id'];

        //find session data of cart 
        $carts = app()->session->get('_cart');

        //check if a cart with the product id already exist
        if (isset($carts[$id])) {

            //populate only quantity and total_price if found
            $carts[$id]['quantity'] += 1;
            $carts[$id]['total_price'] = floatval($carts[$id]['amount'] * $carts[$id]['quantity']);

            //put a refreshed and updated version of cart back to _cart session
            app()->session->create('_cart', $carts);
            return json_encode([
                'status' => true,
                'total_cart_items' => $this->getTotalOf($carts, 'quantity'),
                'total_items_cost' => $this->getTotalOf($carts, 'total_price'),
            ]);
        }

        //find the product if no cart session with the product id
        $product = (array) Product::findOne(['id' => $id]);

        //add currency relationship
        $product['currency'] = (array) Currency::findOne(['id' => $product['currency_id']]); 
        
        //load all product ratings relationship if any
        $product['ratings'] = ProductRating::findAll(['id' => $product['product_id']]);

        if (!empty($product)) {
            $carts[$id] = $product;
            $carts[$id]['quantity'] = 1;
            $carts[$id]['total_price'] = $product['amount'];

            //put a refreshed and updated version of cart back to _cart session
            app()->session->create('_cart', $carts);

            //return status along side the new total for cart
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
        //find session data of cart 
        $carts = app()->session->get('_cart');

        //remove from the cart session where has the product id
        unset($carts[$id]);

        //put a refreshed and updated version of cart back to _cart session
        app()->session->create('_cart', $carts);

        return json_encode([
            'status' => true,
            'total_cart_items' => $this->getTotalOf($carts, 'quantity'),
            'total_items_cost' => $this->getTotalOf($carts, 'total_price'),
        ]);
    }
    
    /**
     * Update product quantity
     * 
     * repopulating the whole total_price data due to frontend end pattern
     * vs
     * inputting +=1 for each request.
     *
     * @param  Request $request
     * @return mixed
     */
    public function updateProductQuantity(Request $request)
    {
        $id = $request->getBody()['id'];
        $quantity = $request->getBody()['quantity'];

        //find session data of cart 
        $carts = app()->session->get('_cart');
        if (isset($carts[$id])) {
            $carts[$id]['quantity'] = $quantity;

            //get total price of items by multiplying the quantity of the product by the amount
            $carts[$id]['total_price'] = floatval($quantity * $carts[$id]['amount']);

            //put a refreshed and updated version of cart back to _cart session
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
    
    /**
     * Get the total of an integer field using php array_reduce
     *
     * @param  array $cart
     * @param  string $field
     * @return float
     */
    protected function getTotalOf(array $cart, string $field): float
    {
        //reduce and round the output to 2 decimal points
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

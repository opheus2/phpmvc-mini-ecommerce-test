<?php

namespace App\Controllers;

use App\Models\Product;
use orpheusohms\phpmvc\Controller;
use orpheusohms\phpmvc\Request;
use App\Models\Currency;
use App\Middlewares\AuthMiddleware;
use App\Models\Order;
use App\Models\ProductRating;
use App\Models\User;

class CheckoutController extends Controller
{
    /**
     * Instantiate constructor with middleware
     */
    public function __construct()
    {
        $this->registerMiddleWare(new AuthMiddleware());
    }

    /**
     * __invoke checkout with cart session
     *
     * @return mixed
     */
    public function __invoke(Request $request)
    {
        try {
            //pass the user obj to model
            $user = User::findOne(['id' => app()->session->get('user')]);

            //get the delivery method from the request
            $delivery_method = $request->getBody()['delivery_method'];
            $delivery_fee = $delivery_method === 'pickup' ? 0 : 5;

            //session cart and user cart are the same 
            //therefore use session cart for checking out
            $carts = app()->session->get('_cart');

            //get total cart items and cost
            $total_cart_items = getTotalOf($carts, 'quantity');
            $total_items_cost = getTotalOf($carts, 'total_price');

            //if balance is not enough, return errors
            if (($total_items_cost + $delivery_fee) > $user->account_balance) {
                return json_encode([
                    'status' => false,
                    'checkout_errors' => [
                        'balance' => 'You have insufficient balance!'
                    ]
                ]);
            }

            $data = [];

            //unset/remove ratings has it is not necessary
            foreach ($carts as $product) {
                unset($product['ratings']);
                $data['products'][] = $product;
            }
            //encode data because column is json
            $data['products'] = json_encode($data['products']);

            //assign other relevant fields
            $data['user_id'] = $user->id;
            $data['delivery_method'] = $delivery_method;
            $data['delivery_fee'] = $delivery_fee;
            $data['total_charge'] = $total_items_cost;
            $data['total_items'] = $total_cart_items;


            //charge the user before creating an order. 
            $new_user_balance = round(floatval($user->account_balance) - floatval($total_items_cost + $delivery_fee), 2);
            User::update(['account_balance' => $new_user_balance], ['id' => $user->id]);

            $order = (new Order)->save($data);

            if ($order) {
                //remove entirely instead of reassigning
                app()->session->remove('_cart');

                //create a new session of cart
                app()->session->create('_cart', []);
                $newCart = app()->session->get('_cart');
                $user = User::findOne(['id' => app()->session->get('user')]);

                return json_encode([
                    'status' => true,
                    'message' => 'Order was placed successfully!',
                    'user' => json_encode($user),
                    'total_cart_items' => getTotalOf($newCart, 'quantity'),
                    'total_items_cost' => getTotalOf($newCart, 'total_price')
                ]);
            }
        } catch (\Exception $e) {
            return json_encode([
                'status' => false,
                'checkout_errors' => [
                    'exception' => $e->getMessage()
                ]
            ]);
        }
    }
}

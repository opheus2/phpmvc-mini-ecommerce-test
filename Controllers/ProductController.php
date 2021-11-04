<?php

namespace App\Controllers;

use App\core\Request;
use App\Models\Product;
use App\core\Controller;
use App\Models\Currency;
use App\Models\ProductRating;
use App\Middlewares\AuthMiddleware;

class ProductController extends Controller
{
    /**
     * Class constructor.
     */
    public function __construct()
    {
        $this->registerMiddleWare(new AuthMiddleware());
    }
    
    public function show(Request $request)
    {
        $id = $request->getBody()['id'];
        $product = Product::findOne(['id' => $id]);
        $product['currency'] = Currency::findOne(['id' => $product['currency_id']]);

        return json_encode($product);
    }

    public function rateProduct(Request $request)
    {
        $id = $request->getBody()['id'];
        $rating = $request->getBody()['rating'];

        $rating = ProductRating::findOne(['user_id' => app()->session->get('user')]);
        if(!empty($rating)) {
           return [
               'status' => false,
               'message' => 'You already rated this product'
           ];
        }

        $rating = (new ProductRating)->save([
            'user_id' => app()->session->get('user'),
            'product_id' => $id,
            'rating' => $rating
        ]);


    }
}

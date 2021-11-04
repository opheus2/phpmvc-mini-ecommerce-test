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
    
    /**
     * Show single product via ajax
     *
     * @param  Request $request
     * @return string
     */
    public function show(Request $request): string
    {
        $id = $request->getBody()['id'];

        //get product by id and also the currency used
        $product = Product::findOne(['id' => $id]);
        $product['currency'] = Currency::findOne(['id' => $product['currency_id']]);

        return json_encode($product);
    }

    /**
     * add new rating to a product via ajax
     *
     * @param  Request $request
     * @return string
     */
    public function rateProduct(Request $request): string
    {
        $id = $request->getBody()['id'];
        $rating = $request->getBody()['rating'];

        try {
            //find an existing rating for the user with the product and return if found.
            $productRating = ProductRating::findOne(['product_id' => $id, 'user_id' => app()->session->get('user')]);
            if (!empty($productRating)) {
                return json_encode([
                    'status' => false,
                    'message' => 'You already rated this product'
                ]);
            }

            //save new rating if no earlier rating
            $rating = (new ProductRating)->save([
                'user_id' => app()->session->get('user'),
                'product_id' => $id,
                'rating' => $rating
            ]);

            //calculate the average rate and total rate count if the new rating was successful
            if ($rating) {
                $calculatedRatings = (new Product)->getCalculatedRatings($id);

                //update the product with the new average calculation
                $product = Product::update($calculatedRatings, ['id' => $id]);
                if (!empty($product)) {
                    return json_encode([
                        'status' => true,
                    ]);
                }
            }
        } catch (\Exception $e) {
            return json_encode([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}

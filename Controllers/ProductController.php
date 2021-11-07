<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Currency;
use App\Models\ProductRating;
use orpheusohms\phpmvc\Request;
use orpheusohms\phpmvc\Controller;
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

    public function index()
    {

        $productsWithRelations = [];
        $products = Product::getAll();
        foreach ($products as $product) {
            //add currency data to products array
            $product['currency'] = Currency::findOne(['id' => $product['currency_id']]);

            //add all product ratings relationship
            $product['ratings'] = ProductRating::findAll(['product_id' => $product['id']]);
            $productsWithRelations[] = $product;
        }

        //instantiate the _cart session if no session exists for cart
        if (!app()->session->get('_cart')) {
            app()->session->create('_cart', []);
        }

        return json_encode([
            'products' => $productsWithRelations,
        ]);
    }
    
    /**
     * Show single product via ajax
     *
     * @param  Request $request
     * @return mixed
     */
    public function show(Request $request)
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
     * @return mixed
     */
    public function rateProduct(Request $request)
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
                if ($product) {
                    $updatedProduct = (array) Product::findOne(['id' => $id]);
                    //add currency data to products array
                    $updatedProduct['currency'] = Currency::findOne(['id' => $updatedProduct['currency_id']]);

                    //add all product ratings relationship
                    $updatedProduct['ratings'] = ProductRating::findAll(['product_id' => $updatedProduct['id']]);

                    return json_encode([
                        'status' => true,
                        'product' => $updatedProduct,
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

<?php

namespace App\Controllers;

use App\core\Request;
use App\Models\Product;
use App\core\Controller;
use App\Models\Currency;

class ProductController extends Controller
{
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
        //
    }
}

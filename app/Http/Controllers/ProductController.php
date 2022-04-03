<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        /**
         * get all products records
         */
        $products = Product::all();
        return view('product.index', [ "products" => $products]);
    }
}

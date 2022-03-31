<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index() {
        $orders = DB::table('orders')->get();
        return view('order.index', [ "orders" => $orders]);
    }

    public function new() {
        $products = DB::table('products')->get();
        if (count($products) > 0) {
            $product = $products[0];
        } else {
            $product = new \App\Models\Product([
                "product_name"=>"computer",
                "price"=> 4000000
            ]);
            $product->save();
        }
        $product_to_shop = [
            "product_id" => $product->id,
            "product_name" => $product->product_name,
            "product_price"=> $product->price
        ];
        return view('order.new', $product_to_shop);
    }
    public function create(Request $request) {
        $data = $request->all();
        $order = new Order([
            "product_id" => $data['product_id'],
            "customer_name" => $data['customer_name'],
            "customer_email" => $data['email'],
            "customer_mobile" => $data['phone_number'],
            "status" => "CREATED"
            ]
        );
        $order->save();
        return view('order.detail', [
            "id" =>$order->id,
            "customer_name" => $order->customer_name,
            "customer_email" => $order->customer_email,
            "customer_mobile" => $order->customer_mobile,
            "status" => $order->status
        ]);
    }

    public function pay(Request $request) {
        return "pay";
    }


}

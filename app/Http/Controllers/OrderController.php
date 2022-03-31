<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\PlaceToPayApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            "product_id" => $order->product_id,
            "product_name" => $data["product_name"],
            "product_price"=> $data["product_price"],
            "customer_name" => $order->customer_name,
            "customer_email" => $order->customer_email,
            "customer_mobile" => $order->customer_mobile,
            "status" => $order->status
        ]);
    }

    public function detail($reference) {
        $order = DB::table('orders')->where('reference', $reference)->first();
        return $order;
    }

    public function pay(Request $request) {
        $referenceOrder  = uniqid("ref-");
        $placeToPayAPI = new PlaceToPayApi();
        $data = $request->all();
        $data['reference'] = $referenceOrder;
        $response = $placeToPayAPI->createPaymentRequest($data);
        if (isset($response['transaction_id'])) {
            $order = new Order([
                    "reference" => $referenceOrder,
                    "product_id" => $data['product_id'],
                    "customer_name" => $data['customer_name'],
                    "customer_email" => $data['customer_email'],
                    "customer_mobile" => $data['customer_mobile'],
                    "status" => "CREATED",
                    "transaction_id" => $response['transaction_id'],
                    "payment_url" =>  $response['payment_url']
                ]
            );
            $order->save();
            return redirect()->away($response['payment_url']);


        } else {
            return $response;
        }
        return $response;



        return "ok";
    }


}

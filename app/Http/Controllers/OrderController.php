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
        return view('order.new');
    }
    public function create(Request $request) {
        $data = $request->all();
        $order = new Order([
            "customer_name" => $data['customer_name'],
            "customer_email" => $data['email'],
            "customer_mobile" => $data['phone_number'],
            "status" => "CREATED"
            ]
        );
        $order->save();
        return $this->index();
    }

}

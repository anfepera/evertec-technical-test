<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function  index() {
        $orders = DB::table('orders')->get();
        return view('order.index', [ "orders" => $orders]);
    }

    public function  new() {
        return view('order.new');
    }
    public function  pay() {
        return ('pay method!');
    }

}

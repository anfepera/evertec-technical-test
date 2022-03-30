<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function  index() {
        $message = "message from order controller";
        return view('order.index', [ "message" => $message]);

    }
}

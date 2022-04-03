<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Services\PlaceToPayApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index() {
        $orders = Order::all();
        return view('order.index', [ "orders" => $orders, "filters" => "All orders"]);
    }

    public function new(Product $product) {
        return view('order.new', ["product" => $product]);
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
        return view('order.detail', ["order"=>$order]);
    }

    public function detail(String $reference)
    {
        $order = Order::query()->firstWhere('reference', $reference);
        $placeToPayAPI = new PlaceToPayApi();
        $responseStatusTransaction = $placeToPayAPI->getTransactionStatus($order->transaction_id);
        $statusTransaction = $responseStatusTransaction->status()->status();
        $newStatus = "";
        if ($statusTransaction == "APPROVED") {
            $newStatus = "PAYED";
        } elseif ($statusTransaction == "PENDING") {
            $newStatus = "PENDING";

        } elseif ($statusTransaction == "REJECTED") {
            $newStatus = "REJECTED";
        }
        $order->status = $newStatus;
        $order->save();
        return view('order.detail', [
            "order" => $order
        ]);
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

    public function retry(Order $order)
    {
        $orderUpdated = Order::find($order->id);
        $referenceOrderNew = uniqid("ref-");
        $placeToPayAPI = new PlaceToPayApi();
        $data=[
            "customer_name" => $order->customer_name,
            "customer_email" => $order->customer_email,
            "customer_mobile" => $order->customer_mobile,
            "reference" => $referenceOrderNew,
            "product_price" => $order->product->price
        ];
        $response = $placeToPayAPI->createPaymentRequest($data);
        if (isset($response['transaction_id'])) {
            $orderUpdated->reference = $referenceOrderNew;
            $orderUpdated->transaction_id = $response['transaction_id'];
            $orderUpdated->payment_url = $response['payment_url'];
            $orderUpdated->save();
            return redirect()->away($orderUpdated->payment_url);
        }

        return $order;

    }

    public function filterOrderBy(Request $request)
    {
        $data = $request->all();
        $orders = Order::where("customer_email", "LIKE", "%".$data['filter_email']."%")->orderBy('updated_at')->get();

        return view('order.index', [ "orders" => $orders, "filters" => "Customer email contains ".$data['filter_email']]);
    }

}

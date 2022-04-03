<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Services\PlaceToPayApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        /**
         * get all order
         */
        $orders = Order::all();
        return view('order.index', [ "orders" => $orders, "filters" => "All orders"]);
    }

    public function new(Product $product)
    {
        /**
         * Create order register with product data (from Pay button in Product list )
         */
        return view('order.new', ["product" => $product]);
    }

    public function detail(String $reference)
    {
        /**
         * Get order status, valid payment status in placetopay api and render order detail.
         */
        $order = Order::query()->firstWhere('reference', $reference);
        if (!$order) {
            return "Order with reference ".$reference." not found.";
        }
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

    public function pay(Request $request)
    {
        /**
         * Get data of order and try to generate url payment and transaction id, after
         * create the order register and redirect to payment request url.
         */
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
        }
        return "Error to pay order";
    }

    public function retry(Order $order)
    {
        /**
         * When order is REJECTED, create a new request to placetoplay and try pay again
         */
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
        return "Fail to retry pay order";
    }

    public function filterOrderBy(Request $request)
    {
        /**
         * get order list by customer email
         */
        $data = $request->all();
        $orders = Order::where("customer_email", "LIKE", "%".$data['filter_email']."%")->orderBy('updated_at')->get();
        return view('order.index', [ "orders" => $orders, "filters" => "Customer email contains ".$data['filter_email']]);
    }
}

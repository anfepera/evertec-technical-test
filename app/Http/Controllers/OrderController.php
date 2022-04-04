<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Repositories\PaymentRepository;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::all();
        return view('order.index', [ "orders" => $orders, "filters" => "All orders"]);
    }

    public function new(Product $product)
    {
        return view('order.new', ["product" => $product]);
    }

    public function detail(PaymentRepository $repository, String $reference)
    {
        /** @var Order $order */
        $order = Order::query()->firstWhere('reference', $reference);
        if (!$order) {
            return abort(404);
        }
        $repository->resolve($order);
        return view('order.detail', [
            "order" => $order
        ]);
    }

    public function pay(PaymentRepository $repository, Request $request)
    {
        $paymentUrl = $repository->create($request->all());
        return redirect($paymentUrl);
    }

    public function retry(PaymentRepository $repository, Order $order)
    {
        $paymentUrl = $repository->retry($order);
        return redirect($paymentUrl);
    }

    public function filterOrderBy(Request $request)
    {
        $customerEmail = $request->input('filter_email', '');

        $orders = Order::filterByCustomerEmail($customerEmail)->get();

        return view('order.index', [
            "orders" => $orders,
            "filters" => "Customer email contains ".$customerEmail
        ]);
    }
}

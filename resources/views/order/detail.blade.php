@extends('layout.layout')
@section('content')
    <form method="POST" action="{{ route('order.pay') }}">
        @csrf
        <div class="container">
            <h1> Resume Order</h1>
            <input type="hidden" id="order_id" name="order_id" value="{{ $order->id }}">
            <input type="hidden" id="product_price" name="product_price" value="{{ $order->product->price }}">
            <div class="row">
                <div class="col">
                    <label class="label-form">Id:</label>
                    <span >{{ $order->id }}</span>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label class="label-form">Product name:</label>
                    <span >{{ $order->product->product_name }}</span>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label class="label-form">Product price:</label>
                    <span >{{"$ " . number_format($order->product->price, 0, ",", ".")  }}</span>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label class="label-form">Customer name:</label>
                    <span>{{ $order->customer_name }}</span>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label class="label-form">Email:</label>
                    <span >{{ $order->customer_email }}</span>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label class="label-form">Phone number:</label>
                    <span >{{ $order->customer_mobile }}</span>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label class="label-form">Status:</label>
                    <span >{{ $order->status }}</span>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    @if ($order->status == "CREATED")
                            <button type="submit" class="btn btn-success"  value="Submit">Pay</button>
                    @elseif ($order->status == "REJECTED")
                            <a href="{{ route('order.retry',$order->id)}}" class="btn btn-warning">Try again</a>
                    @elseif ($order->status == "PENDING")
                        <a href="{{ $order->payment_url }}" class="btn btn-warning">Valid Status Pay</a>
                    @endif
                    <a href="{{ route('products.index')}}" class="btn btn-info">View products list</a>
                    <a href="{{ route('orders.index')}}" class="btn btn-info">View orders list</a>
                </div>
            </div>

        </div>
    </form>
@endsection

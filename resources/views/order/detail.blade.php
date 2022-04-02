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
                    <label style="font-weight: bold">Id:</label>
                    <spam >{{ $order->id }}</spam>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label style="font-weight: bold">Product name:</label>
                    <spam >{{ $order->product->product_name }}</spam>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label style="font-weight: bold">Product price:</label>
                    <spam >{{ $order->product->price }}</spam>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label style="font-weight: bold">Customer name:</label>
                    <spam >{{ $order->customer_name }}</spam>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label style="font-weight: bold">Email:</label>
                    <spam >{{ $order->customer_email }}</spam>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label style="font-weight: bold">Phone number:</label>
                    <spam >{{ $order->customer_mobile }}</spam>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label style="font-weight: bold">Status:</label>
                    <spam >{{ $order->status }}</spam>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    @if ($order->status == "CREATED")
                            <button type="submit" class="btn btn-success"  value="Submit">Pay</button>
                    @elseif ($order->status == "REJECTED")
                            <a href="{{ route('order.retry',$order->id)}}" class="btn btn-warning">Try again</a>
                    @endif
                    <a href="{{ route('products.index')}}" class="btn btn-info">View products list</a>
                    <a href="{{ route('orders.index')}}" class="btn btn-info">View orders list</a>
                </div>
            </div>

        </div>
    </form>

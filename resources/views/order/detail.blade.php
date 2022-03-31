@extends('layout.layout')
@section('content')
    <form method="POST" action="{{ route('order.pay') }}">
        @csrf
        <div class="container">
            <h1> Resume Order</h1>
            <div class="row">
                <div class="col">
                    <label>Id:</label>
                    <spam >{{ $id }}</spam>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label>Product name:</label>
                    <spam >{{ $product_name }}</spam>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label>Product price:</label>
                    <spam >{{ $product_price }}</spam>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label>Customer name:</label>
                    <spam >{{ $customer_name }}</spam>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label>Email:</label>
                    <spam >{{ $customer_email }}</spam>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label>Phone number:</label>
                    <spam >{{ $customer_mobile }}</spam>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label>Status:</label>
                    <spam >{{ $status }}</spam>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <button type="submit" class="btn btn-success"  value="Submit">Pay</button>
                </div>
            </div>
        </div>
    </form>

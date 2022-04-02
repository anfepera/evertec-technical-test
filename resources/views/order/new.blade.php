@extends('layout.layout')
@section('content')
    <h1> Create Order</h1>
    <form method="POST" action="{{ route('order.pay') }}">
        @csrf
        <div class="container-fluid">
            <input type="hidden" id="product_id" name="product_id" value="{{ $product->id }}">
            <input type="hidden" id="product_name" name="product_name" value="{{ $product->product_name }}">
            <input type="hidden" id="product_price" name="product_price" value="{{ $product->price }}">
            <div class="row">
                <div class="col">
                    <label for="product_name">Product Name:</label>
                </div>
                <div class="col">
                    <input id="product_name"
                           name="product_name"
                           type="text"
                           disabled
                           value="{{ $product->product_name }}">
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label for="product_price">Product price:</label>
                </div>
                <div class="col">
                    <input id="product_price"
                           name="product_price"
                           type="text"
                           disabled
                           value="{{ $product->price }}">
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label for="customer_name">Customer name:</label>

                </div>
                <div class="col">
                    <input id="customer_name"
                           name="customer_name"
                           type="text"
                           required
                           class="@error('customer_name') is-invalid @enderror">
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label for="customer_email">Email:</label>

                </div>
                <div class="col">
                    <input id="customer_email"
                           name="customer_email"
                           type="email"
                           required
                           class="@error('customer_email') is-invalid @else is-valid @enderror">
                </div>
            </div>
            <div class="row justify-content-md-center">
                <div class="col">
                    <label for="customer_mobile">Mobile:</label>

                </div>
                <div class="col">
                    <input id="customer_mobile"
                           name="customer_mobile"
                           type="number"
                           required
                           class="@error('customer_mobile') is-invalid @enderror">
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <button type="submit" class="btn btn-success"  value="Submit">Pay</button>
                    <a href="{{ route('products.index')}}" class="btn btn-info">View products list</a>
                    <a href="{{ route('orders.index')}}" class="btn btn-info">View orders list</a>
                </div>
            </div>
        </div>
    </form>


    @error('customer_name')
    <div class="alert alert-danger"> Customer name is required</div>
    @enderror
    @error('customer_email')
    <div class="alert alert-danger"> Email is required</div>
    @enderror
    @error('customer_mobile')
    <div class="alert alert-danger"> Mobile is required</div>
    @enderror
@endsection

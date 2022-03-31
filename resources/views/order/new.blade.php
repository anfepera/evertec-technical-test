@extends('layout.layout')
@section('content')
    <h1> Create Order</h1>
    <form method="POST" action="{{ route('order.pay') }}">
        @csrf
        <div class="container">
            <input type="hidden" id="product_id" name="product_id" value="{{ $product_id }}">
            <input type="hidden" id="product_name" name="product_name" value="{{ $product_name }}">
            <input type="hidden" id="product_price" name="product_price" value="{{ $product_price }}">
            <div class="row">
                <div class="col">
                    <label>Product Name:</label>
                    <spam >{{ $product_name }}</spam>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label>Price:</label>
                    <spam >{{ $product_price }}</spam>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label for="customer_name">Customer name:</label>
                    <input id="customer_name"
                           name="customer_name"
                           type="text"
                           class="@error('customer_name') is-invalid @enderror">
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label for="customer_email">Email:</label>
                    <input id="customer_email"
                           name="customer_email"
                           type="email"
                           class="@error('customer_email') is-invalid @else is-valid @enderror">
                </div>
            </div>
            <div class="row justify-content-md-center">
                <div class="col">
                    <label for="customer_mobile">Mobile:</label>
                    <input id="customer_mobile"
                           name="customer_mobile"
                           type="number"
                           class="@error('customer_mobile') is-invalid @enderror">
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <button type="submit" class="btn btn-success"  value="Submit">Pay</button>
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

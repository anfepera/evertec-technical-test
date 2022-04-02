@extends('layout.layout')
@section('content')
    <div class="card" >
        <div class="card-body">
            <h5 class="card-title">Orders Filters</h5>
            <p class="card-text">Get order list by customer email or product.</p>

                <form method="POST" action="{{ route('order.pay') }}">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <label for="type_filter">Filter By:</label>
                            </div>
                            <div class="col">
                                <select name="type_filter" id="type_filter">
                                    <option value="id_product">Product</option>
                                    <option value="customer_email">Customer Email</option>
                                </select>
                            </div>
                        </div>
                        <div class="row" id="product_row">
                            <div class="col">
                                <label for="list_products">Products:</label>
                            </div>
                            <div class="col">
                                <select name="list_products" id="list_products">
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}">{{  $product->product_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div id="email_row" class="row">
                            <div class="col">
                                <label for="filter_email">Customer Email:</label>
                            </div>
                            <div class="col">
                                <input id="filter_email"
                                       name="filter_email"
                                       type="email"
                                       placeholder="Please, input the email">

                            </div>
                        </div>
                    </div>
                </form>


            <a href="#" class="btn btn-primary">Get orders</a>
        </div>
    </div>
    <h1> Product List</h1>
    <table class="table">
        <thead class="table-dark">
            <tr>
                <th>Product name</th>
                <th>Price</th>
                <th>Action</th>

            </tr>
        </thead>
        <tbody>
        @foreach ($products as $product)
        <tr>
            <td> {{  $product->product_name }}</td>
            <td> {{  $product->price }}</td>
            <td>
                <a href="{{ route('order.new', [ $product->id ])}}" class="btn btn-success">Buy</a>
                <a href="{{ route('order.filter', [ "field"=> "product_id", "filter" => $product->id])}}" class="btn btn-outline-primary">View Product Orders</a>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
@endsection

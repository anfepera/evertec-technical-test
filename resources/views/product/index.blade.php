@extends('layout.layout')
@section('content')
    <div class="card" >
        <div class="card-body">
            <h5 class="card-title">Orders Filters</h5>
            <p class="card-text">Get order list by customer email or product.</p>
                <form method="POST" action="{{ route('order.filter') }}">
                    @csrf
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <label for="type_filter">Email:</label>
                            </div>
                            <div class="col">
                                <input id="filter_email"
                                       name="filter_email"
                                       type="text"
                                       required
                                       placeholder="Please, input the email">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <button type="submit"  class="btn btn-success filter-button"  value="Submit">Get orders</button>
                            </div>
                        </div>

                    </div>
                </form>
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
            <td>{{"$ " . number_format($product->price, 0, ",", ".")  }}</td>
            <td>
                <a href="{{ route('order.new', [ $product->id ])}}" class="btn btn-success">Buy</a>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
    <div class="row">
        <div class="col">
            <a href="{{ route('orders.index')}}" class="btn btn-info">View orders list</a>
        </div>
    </div>
@endsection

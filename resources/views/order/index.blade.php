@extends('layout.layout')
@section('content')

    <div class="container container-description-filter">
        <div class="row">
            <div class="col">
                <div class="card bg-light mb-3" style="max-width: 18rem;">
                    <div class="card-header">Filters apply</div>
                    <div class="card-body">
                        <p class="card-text"> {{ $filters }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <h1> Order List</h1>
    <table class="table">
        <thead class="table-dark">
            <tr>
                <th>Customer name</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Product name</th>
                <th>Price</th>
                <th>Status order</th>
                <th>Action</th>

            </tr>
        </thead>
        <tbody>
        @foreach ($orders as $order)
        <tr>
            <td> {{  $order->customer_name }}</td>
            <td> {{  $order->customer_email }}</td>
            <td> {{  $order->customer_mobile }}</td>
            <td> {{  $order->product->product_name }}</td>
            <td>{{"$ " . number_format($order->product->price, 0, ",", ".")  }}</td>
            <td> {{  $order->status }}</td>
            <td>
                <a href="{{ route('order.detail', [ $order->reference ])}}" class="btn btn-info">View order</a>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
    <a href="{{ route('products.index')}}" class="btn btn-info">View products list</a>
@endsection

@extends('layout.layout')
@section('content')
    <a href="{{ route('order.new')}}" class="btn btn-warning">Create Order</a>

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
            <td> {{  $order->product->price }}</td>
            <td> {{  $order->status }}</td>
            <td>
                <a href="{{ route('order.detail', [ $order->reference ])}}" class="btn btn-info">View order</a>


            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
@endsection

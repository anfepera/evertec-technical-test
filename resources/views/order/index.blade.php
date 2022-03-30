@extends('layout.layout')
@section('content')
    <h1> Order List</h1>
    <table class="table">
        <thead class="table-dark">
            <tr>
                <th>Customer name</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Status order</th>
                <th>Product name</th>
                <th>Price</th>

            </tr>
        </thead>
        <tbody>
        @foreach ($orders as $order)
        <tr>
            <td> {{  $order->customer_name }}</td>
            <td> {{  $order->customer_email }}</td>
            <td> {{  $order->customer_mobile }}</td>
            <td> {{  $order->status }}</td>
            <td></td>
            <td></td>
        </tr>
        @endforeach
        </tbody>
    </table>
@endsection

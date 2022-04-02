@extends('layout.layout')
@section('content')
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

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
        <tr>
            <td>Andres Felipe</td>
            <td>andres.felipe.penna@gmail.com</td>
            <td>3118452133</td>
            <td>CREATED</td>
            <td>Computer</td>
            <td>4000000</td>
        </tr>
        </tbody>
    </table>
@endsection

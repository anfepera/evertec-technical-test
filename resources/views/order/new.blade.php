@extends('layout.layout')
@section('content')
    <h1> Create Order</h1>
    <form method="POST" action="{{ route('order.create') }}">
        @csrf
        <div class="container">
            <div class="row justify-content-md-center">
                <div class="col">
                    <label for="customer_name">Customer name:</label>
                    <input id="customer_name"
                           name="customer_name"
                           type="text"
                           class="@error('customer_name') is-invalid @enderror">
                </div>
            </div>
            <div class="row justify-content-md-center">
                <div class="col">
                    <label for="email">Email:</label>
                    <input id="email"
                           name="email"
                           type="email"
                           class="@error('email') is-invalid @else is-valid @enderror">
                </div>
            </div>
            <div class="row justify-content-md-center">
                <div class="col">
                    <label for="phone_number">Phone number:</label>
                    <input id="phone_number"
                           name="phone_number"
                           type="number"
                           class="@error('phone_number') is-invalid @enderror">
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <button type="submit" class="btn btn-success"  value="Submit">Save</button>
                </div>
            </div>
        </div>
    </form>


    @error('customer_name')
    <div class="alert alert-danger"> Customer name is required</div>
    @enderror
    @error('email')
    <div class="alert alert-danger"> Email is required</div>
    @enderror
    @error('phone_number')
    <div class="alert alert-danger"> Phone number is required</div>
    @enderror
@endsection

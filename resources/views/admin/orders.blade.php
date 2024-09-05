@extends('layouts.dashboard')

@section('pagecontent')
<div class="container mt-5">
    <h2 class="text-center mb-4">All Orders</h2>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Order ID</th>
                    <th>Customer Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Total Price</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->customer_name }}</td>
                        <td>{{ $order->customer_email }}</td>
                        <td>{{ $order->customer_phone }}</td>
                        <td>{{ $order->customer_address }}</td>
                        <td>{{ number_format($order->total_price, 2) }} MAD</td>
                        <td>
                            <a href="{{ route('orders.show', $order->id) }}" class="btn btn-info">View Details</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

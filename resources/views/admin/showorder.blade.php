@extends('layouts.dashboard')

@section('pagecontent')
    <div class="container mt-5 mb-5">
        <h2 class="text-center mb-4">Order Details</h2>

        <div class="row mb-4">
            <div class="col-md-4">
                <h4>Customer Information</h4>
                <ul class="list-group">
                    <li class="list-group-item"><strong>Name:</strong> {{ $order->customer_name }}</li>
                    <li class="list-group-item"><strong>Email:</strong> {{ $order->customer_email }}</li>
                    <li class="list-group-item"><strong>Phone:</strong> {{ $order->customer_phone }}</li>
                    <li class="list-group-item"><strong>Address:</strong> {{ $order->customer_address }}</li>
                </ul>
            </div>
            <div class="col-md-4">
                <h4>Total Price</h4>
                <p class="display-6 text-success"> {{ number_format($order->total_price, 2) }} MAD</p>
            </div>
            <div class="col-md-4">
                <h4 >Order Status</h4>
                <p class="display-6 text-{{ $order->orderstatus == 'pending' ? 'warning' : ($order->orderstatus == 'delivering' ? 'info' : ($order->orderstatus == 'cancelled' ? 'danger' : 'success')) }}">
                     {{$order->orderstatus }}</p>
            </div>
        </div>

        <h4 class="mb-3">Order Items:</h4>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>Type</th>
                        <th>Quantity</th>
                        <th>Item</th>
                        <th>Price per Unit</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->orderDetails as $detail)
                        <tr>
                            <td>{{ ucfirst($detail->product_id ? 'product' : 'pack') }}</td>
                            <td>X {{ $detail->quantity }}</td>
                            <td>
                                @if ($detail->product_id)
                                    @php $product = $detail->product; @endphp
                                    <img src="{{ asset('images/products/' . ($product->images->first()->path ?? 'default.jpg')) }}"
                                        alt="{{ $product->nom }}" class="img-thumbnail" width="100">
                                    {{ $product->nom }}
                                @elseif ($detail->pack_id)
                                    @php $pack = $detail->pack; @endphp
                                    <img src="{{ asset('images/packs/' . ($pack->image ?? 'default.jpg')) }}"
                                        alt="{{ $pack->name }}" class="img-thumbnail" width="100">
                                    {{ $pack->name }}
                                @endif
                            </td>
                            <td>
                                {{ number_format($detail->price, 2) }} MAD
                            </td>
                            <td>{{ number_format($detail->quantity * $detail->price, 2) }} MAD</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="font-weight-bold">
                        <td colspan="4" class="text-right">Total:</td>
                        <td>{{ number_format($order->total_price, 2) }} MAD</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('orders.index') }}" class="btn btn-secondary">
                  <i class="fas fa-arrow-left"></i>  &ensp; Back to Orders</a>
        </div>
    </div>
@endsection

@section('dashboardcss')
    <style>
        .img-thumbnail {
            border: 1px solid #dee2e6;
            border-radius: 0.25rem;
            padding: 0.25rem;
        }
    </style>
@endsection

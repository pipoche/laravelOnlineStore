@extends('layouts.master')

@section('content')
    <div class="container mt-5">
        <h2 class="text-center mb-4">Order Review</h2>

        <div class="row mb-4">
            <div class="col-md-6">
                <h4>Customer Information</h4>
                <ul class="list-group">
                    <li class="list-group-item"><strong>Name:</strong> {{ $customerInfo['name'] }}</li>
                    <li class="list-group-item"><strong>Email:</strong> {{ $customerInfo['email'] }}</li>
                    <li class="list-group-item"><strong>Phone:</strong> {{ $customerInfo['phone'] }}</li>
                    <li class="list-group-item"><strong>Address:</strong> {{ $customerInfo['address'] }}</li>
                </ul>
            </div>
            <div class="col-md-6">
                <h4>Total Price</h4>
                <p class="display-4 text-success">MAD {{ number_format($orderDetails['orderTotal'], 2) }}</p>
            </div>
        </div>

        <!-- Products Section -->
        <h4 class="mb-3">Products:</h4>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>Quantity</th>
                        <th>Product</th>
                        <th>Product Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orderDetails['items'] as $item)
                        @if ($item['type'] === 'product')
                            @foreach ($produits as $produit)
                                @if ($produit->id == $item['id'])
                                    <tr>
                                        <td>X {{ $item['quantity'] }}</td>
                                        <td>
                                            <img src="{{ asset('images/products/' . ($produit->images->first()->path ?? 'default.jpg')) }}"
                                                alt="{{ $produit->nom }}" class="img-thumbnail" width="100">
                                            {{ $produit->nom }}
                                        </td>
                                        <td>{{ number_format($item['price'], 2) }} MAD</td>
                                        <td>{{ number_format($item['total'], 2) }} MAD</td>
                                    </tr>
                                @endif
                            @endforeach
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Packs Section -->
        @if (!empty($packs))
            <h4 class="mb-3">Packs:</h4>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>Quantity</th>
                            <th>Pack</th>
                            <th>Pack Price</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orderDetails['items'] as $item)
                            @if ($item['type'] === 'pack')
                                @foreach ($packs as $pack)
                                    @if ($pack->id == $item['id'])
                                        <tr>
                                            <td>X {{ $item['quantity'] }}</td>
                                            <td>
                                                <img src="{{ asset('images/packs/' . ($pack->image ?? 'default.jpg')) }}"
                                                    alt="{{ $pack->nom }}" class="img-thumbnail" width="100">
                                                {{ $pack->nom }}
                                            </td>
                                            <td>{{ number_format($item['price'], 2) }} MAD</td>
                                            <td>{{ number_format($item['total'], 2) }} MAD</td>
                                        </tr>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <div class="row text-center mt-4">
            <div class="col-md-6">
                <button type="button" class="btn btn-danger btn-lg" data-bs-toggle="modal" data-bs-target="#cancelorder">
                    <i class="fas fa-times"></i> Cancel Order
                </button>
            </div>
            <div class="col-md-6">
                <form action="{{ route('order.submit') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary btn-lg" id="confirm-order-button">Confirm Order <i
                            class="fas fa-arrow-right"></i></button>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal for Canceling Order -->
    <div id="cancelorder" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="cancelorderLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cancelorderLabel">Cancel Order</h5>
                    <button type="button" class="btn-close btn-secondary" data-bs-dismiss="modal" aria-label="Close"><i
                            class="fas fa-times"></i></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to cancel this order? <br>

                        <i class="fas fa-exclamation-triangle"></i> All your selections will be lost.
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <form action="{{ route('order.cancel') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger" id="cancel-order-button">Cancel Order</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
@endsection

@section('styles')
    <style>
        .img-thumbnail {
            border: 1px solid #dee2e6;
            border-radius: 0.25rem;
            padding: 0.25rem;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script>
        function clearsessions() {
            sessionStorage.removeItem('orderdetails');
            sessionStorage.removeItem('cart');
            sessionStorage.removeItem('customer_info');
        }

        document.querySelector('#confirm-order-button').addEventListener('click', function() {
            clearsessions();
            updateItemCount();
        });
        document.querySelector('#cancel-order-button').addEventListener('click', function() {
            clearsessions();
            updateItemCount();
        });

        let orderDetails = JSON.parse(sessionStorage.getItem('orderdetails'));
        console.log(orderDetails);


        let carta = JSON.parse(sessionStorage.getItem('cart'));
        console.log(carta);

       
    </script>
@endsection

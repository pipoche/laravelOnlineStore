@extends('layouts.dashboard')

@section('dashboardcss')
    <style>
        .product-card {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100%;
        }

        .product-image {
            width: 150px;
            height: 150px;
            object-fit: contain;
            background-repeat: no-repeat;
            margin-bottom: 15px;
        }

        .product-details {
            text-align: center;
            margin-bottom: 15px;
        }

        .product-details h5 {
            margin: 0;
            font-size: 18px;
        }

        .product-price {
            text-decoration: line-through;
            color: red;
        }

        .product-new-price {
            color: green;
        }

        .product-discount {
            font-weight: bold;
            color: #007bff;
        }
    </style>
@endsection

@section('pagecontent')
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <h2>Promotions List</h2>

        <div class="row">
            @foreach ($promotionsData as $promotion)
                <div class="col-md-3 mt-1 mb-3">
                    <div class="product-card">
                        <img src="{{ $promotion['first_image'] }}" alt="Product Image" class="product-image">
                        <div class="product-details">
                            <h5>{{ $promotion['product_name'] }}</h5>
                            <p class="product-price">{{ $promotion['old_price'] }} MAD</p>
                            <p class="product-new-price">{{ $promotion['new_price'] }} MAD</p>
                            <p class="product-discount">{{ $promotion['percentage'] }}% Discount</p>
                        </div>
                        <div class="product-actions text-center">
                            <a href="{{ route('promotions.edit', $promotion['id']) }}" class="btn b btn-primary mb-2">Edit</a>
                            <form action="{{ route('promotions.destroy', $promotion['id']) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn  btn-danger" onclick="return confirm('Are you sure you want to delete this promotion?');">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

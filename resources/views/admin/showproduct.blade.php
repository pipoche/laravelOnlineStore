@extends('layouts.dashboard')

@section('dashboardcss')
    <style>
        .product-image-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .main-product-image-div {
            width: 100%;
            max-width: 400px;
            height: 400px;
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .thumbnail-container {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .thumbnail-image.active {
            opacity: 0.2;
            border: 2px solid #00000075;
            /* Add a border to indicate selection */
        }

        .thumbnail-image {
            width: 60px;
            height: 60px;
            border: 1px solid #ddd;
            border-radius: 8px;
            cursor: pointer;
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            transition: transform 0.2s, opacity 0.2s;
        }

        .thumbnail-image:hover {
            transform: scale(1.1);
        }


        .product-details {
            margin-top: 20px;
        }
    </style>
@endsection

@section('pagecontent')
    <div class="container">
        <div class="row product-details">
            <div class="col-md-6">
                <div class="product-image-container">
                    @if ($product->images->count())
                        <div id="mainProductImageDiv" class="main-product-image-div"
                            style="background-image: url('{{ asset('images/products/' . $product->images->first()->path) }}');">
                        </div>
                    @else
                        <div class="main-product-image-div"
                            style="background-image: url('{{ asset('images/products/default.jpg') }}');"></div>
                    @endif
                </div>
                <div class="thumbnail-container">
                    @foreach ($product->images as $image)
                        <div class="thumbnail-image"
                            style="background-image: url('{{ asset('images/products/' . $image->path) }}');"
                            onclick="changeMainImage('{{ asset('images/products/' . $image->path) }}', this)">
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-md-6">
                <h2>{{ $product->nom }}</h2>
                <p>{{ $product->description }}</p>
                <p>Category: {{ $product->category->nom }}</p>
                <p>Stock: {{ optional($product->stock)->stockquantity ?? 0 }}</p>
                @if ($product->promotions)
                    <p>Price:
                        <span style="text-decoration: line-through; color: red;">
                            {{ $product->price }} MAD
                        </span>
                        <span style="color: green; font-weight: bold;">
                            {{ $product->promotions->new_price }} MAD
                        </span>
                    </p>
                @else
                    <p>Price: {{ $product->price }} MAD</p>
                @endif


                <a href="{{ route('products') }}" class="btn btn-secondary mt-3">Back to Products</a>
            </div>
        </div>
    </div>
@endsection

@section('dashboardscripts')
    <script>
        function changeMainImage(imageUrl, thumbnailElement) {
            const mainImageDiv = document.getElementById('mainProductImageDiv');
            mainImageDiv.style.backgroundImage = `url('${imageUrl}')`;

            // Remove 'active' class from all thumbnails
            const thumbnails = document.querySelectorAll('.thumbnail-image');
            thumbnails.forEach(thumbnail => {
                thumbnail.classList.remove('active');
            });

            // Add 'active' class to the clicked thumbnail
            thumbnailElement.classList.add('active');
        }
    </script>
@endsection

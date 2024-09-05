@extends('layouts.dashboard')

@section('dashboardcss')
    <style>
        .product-image-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .main-product-image-div {
            width: 100%;
            max-width: 600px;
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
            flex-wrap: wrap;
        }

        .thumbnail-image.active {
            opacity: 0.5;
            border: 2px solid #00000075;
        }

        .thumbnail-image {
            width: 100px;
            height: 100px;
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

        .product-description {
            margin-bottom: 20px;
        }

        .total-price {
            font-weight: bold;
        }

        .loss {
            color: red;
        }
        .win{
            color: forestgreen;
        }
    </style>
@endsection

@section('pagecontent')
    <div class="container">
        <h2>Pack Details</h2>

        <div class="row product-details">
            <div class="col-md-6">
                <div class="product-image-container">
                    @if ($pack->image)
                        <div id="mainPackImageDiv" class="main-product-image-div"
                             style="background-image: url('{{ asset('images/packs/' . $pack->image) }}');">
                        </div>
                    @else
                        <div class="main-product-image-div"
                             style="background-image: url('{{ asset('images/packs/default.jpg') }}');"></div>
                    @endif
                </div>
                <div class="thumbnail-container">
                    <div class="thumbnail-image"
                                 style="background-image: url('{{ asset('images/packs/' . $pack->image) }}');"
                                 onclick="changeMainImage('{{ asset('images/packs/' . $pack->image) }}', this)">
                            </div>

                    @foreach ($pack->products as $product)
                        @foreach ($product->images as $image)
                        
                            <div class="thumbnail-image"
                                 style="background-image: url('{{ asset('images/products/' . $image->path) }}');"
                                 onclick="changeMainImage('{{ asset('images/products/' . $image->path) }}', this)">
                            </div>
                        @endforeach
                    @endforeach
                </div>
            </div>
            <div class="col-md-6">
                <h2>{{ $pack->name }}</h2>
                <p class="product-description">{{ $pack->description }}</p>
                
                <h3>Products in this Pack:</h3>
                <ul>
                    @php
                        $totalOriginalPrice = 0;
                    @endphp
                    @foreach ($pack->products as $product)
                        @php
                            $totalOriginalPrice += $product->price;
                        @endphp
                        <li>
                            <span>{{ $product->nom }}</span> <br>
                            <span>{{ $product->description }}</span> <br>
                            {{ number_format($product->price, 2) }} MAD
                        </li>
                    @endforeach
                </ul>

                @php
                    $packPrice = $pack->price;
                    $isLoss = $packPrice < $totalOriginalPrice;
                    
                @endphp

                <p class="total-price">
                    Total Original Price: 
                    <span class="{{ $isLoss ? 'loss' : 'win' }}">
                        {{ number_format($totalOriginalPrice, 2) }} MAD
                    </span>
                    
                </p>
                <p class="total-price">
                    Pack Price: 
                    {{ number_format($packPrice, 2) }} MAD
                </p>

                <a href="{{ route('packs') }}" class="btn btn-secondary mt-3">Back to Packs</a>
            </div>
        </div>
    </div>
@endsection

@section('dashboardscripts')
    <script>
        function changeMainImage(imageUrl, thumbnailElement) {
            const mainImageDiv = document.getElementById('mainPackImageDiv');
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

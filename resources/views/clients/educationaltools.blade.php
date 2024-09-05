@extends('layouts.master')

@section('head')
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <style>
        .pagination {
            justify-content: center;
            margin: 20px 0;
        }

        .pagination .page-item {
            margin: 0 2px;
        }

        .pagination .page-link {
            border-radius: 0.25rem;
            background-color: #f8f9fa;
            color: #007bff;
            border: 1px solid #dee2e6;
        }

        .pagination .page-link:hover {
            background-color: #e9ecef;
            color: #0056b3;
        }

        .pagination .page-item.active .page-link {
            background-color: #007bff;
            color: #ffffff;
            border-color: #007bff;
        }

        .pagination .page-item.disabled .page-link {
            color: #6c757d;
            pointer-events: none;
            background-color: #ffffff;
            border-color: #dee2e6;
        }

        .category-image {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            margin-right: 5px;
        }

        .category-checkbox {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }

        .category-checkbox:checked+label {
            font-weight: bold;
            color: #007bff;
        }

        .category-checkbox:checked+label::before {
            content: '✔';
            margin-right: 8px;
            color: #007bff;
            font-weight: bold;
        }


        /* Responsive Styling */
        @media (max-width: 576px) {
            .pagination {
                font-size: 0.8rem;
            }
        }
    </style>
@endsection
@section('content')
    <div class="container">
        <br>
        <h4 class="text-center">Education Tools</h2>


            <div class="row">
                <div class="col-md-3">
                    <h5>Filter by Category</h5>
                    <ul class="list-group category-list">
                        @foreach ($categoriestools as $category)
                            <li class="list-group-item ">
                                <img src="{{ asset('images/categories/' . ($category->picture ?? 'default-category.jpg')) }}"
                                    alt="Category Image" class="category-image">

                                <input type="checkbox" id="category-{{ $category->id }}" value="{{ $category->id }}"
                                    class="category-checkbox " hidden>

                                <label for="category-{{ $category->id }}" class="cursor-item">{{ $category->nom }} </label>
                            </li>
                        @endforeach
                    </ul>

                </div>
                <div class="col-md-9">
                    <div class="row" id="ads">
                        @foreach ($products as $product)
                            @if ($product->producttype === 'ET')
                                <div class="col-md-4 card-tool-item  product-card "
                                    data-category="{{ $product->category->id }}">
                                    <div class="card rounded product">
                                        <div class="card-image">
                                            @if ($product->promotions)
                                                @php
                                                    $oldPrice = $product->price;
                                                    $newPrice = $product->promotions->new_price;
                                                    $percentage =
                                                        $oldPrice > 0 ? (($oldPrice - $newPrice) / $oldPrice) * 100 : 0;
                                                @endphp
                                                <span class="card-notify-badge">promotions</span>
                                                <span class="card-notify-year">-{{ number_format($percentage, 0) }}%</span>
                                            @endif

                                            <img class="img-fluid"
                                                src="{{ asset('images/products/' . ($product->images->first()->path ?? 'default.jpg')) }}"
                                                alt="{{ $product->name }}" />
                                        </div>
                                        <div class="card-image-overlay m-auto">
                                            @if ($product->promotions)
                                                <p>
                                                    <span style="text-decoration: line-through; color: red;">
                                                        {{ $product->price }} MAD
                                                    </span><br>
                                                    <span style="color: green; font-weight: bold;">
                                                        {{ $product->promotions->new_price }} MAD
                                                    </span>
                                                </p>
                                            @else
                                                <p>
                                                    <span>

                                                    </span><br>
                                                    <span style="color: green; font-weight: bold;">
                                                        {{ $product->price }} MAD
                                                    </span>
                                                </p>
                                            @endif
                                        </div>
                                        <div class="card-body text-center">
                                            <div class="ad-title m-auto text-dark">
                                                <h5>{{ $product->nom }}</h5>
                                            </div>
                                            <a class="add-to-cart" data-product-id="{{ $product->id }}">ADD
                                                to cart</a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach

                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $products->links('pagination::bootstrap-4', ['class' => 'pagination bg-light border rounded']) }}
            </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Get all category checkboxes
        const categoryCheckboxes = document.querySelectorAll('.category-checkbox');

        // Get all product cards
        const productCards = document.querySelectorAll('.product-card');

        function filterProducts() {
            // Get the IDs of selected categories
            const selectedCategories = Array.from(categoryCheckboxes)
                .filter(checkbox => checkbox.checked)
                .map(checkbox => checkbox.value);

            // Show or hide products based on selected categories
            productCards.forEach(card => {
                const productCategory = card.getAttribute('data-category');
                if (selectedCategories.length === 0 || selectedCategories.includes(productCategory)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        // Attach event listeners to checkboxes
        categoryCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', filterProducts);
        });

        // Initial filter to apply at the page load
        filterProducts();
    </script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
@endsection

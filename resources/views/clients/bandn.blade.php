@extends('layouts.master')

@section('head')
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

        @media (max-width: 576px) {
            .pagination {
                font-size: 0.8rem;
            }
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <h1 style="margin-top: 50px" class="text-center"> BOOKS AND NOVELS</h1>
        <div class="row">
            <div class="col-md-3">
                <h5>Filter by Category</h5>
                <ul class="list-group category-list">
                    @foreach ($categoriesbooks as $category)
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
                <div class="row" id="book&novels">
                    @php
                        $count = 0;
                    @endphp

                    @foreach ($books as $book)
                        <div class="col-md-6 bookORnovel product-card my-3" data-category="{{ $book->category->id }}">
                            <div class="card container">
                                <div class="circle" style="--clr: {{ $count % 2 == 0 ? '#fd7015' : '#0d3853' }};">
                                    <img src="{{ asset('images/products/' . ($book->images->first()->path ?? 'default.jpg')) }}"
                                        class="logo">
                                </div>

                                <img src="{{ asset('images/products/' . ($book->images->first()->path ?? 'default.jpg')) }}"
                                    class="product_img">

                                <div class="content">
                                    <h2>{{ $book->name }}</h2>

                                    @if ($book->promotions)
                                        <p>
                                            <span style="text-decoration: line-through; color: red;">
                                                {{ $book->price }} MAD
                                            </span><br>
                                            <span style="color: green; font-weight: bold;">
                                                {{ $book->promotions->new_price }} MAD
                                            </span>
                                        </p>
                                    @else
                                        <p style="color: green; font-weight: bold;">
                                            {{ $book->price }} MAD
                                        </p>
                                    @endif

                                    <div class="button-group">
                                        <a href="/voirproduct/{{ $book->id }}" class="btn btn-explore">Explorer</a>
                                        <a class="btn btn-add text-light add-to-cart"
                                            data-product-id="{{ $book->id }}">+ <i class="fa fa-shopping-bag"
                                                aria-hidden="true"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @php
                            $count += 1;
                        @endphp
                    @endforeach

                    <div class="d-flex justify-content-center mt-4">
                        {{ $books->links('pagination::bootstrap-4', ['class' => 'pagination bg-light border rounded']) }}
                    </div>
                </div>
            </div>
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
@endsection

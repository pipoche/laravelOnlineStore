@extends('layouts.dashboard')

@section('dashboardcss')
    <style>
        .product-card .card {
            position: relative;
            padding-top: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: visible;
            /* Allow dropdown to overflow */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        /* Dropdown styling for the left side */
        .top-left-dropdown {
            position: absolute;
            top: 10px;
            left: 10px;
            z-index: 1000;
            /* Ensure dropdown is above other elements */
        }

        .dropdown-menu {
            border-radius: 8px;
            padding: 10px;
            min-width: 120px;
            z-index: 1100;
            position: absolute;
            top: 30px;
            /* Ensure dropdown starts below the icon */
            left: 0;
            /* Align dropdown to the left side */
            display: none;
            /* Hidden by default */
            overflow: visible;
        }

        .dropdown-menu.show {
            display: block;
            /* Show dropdown */
        }

        .dropdown-menu .dropdown-item {
            padding: 5px 10px;
            color: #333;
            font-size: 14px;
            transition: background-color 0.2s ease, color 0.2s ease;
        }

        .dropdown-menu .dropdown-item:hover {
            background-color: #007bff;
            color: #fff;
        }

        .card-image {
            height: 150px;
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            border-radius: 8px;
        }

        .card-body .card-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .card-body .card-text {
            font-size: 14px;
            color: #666;
            margin-bottom: 10px;
        }

        .view-product-btn {
            font-size: 14px;
            padding: 5px 10px;
            border-radius: 20px;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .view-product-btn:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
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
            /* Make it invisible */
            pointer-events: none;
            /* Prevent it from interfering with clicks */
        }

        /* Custom label styling to indicate selection */
        .category-checkbox:checked+label {
            font-weight: bold;
            color: #007bff;
        }

        /* Optional: Add a visual indicator (like a checkmark) next to the label when checked */
        .category-checkbox:checked+label::before {
            content: '✔';
            margin-right: 8px;
            color: #007bff;
            font-weight: bold;
        }

        .cursor-item {
            cursor: pointer;
        }
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

        /* Responsive Styling */
        @media (max-width: 576px) {
            .pagination {
                font-size: 0.8rem;
            }
        }

    </style>
@endsection

@section('pagecontent')
    <div class="container ">
        @if (session('success'))
        <div class="alert alert-success p-3">
            {{ session('success') }}
        </div>
    @endif
        <div class="row align-items-center  mb-3 mt-3">
            <div class="col-md-6">
                <h1>Products</h1>
            </div>
            <div class="col-md-6 text-end">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addproduct">
                    Add New Product
                </button>
            </div>
        </div>

        <div class="container mt-2">
            <div class="row">
                <div class="col-md-3">
                    <h5>Filter by Category</h5>
                    <ul class="list-group category-list">
                        @foreach ($categories as $category)
                            <li class="list-group-item ">
                                <img src="{{ asset('images/categories/' . ($category->picture ?? 'default-category.jpg')) }}"
                                    alt="Category Image" class="category-image">

                                <!-- Hidden Checkbox -->
                                <input type="checkbox" id="category-{{ $category->id }}" value="{{ $category->id }}"
                                    class="category-checkbox " hidden>

                                <label for="category-{{ $category->id }}" class="cursor-item">{{ $category->nom }} </label>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-md-9">
                    <div class="row" id="product-list">
                        @foreach ($products as $product)
                            <div class="col-md-3 m-3 mb-3 product-card" data-category="{{ $product->category->id }}">
                                <div class="card position-relative">
                                    <div class="dropdown top-left-dropdown">
                                        <i class="fas fa-list dropdown-toggle cursor-item"
                                            id="dropdownMenuButton{{ $product->id }}" data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false"></i>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $product->id }}">
                                            <a class="dropdown-item"
                                                href="{{ route('products.edit', $product->id) }}">Edit</a>
                                            <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this product?');">
                                                @csrf
                                                @method('DELETE')
                                                <button class="dropdown-item" type="submit">Delete</button>
                                            </form>
                                            <button type="button" class="dropdown-item" data-bs-toggle="modal"
                                                data-bs-target="#addpromotion" data-product-id="{{ $product->id }}"
                                                data-product-name="{{ $product->nom }}"> Add
                                                Promotion</button>
                                        </div>
                                    </div>
                                    <div class="card-image m-3"
                                        style="background-image: url('{{ asset('images/products/' . ($product->images->first()->path ?? 'default.jpg')) }}');">
                                    </div>
                                    <div class="card-body text-center">
                                        <h5 class="card-title">{{ $product->nom }}</h5>
                                        <p class="card-text">
                                            Category:

                                            {{ $product->category->nom }}
                                            <br>
                                            Stock: {{ optional($product->stock)->stockquantity ?? 0 }} <br>
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
                                                <p>Price: {{ $product->price }} MAD</p>
                                            @endif
                                        </p>
                                        <a href="{{ route('products.show', $product->id) }}"
                                            class="btn btn-primary view-product-btn ml-3">View Product</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $products->links('pagination::bootstrap-4', ['class' => 'pagination bg-light border rounded']) }}
        </div>


    </div>





    <div id="addproduct" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Add New Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('insertproduct') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <!-- Product nom -->
                        <div class="form-group">
                            <label for="nom">Product Name</label>
                            <input type="text" name="nom" id="nom"
                                class="form-control @error('nom') is-invalid @enderror" value="{{ old('nom') }}"
                                required>
                            @error('nom')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Product Description -->
                        <div class="form-group mt-3">
                            <label for="description">Product Description</label>
                            <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror"
                                rows="3" required>{{ old('description') }}</textarea>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Category Selection-->
                        <div class="form-group mt-3">
                            <label for="id_category">Category</label>
                            <select name="id_category" id="id_category"
                                class="form-control @error('id_category') is-invalid @enderror" required>
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->nom }}</option>
                                @endforeach
                            </select>
                            @error('id_category')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Product Type -->
                        <div class="form-group mt-3">
                            <label for="product_type">Product Type</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="product_type" id="bn"
                                    value="B&N" required>
                                <label class="form-check-label" for="bn">Books & Novels (B&N)</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="product_type" id="et"
                                    value="ET" required>
                                <label class="form-check-label" for="et">Education Tools (ET)</label>
                            </div>
                            @error('product_type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Product Images -->
                        <div class="form-group mt-3">
                            <label for="images">Product Images</label>
                            <input type="file" name="images[]" id="images"
                                class="form-control @error('images') is-invalid @enderror" multiple>
                            @error('images')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group mt-3">
                            <label for="price">Product Price</label>
                            <input type="number" name="price" id="price"
                                class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}"
                                required min="0">
                            @error('price')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group mt-3">
                            <label for="stock_quantity">Inserted Quantity</label>
                            <input type="number" name="stock_quantity" id="stock_quantity"
                                class="form-control @error('stock_quantity') is-invalid @enderror"
                                value="{{ old('stock_quantity') }}" required min="0">
                            @error('stock_quantity')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Modal Footer -->
                        <div class="modal-footer mt-4">
                            <button type="button" class="btn btn-secondary waves-effect"
                                data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary waves-effect waves-light">Create
                                Product</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Add Promotion Modal -->
    <div id="addpromotion" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="promotionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="promotionModalLabel">Add Promotion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('promotions.store') }}" method="POST">
                        @csrf

                        <!-- Product ID (hidden) -->
                        <input type="hidden" name="product_id" id="promotion_product_id">

                        <!-- Product Name -->
                        <p id="promotion_product_name" class="fw-bold"></p>

                        <!-- New Price -->
                        <div class="form-group">
                            <label for="new_price">New Price</label>
                            <input type="number" name="new_price" id="new_price" step="0.01"
                                class="form-control @error('new_price') is-invalid @enderror"
                                value="{{ old('new_price') }}" required>

                            @error('new_price')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="modal-footer mt-4">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Add Promotion</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('dashboardscripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var promotionModal = document.getElementById('addpromotion');
            promotionModal.addEventListener('show.bs.modal', function(event) {
                // Get the button that triggered the modal
                var button = event.relatedTarget;
                // Extract the product ID and name from the data attributes
                var productId = button.getAttribute('data-product-id');
                var productName = button.getAttribute('data-product-name');
                // Set the product ID in the hidden input field
                var productIdInput = promotionModal.querySelector('#promotion_product_id');
                productIdInput.value = productId;
                // Set the product name in the paragraph element
                var productNamePara = promotionModal.querySelector('#promotion_product_name');
                productNamePara.textContent = 'Product: ' + productName;
            });

            const categoryCheckboxes = document.querySelectorAll('.category-checkbox');
            const productCards = document.querySelectorAll('.product-card');

            function filterProducts() {
                // Get the IDs of selected categories
                const selectedCategories = Array.from(categoryCheckboxes)
                    .filter(checkbox => checkbox.checked)
                    .map(checkbox => checkbox.value);

                // Debug: Log selected categories
                console.log('Selected Categories:', selectedCategories);

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

            // Initial filter
            filterProducts();
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
@endsection

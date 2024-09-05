@extends('layouts.master')

@section('title')
    store home
@endsection

@section('head')
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
    @include('home.slidebar')


    @include('home.shop1sec')


    <!-- why section -->
    @include('home.whyus')
    <!-- end why section -->


    <!-- shop2 section -->
    @include('home.shop2sec')
    <!-- end shop2 section -->

    <!-- saving section -->
    @include('home.savingsec')
    <!-- end saving section -->
@endsection


@section('scripts')
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const slides = document.querySelectorAll('.card-slide');
            let currentIndex = 0;

            function changeSlide() {
                const previousIndex = (currentIndex - 1 + slides.length) % slides.length;
                const nextIndex = (currentIndex + 1) % slides.length;

                slides.forEach((slide, index) => {
                    slide.classList.remove('left', 'right', 'active');
                    if (index === currentIndex) {
                        slide.classList.add('active');
                    } else if (index === previousIndex) {
                        slide.classList.add('left');
                    } else if (index === nextIndex) {
                        slide.classList.add('right');
                    }
                });

                currentIndex = nextIndex;
            }

            changeSlide(); // Initialize the first slide positions
            setInterval(changeSlide, 2000); // Change slide every 5 seconds

            let orderDetails = JSON.parse(sessionStorage.getItem('orderdetails'));
            console.log(orderDetails);
            let carta = JSON.parse(sessionStorage.getItem('cart'));
            console.log(carta);
            let customer_info = JSON.parse(sessionStorage.getItem('customer_info'));
            console.log(customer_info);

            function filterProducts() {
                let selectedCategories = [];

                // Get all selected categories
                document.querySelectorAll('input[name="category[]"]:checked').forEach(function(checkbox) {
                    selectedCategories.push(checkbox.value);
                });

                // AJAX request to get products based on selected categories
                if (selectedCategories.length > 0) {
                    fetch('/filter-products', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                categories: selectedCategories
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            // Update the products container with the new products
                            let productsContainer = document.getElementById('products-container');
                            productsContainer.innerHTML = '';

                            data.products.forEach(function(product) {
                                let productDiv = document.createElement('div');
                                productDiv.classList.add('product');
                                productDiv.innerHTML = `<h5>${product.name}</h5>`;
                                productsContainer.appendChild(productDiv);
                            });
                        });
                } else {
                    // If no categories selected, revert to the original latest products
                    location.reload();
                }
            }
        });
    </script>
@endsection

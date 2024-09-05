<!DOCTYPE html>
<html>

<head>
    <!-- Basic -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- Site Metas -->
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css"
        rel="stylesheet">

    <title>
        @yield('title')
    </title>


    @yield('head')
    <style>
        .costumnav {
            display: flex;
            justify-content: space-between;
            width: 100%;
        }

        .language-buttons,
        .social-media-icons {
            display: flex;
            align-items: center;
        }


        .social-media-icons a {
            margin-right: 10px;
            font-size: 30px;
            color: #000;
            text-decoration: none;
        }

        .social-media-icons a:hover {
            color: #0d3853;
        }

        .language-buttons img,
        .social-media-icons i {
            display: inline-block;
            width: 30px;
            height: 30px;
            line-height: 24px;
            text-align: center;
        }
    </style>
    <!-- slider stylesheet -->
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />

    <!-- bootstrap core css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.css') }}" />

    <!-- Custom styles for this template -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" />
    <!-- responsive style -->
    <link href="{{ asset('assets/css/responsive.css') }}" rel="stylesheet" />
</head>

<body>
    <div class="hero_area">
        <!-- header section strats -->
        <header>
            @include('partials.header')
        </header>
        <!-- end header section -->

        <!-- Main Content Section -->
        <main>
            @yield('content') <!-- Main content will go here -->
        </main>
        <!-- end main content section -->



        <!-- info section -->


        <form id="pannier-form" action="{{ route('sendpannier') }}" method="GET">
            @csrf
            <div class="pannier-icon">
                <a href="#" onclick="goToPannier()">
                    <i class="fas fa-shopping-bag"></i>
                    <span class="item-count">0</span>
                    <input id="product-ids" name="product_ids" type="hidden" value="">
                </a>
            </div>
        </form>



        <footer>
            @include('partials.footer')
        </footer>
        <!-- end info section -->


        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="{{ asset('assets/js/jquery-3.4.1.min.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
        <script src="{{ asset('assets/js/custom.js') }}"></script>


        <!-- Google Map -->
        <!-- End Google Map -->



        <script>
            let cart = JSON.parse(sessionStorage.getItem('cart')) || [];

            // Function to update the item count in the pannier icon
            function updateItemCount() {
                document.querySelector('.pannier-icon .item-count').textContent = cart.length;
                document.getElementById('product-ids').value = cart.map(item => item.id).join(
                ','); // Join the IDs into a comma-separated string
            }

            // Function to add a product or pack to the cart
            function addToCart(id, isPack) {
                if (isPack) {
                    id = `pack_${id}`;
                }
                if (!cart.some(item => item.id === id && item.isPack === isPack)) {
                    cart.push({
                        id,
                        isPack
                    });
                    sessionStorage.setItem('cart', JSON.stringify(cart));
                    updateItemCount();
                }
            }

            // Event listener for the Add to Cart buttons
            document.querySelectorAll('.add-to-cart').forEach(button => {
                button.addEventListener('click', function() {
                    let productId = this.dataset.productId;
                    let isPack = this.dataset.isPack === 'true'; // Assuming you set data-is-pack attribute to true/false
                    addToCart(productId, isPack);
                });
            });

            // Function to handle the pannier click
            function goToPannier() {
                document.getElementById('pannier-form').submit();
            }

            function removeFromCart(id, isPack) {
                cart = cart.filter(item => !(item.id === id && item.isPack === isPack));
                sessionStorage.setItem('cart', JSON.stringify(cart)); // Update sessionStorage
                updateItemCount(); // Update item count
            }

            // Event listener for the remove buttons
            document.querySelectorAll('.remove-btn').forEach(button => {
                button.addEventListener('click', function() {
                    let productId = this.dataset.productId;
                    let isPack = this.dataset.isPack ===
                    'true'; // Assuming you set data-is-pack attribute to true/false
                    removeFromCart(productId, isPack); // Remove from cart
                    goToPannier(); // Redirect to the pannier page
                });
            });

            // Update the item count when the page loads
            updateItemCount();
        </script>

        @yield('scripts')

</body>

</html>

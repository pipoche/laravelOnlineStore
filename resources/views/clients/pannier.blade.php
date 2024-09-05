@extends('layouts.master')

@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        /* General Styles */
        ul {
            list-style: none;
            margin-bottom: 0;
            padding: 0;
        }

        .button {
            display: inline-block;
            background: #0e8ce4;
            border-radius: 5px;
            height: 48px;
            transition: all 200ms ease;
            text-align: center;
            line-height: 48px;
        }

        .button a {
            display: block;
            font-size: 18px;
            font-weight: 400;
            color: #FFFFFF;
            padding: 0 35px;
            text-decoration: none;
        }

        .button:hover {
            opacity: 0.8;
        }

        /* Cart Section */
        .cart_section {
            width: 100%;
            padding: 93px 0 111px;
        }

        .cart_title {
            font-size: 30px;
            font-weight: 500;
            text-align: center;
            margin-bottom: 30px;
        }

        /* Cart Items */
        .cart_items {
            margin-top: 8px;
        }

        .cart_list {
            border: solid 1px #e8e8e8;
            box-shadow: 0px 1px 5px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
        }

        .cart_item {
            display: flex;
            flex-wrap: wrap;
            padding: 15px;
            border-bottom: 1px solid #e8e8e8;
        }

        .cart_item_image {
            flex: 1 1 100px;
            max-width: 100px;
            margin-right: 15px;
        }

        .cart_item_image img {
            max-width: 100%;
            height: auto;
        }

        .cart_item_info {
            flex: 2 1;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        /* Cart Item Columns */
        .cart_info_col {
            flex: 1 1 auto;
            margin-bottom: 15px;
            text-align: center;
        }

        .cart_item_title {
            font-size: 14px;
            font-weight: 400;
            color: rgba(0, 0, 0, 0.5);
        }

        .cart_item_text {
            font-size: 18px;
            margin-top: 5px;
        }

        /* Cart Item Price and Total */
        .cart_item_price,
        .cart_item_total {
            text-align: right;
        }

        /* Order Total */
        .order_total {
            margin-top: 30px;
            border: solid 1px #e8e8e8;
            box-shadow: 0px 1px 5px rgba(0, 0, 0, 0.1);
            padding: 15px;
            background-color: #fff;
            border-radius: 8px;
        }

        .order_total_title {
            font-size: 14px;
            color: rgba(0, 0, 0, 0.5);
        }

        .order_total_amount {
            font-size: 18px;
            font-weight: 500;
        }

        /* Cart Buttons */
        .cart_buttons {
            margin-top: 60px;
            text-align: right;
        }

        .cart_button_clear,
        .cart_button_checkout {
            display: inline-block;
            border: none;
            font-size: 18px;
            font-weight: 400;
            line-height: 48px;
            padding: 0 35px;
            outline: none;
            cursor: pointer;
            border-radius: 5px;
        }

        .cart_button_clear {
            color: rgba(0, 0, 0, 0.5);
            background: #FFFFFF;
            border: solid 1px #b2b2b2;
            margin-right: 26px;
        }

        .cart_button_clear:hover {
            border-color: #0e8ce4;
            color: #0e8ce4;
        }

        .cart_button_checkout {
            color: #FFFFFF;
            background: #0e8ce4;
        }

        .cart_button_checkout:hover {
            opacity: 0.8;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .cart_item_info {
                flex-direction: column;
                align-items: center;
            }

            .cart_item_image {
                margin-right: 0;
                margin-bottom: 15px;
            }
        }
    </style>
@endsection

@section('content')
    <div class="cart_section">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-10 offset-lg-1">
                    <div class="cart_container">
                        <div class="cart_title">Shopping Cart<small id="totalitems"> </small></div>

                        <!-- Display Products -->
                        @forelse ($products as $product)
                            <div class="cart_items">
                                <ul class="cart_list">
                                    <li class="cart_item clearfix"
                                        data-price="{{ $product->promotions ? $product->promotions->new_price : $product->price }}">
                                        <div class="cart_item_image"><img
                                                src="{{ asset('images/products/' . ($product->images->first()->path ?? 'default.jpg')) }}"
                                                alt="{{ $product->nom }}"></div>
                                        <div class="cart_item_info d-flex flex-md-row flex-column justify-content-between">
                                            <div class="cart_item_name cart_info_col text-center">
                                                <div class="cart_item_title">Name</div>
                                                <div class="cart_item_text">{{ $product->nom }}</div>
                                            </div>

                                            <div class="cart_item_quantity cart_info_col text-center">
                                                <div class="cart_item_title">Quantity</div>
                                                <div class="input-group">
                                                    <button class="btn btn-outline-secondary decreaseQuantity"
                                                        type="button"><i class="fas fa-minus"></i></button>
                                                    <input type="number" class="form-control text-center quantityInput"
                                                        value="1">
                                                    <button class="btn btn-outline-secondary increaseQuantity"
                                                        type="button"><i class="fas fa-plus"></i></button>
                                                </div>
                                            </div>
                                            <div class="cart_item_price cart_info_col text-center">
                                                <div class="cart_item_title">Price</div>
                                                <div class="cart_item_text price">
                                                    {{ $product->promotions ? $product->promotions->new_price : $product->price }}
                                                </div>
                                            </div>
                                            <div class="cart_item_total cart_info_col text-center">
                                                <div class="cart_item_title">Total</div>
                                                <div class="cart_item_text totalPrice">MAD {{ $product->price }}</div>
                                            </div>
                                            <div class="cart_item_total cart_info_col text-center">
                                                <div class="cart_item_title">Remove</div>
                                                <div class="cart_item_text"><button class="remove-btn"
                                                        data-product-id="{{ $product->id }}"><i
                                                            class="fas fa-trash"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        @empty
                            <p>No products in your cart.</p>
                        @endforelse

                        <!-- Display Packs -->
                        @forelse ($packs as $pack)
                            <div class="cart_items">
                                <ul class="cart_list">
                                    <li class="cart_item clearfix" data-price="{{ $pack->price }}">
                                        <!-- Assuming `price` is an attribute of the Pack model -->
                                        <div class="cart_item_image"><img
                                                src="{{ asset('images/packs/' . ($pack->image ?? 'default.jpg')) }}"
                                                alt="{{ $pack->name }}"></div>
                                        <div class="cart_item_info d-flex flex-md-row flex-column justify-content-between">
                                            <div class="cart_item_name cart_info_col text-center">
                                                <div class="cart_item_title">Name</div>
                                                <div class="cart_item_text">{{ $pack->name }}</div>
                                            </div>

                                            <div class="cart_item_quantity cart_info_col text-center">
                                                <div class="cart_item_title">Quantity</div>
                                                <div class="input-group">
                                                    <button class="btn btn-outline-secondary decreaseQuantity"
                                                        type="button"><i class="fas fa-minus"></i></button>
                                                    <input type="number" class="form-control text-center quantityInput"
                                                        value="1">
                                                    <button class="btn btn-outline-secondary increaseQuantity"
                                                        type="button"><i class="fas fa-plus"></i></button>
                                                </div>
                                            </div>
                                            <div class="cart_item_price cart_info_col text-center">
                                                <div class="cart_item_title">Price</div>
                                                <div class="cart_item_text price">
                                                    {{ $pack->price }}
                                                </div>
                                            </div>
                                            <div class="cart_item_total cart_info_col text-center">
                                                <div class="cart_item_title">Total</div>
                                                <div class="cart_item_text totalPrice">MAD {{ $pack->price }}</div>
                                            </div>
                                            <div class="cart_item_total cart_info_col text-center">
                                                <div class="cart_item_title">Remove</div>
                                                <div class="cart_item_text"><button class="remove-btn"
                                                        data-pack-id="{{ $pack->id }}"><i
                                                            class="fas fa-trash"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        @empty
                            <p>No packs in your cart.</p>
                        @endforelse

                        <!-- Order Total -->
                        <div class="order_total">
                            <div class="order_total_content text-md-right">
                                <div class="order_total_title">Order Total:</div>
                                <div class="order_total_amount">MAD 0.00</div>
                            </div>
                        </div>
                        <div class="cart_buttons">
                            <a href="{{ route('homepage') }}" type="button" class="button cart_button_clear">Continue
                                Shopping</a>
                            <a href="{{ route('order.checkoutform') }}" type="button"
                                class="button cart_button_checkout">Checkout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const updateCartTotal = () => {
                let grandTotal = 0;

                document.querySelectorAll('.cart_item').forEach(item => {
                    const quantityInput = item.querySelector('.quantityInput');
                    const price = parseFloat(item.dataset.price);
                    const quantity = parseInt(quantityInput.value, 10);
                    const totalPrice = item.querySelector('.totalPrice');

                    const total = price * quantity;
                    totalPrice.textContent = `MAD ${total.toFixed(2)}`;
                    grandTotal += total;
                });

                document.querySelector('.order_total_amount').textContent = `MAD${grandTotal.toFixed(2)}`;
            };

            function updateSessionOrderDetails() {
                let orderDetails = {
                    items: [],
                    orderTotal: 0
                };

                document.querySelectorAll('.cart_item').forEach(item => {
                    const quantity = parseInt(item.querySelector('.quantityInput').value, 10);
                    const price = parseFloat(item.dataset.price);
                    const total = quantity * price;

                    const productId = item.querySelector('.remove-btn').dataset.productId;
                    const packId = item.querySelector('.remove-btn').dataset.packId;

                    if (productId) {
                        orderDetails.items.push({
                            type: 'product',
                            id: productId,
                            quantity: quantity,
                            price: price,
                            total: total
                        });
                    } else if (packId) {
                        orderDetails.items.push({
                            type: 'pack',
                            id: packId,
                            quantity: quantity,
                            price: price,
                            total: total
                        });
                    }

                    orderDetails.orderTotal += total;
                });

                sessionStorage.setItem('orderdetails', JSON.stringify(orderDetails));
            }

            document.querySelectorAll('.cart_item').forEach(item => {
                const decreaseButton = item.querySelector('.decreaseQuantity');
                const increaseButton = item.querySelector('.increaseQuantity');
                const quantityInput = item.querySelector('.quantityInput');

                decreaseButton.addEventListener('click', () => {
                    let currentValue = parseInt(quantityInput.value, 10);
                    if (currentValue > 1) {
                        quantityInput.value = currentValue - 1;
                        updateCartTotal();
                        updateSessionOrderDetails();
                    }
                });

                increaseButton.addEventListener('click', () => {
                    let currentValue = parseInt(quantityInput.value, 10);
                    quantityInput.value = currentValue + 1;
                    updateCartTotal();
                    updateSessionOrderDetails();
                });

                quantityInput.addEventListener('change', () => {
                    updateCartTotal();
                    updateSessionOrderDetails();

                });
            });

            updateCartTotal(); // Initialize total calculation on page load
            updateSessionOrderDetails();



        });
    </script>
@endsection

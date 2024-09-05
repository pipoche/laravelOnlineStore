<section class="shop_section layout_padding">
    <div class="container">
        <div class="heading_container heading_center">
            <h2>
                <i class="fas fa-star"></i>
                Education Tools
            </h2>
        </div>
        <div class="row" id="ads">

            <div class="col-md-12">
                <div class="container">
                    <ul class="list-group category-list">
                       
                    </ul>
                    <div class="row">
                        <!-- Loop through products with product_type ET -->
                        @foreach ($products as $product)
                            @if ($product->producttype === 'ET')
                                <div class="col-md-4 card-tool-item">
                                    <div class="card rounded product fixingheight">
                                        <div class="card-image">
                                            @if ($product->promotions)
                                                @php
                                                    $oldPrice = $product->price;
                                                    $newPrice = $product->promotions->new_price;
                                                    $percentage =
                                                        $oldPrice > 0 ? (($oldPrice - $newPrice) / $oldPrice) * 100 : 0;
                                                @endphp
                                                <span class="card-notify-badge">promotions</span>
                                                <span
                                                    class="card-notify-year">{{ number_format($percentage, 0) }}%</span>
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
                                            <a class="add-to-cart"  data-is-pack="false" data-product-id="{{ $product->id }}" >ADD
                                                to cart</a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <div class="btn-box">
                        <a href="{{ route('edutol') }}">
                            View All Products <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="text" style="display: none" id="shop1saver" name="shop1saver">
</section>

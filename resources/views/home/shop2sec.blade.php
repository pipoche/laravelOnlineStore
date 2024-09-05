<section class="shop_section layout_padding">
    <div class="container">
        <div class="heading_container heading_center">
            <h2>
                <i class="fas fa-book"></i>
                Books & Novels
            </h2>
        </div>
        <div class="row">
            <!-- Categories Sidebar -->
            
            <!-- Products Section -->
            <div class="">
                <div class="row" id="book-list">
                    <div class="row" id="book&novels">
                        @php
                            $count = 0; // Initialize count before the loop
                        @endphp
            
                        @foreach ($books as $book)
                            <div class="col-md-4 bookORnovel my-3">
                                <div class="card container">
                                    <!-- Circle with dynamic color -->
                                    <div class="circle" style="--clr: {{ $count % 2 == 0 ? '#fd7015' : '#0d3853' }};">
                                        <img src="{{ asset('images/products/' . ($book->images->first()->path ?? 'default.jpg')) }}"
                                            class="logo">
                                    </div>
            
                                    <!-- Display the second image if it exists -->
                                    <img src="{{ asset('images/products/' . ($book->images->first()->path ?? 'default.jpg')) }}"
                                        class="product_img">
            
                                    <div class="content">
                                        <h2>{{ $book->name }}</h2> <!-- Assuming you want to display the book name -->
            
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
                                            <a href="/voirproduct/{{ $book->id}}" class="btn btn-explore">Explorer</a>
                                            <a  class="btn btn-add text-light add-to-cart"
                                                data-product-id="{{ $book->id }}"  data-is-pack="false">+ <i class="fa fa-shopping-bag"
                                                aria-hidden="true"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @php
                                $count += 1; // Increment count after each iteration
                            @endphp
                        @endforeach
            
            
            
                    </div>
                    <div class="btn-box">
                        <a href="{{ route('bandn') }}">
                            View All Products <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                   
                </div>
               
            </div>
        </div>
    </div>
</section>

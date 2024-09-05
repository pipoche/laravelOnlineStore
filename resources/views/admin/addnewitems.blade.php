
<!-- ADD CATEGORIE -->

<!-- End CATEGORIE -->


<!-- ADD PRODUCT -->


<!-- END PRODUCT -->


<!-- ADD PROMOTION -->

<div id="addpromotion" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="promotionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="promotionModalLabel">Add Promotion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="#" method="POST">
                    @csrf

                    <!-- Product ID with Searchable Select -->
                    <div class="form-group">
                        <label for="product_id">Product</label>
                        <select name="product_id" id="product_id" class="form-control @error('product_id') is-invalid @enderror" required>
                            <option value="" disabled selected>Select a product...</option>
                            <option value="1">product1</option>
                            <option value="2">product2</option>
                            <option value="3">product3</option>
                            <option value="4">product4</option>
                            <option value="5">product5</option>
                            <option value="6">product6</option>
                            <!-- Dynamically populate this select with products from the database -->
                            <!-- Example: -->
                            <!-- <option value="1">Product Name 1</option> -->
                            <!-- <option value="2">Product Name 2</option> -->
                        </select>

                        @error('product_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- New Price -->
                    <div class="form-group mt-3">
                        <label for="new_price">New Price</label>
                        <input type="number" name="new_price" id="new_price" step="0.01"
                            class="form-control @error('new_price') is-invalid @enderror" value="{{ old('new_price') }}"
                            required>

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

<!-- END PROMOTION -->


<!-- ADD PACK -->
<div class="modal fade" id="addpack" tabindex="-1" role="dialog" aria-labelledby="addPackLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPackLabel">Add New Pack</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="name">Pack Name</label>
                        <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                   

                    <div class="form-group mb-3">
                        <label for="image">Pack Image</label>
                        <input type="file" id="image" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*" required>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3 row">
                        <div class="col-md-6">
                            <label for="price">Price (MAD)</label>
                            <input type="text" id="price" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}" required>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="discount">Discount Percentage</label>
                            <div class="input-group">
                                <input type="number" id="discount" name="discount" class="form-control @error('discount') is-invalid @enderror" placeholder="25.00" min="0" max="100" required>
                                <span class="input-group-text">%</span>
                            </div>
                            @error('discount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Pack</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<!-- END PACK -->

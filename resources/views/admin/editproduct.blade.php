@extends('layouts.dashboard')

@section('dashboardcss')
    <style>
        .thumbnail-image {
            width: 60px;
            height: 60px;
            border: 1px solid #ddd;
            border-radius: 8px;
            cursor: pointer;
            background-size: cover;
            background-position: center;
            position: relative;
            margin-bottom: 10px;
        }

        .thumbnail-image .delete-button {
            position: absolute;
            top: 5px;
            right: 5px;
            background: rgba(255, 0, 0, 0.7);
            color: #fff;
            border: none;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .thumbnail-image .delete-button:hover {
            background: rgba(255, 0, 0, 0.9);
        }

        .image-preview {
            max-height: 400px;
            margin-bottom: 10px;
        }
    </style>
@endsection

@section('pagecontent')
    <div class="container">
        <h2>Edit Product</h2>
        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="nom">Product Name</label>
                <input type="text" name="nom" id="nom" class="form-control @error('nom') is-invalid @enderror"
                       value="{{ old('nom', $product->nom) }}" required>
                @error('nom')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group mt-3">
                <label for="description">Product Description</label>
                <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror"
                          rows="3" required>{{ old('description', $product->description) }}</textarea>
                @error('description')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group mt-3">
                <label for="id_category">Category</label>
                <select name="id_category" id="id_category"
                        class="form-control @error('id_category') is-invalid @enderror" required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ $product->id_category == $category->id ? 'selected' : '' }}>
                            {{ $category->nom }}
                        </option>
                    @endforeach
                </select>
                @error('id_category')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group mt-3">
                <label for="stock_quantity">Stock Quantity</label>
                <input type="number" name="stock_quantity" id="stock_quantity"
                       class="form-control @error('stock_quantity') is-invalid @enderror"
                       value="{{ old('stock_quantity', $product->stock->stockquantity ?? 0) }}" required min="0">
                @error('stock_quantity')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group mt-3">
                <label for="images">Product Images (Optional)</label>
                <input type="file" name="images[]" id="images" class="form-control @error('images') is-invalid @enderror" multiple>
                @error('images')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <!-- Hidden input to store IDs of images to be deleted -->
            <input type="hidden" name="images_to_delete" id="images_to_delete">

            <div class="form-group mt-3">
                <h4>Current Images</h4>
                <div class="d-flex flex-wrap">
                    @foreach($product->images as $image)
                        <div class="thumbnail-image" style="background-image: url('{{ asset('images/products/' . $image->path) }}');">
                            <button type="button" class="delete-button" data-image-id="{{ $image->id }}" onclick="markImageForDeletion({{ $image->id }})">X</button>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Update Product</button>
                <a href="{{ route('products') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
@endsection

@section('dashboardscripts')
    <script>
        let imagesToDelete = [];

        function markImageForDeletion(imageId) {
            // Add image ID to array if not already in it
            if (!imagesToDelete.includes(imageId)) {
                imagesToDelete.push(imageId);
            }

            // Update the hidden input with the array of IDs
            document.getElementById('images_to_delete').value = imagesToDelete.join(',');

            // Optionally, visually remove the image
            const thumbnail = document.querySelector(`button[data-image-id="${imageId}"]`).closest('.thumbnail-image');
            thumbnail.remove();
        }
    </script>
@endsection

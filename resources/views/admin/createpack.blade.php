@extends('layouts.dashboard')

@section('dashboardcss')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
@endsection

@section('pagecontent')
    <div class="container">
        <h2>Add New Pack</h2>

        <form action="{{ route('packs.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group p-3">
                <label for="name">Pack Name</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>

            <div class="form-group p-3">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control"></textarea>
            </div>

            <div class="form-group p-3">
                <label for="price">Pack Price</label>
                <input type="number" name="price" id="price" class="form-control" required>
            </div>

            <div class="form-group p-3">
                <label for="image">Image</label>
                <input type="file" name="image" id="image" class="form-control">
            </div>

            <div class="form-group p-3">
                <label for="products">Products</label>
                <select name="products[]" id="products" class="form-control select2" multiple>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}">{{ $product->nom }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-success">Add Pack</button>
            <a href="{{ route('packs') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection

@section('dashboardscripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
@endsection

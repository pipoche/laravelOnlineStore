@extends('layouts.dashboard')

@section('dashboardcss')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
@endsection

@section('pagecontent')
    <div class="container">
        <h2>Edit Promotion</h2>

        <form action="{{ route('promotions.update', $promotion->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group p-3">
                <label>Product</label>
                <p>{{ $product->nom }}</p>
            </div>

            <div class="form-group p-3">
                <label for="new_price">New Price</label>
                <input type="number" name="new_price" id="new_price" class="form-control" value="{{ $promotion->new_price }}" required>
            </div>

            <button type="submit" class="btn btn-success">Update Promotion</button>
            <a href="{{ route('admin.promotions') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection

@extends('layouts.dashboard')

@section('pagecontent')
<div class="container">
    <h1>Edit Category</h1>
    
    <!-- Flash Messages -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    
    <!-- Edit Category Form -->
    <form action="{{ route('categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="nom">Category Name</label>
            <input type="text" name="nom" id="nom"
                class="form-control @error('nom') is-invalid @enderror"
                value="{{ old('nom', $category->nom) }}" required>
            
            @error('nom')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group mt-3">
            <label for="picture">Category Image</label>
            @if($category->picture)
                <div class="mb-3">
                    <img src="{{ asset('images/categories/' . $category->picture) }}" alt="{{ $category->nom }}" style="width: 150px; height: auto;">
                </div>
            @endif
            <input type="file" name="picture" id="picture" class="form-control @error('picture') is-invalid @enderror">
            
            @error('picture')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Update Category</button>
            <a href="{{ route('categories') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection

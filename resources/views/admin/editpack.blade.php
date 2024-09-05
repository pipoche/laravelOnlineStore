@extends('layouts.dashboard')

@section('dashboardcss')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.1.5/css/fileinput.min.css">
@endsection

@section('pagecontent')
    <div class="container">
        <h2>Edit Pack</h2>
        <form action="{{ route('packs.update', $pack->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $pack->name) }}" required>
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control" rows="4" required>{{ old('description', $pack->description) }}</textarea>
                @error('description')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="price">Price (MAD)</label>
                <input type="number" name="price" id="price" class="form-control" value="{{ old('price', $pack->price) }}" step="0.01" required>
                @error('price')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="image">Pack Image</label>
                <input type="file" name="image" id="image" class="form-control-file">
                @if ($pack->image)
                    <img src="{{ asset('images/packs/' . $pack->image) }}" alt="Pack Image" class="mt-2" style="width: 150px; height: auto;">
                @endif
                @error('image')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Update Pack</button>
            <a href="{{ route('packs') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection

@section('dashboardscripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.1.5/js/fileinput.min.js"></script>
@endsection
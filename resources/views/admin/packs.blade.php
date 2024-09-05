@extends('layouts.dashboard')

@section('dashboardcss')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <style>
        .product-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 20px;
            padding: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .product-image {
            width: 100%;
            height: 200px;
            object-fit: contain;
            border-bottom: 1px solid #ddd;
        }
        .card-actions {
            margin-top: 10px;
        }
    </style>
@endsection

@section('pagecontent')
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="row align-items-center mb-3 mt-3">
            <div class="col-md-6">
                <h1>Packs List</h1>
            </div>
            <div class="col-md-6 text-end">
                <a href="{{ route('packs.create') }}" class="btn btn-primary">
                    Add New Pack
                </a>
            </div>
        </div>

        <div class="row">
            @foreach ($packs as $pack)
                <div class="col-md-3">
                    <div class="product-card">
                        <img src="{{ asset('images/packs/' . $pack->image) }}" alt="Pack Image" class="product-image">
                        <h5 class="mt-3">{{ $pack->name }}</h5>
                        <p>{{ $pack->description }}</p>
                        <h6>{{ number_format($pack->price, 2) }} MAD</h6>
                        <div class="card-actions">
                            <a href="{{ route('packs.view', $pack->id) }}" class="btn btn-sm btn-primary">View</a>
                            <a href="{{ route('packs.edit', $pack->id) }}" class="btn btn-sm btn-secondary">Edit</a>
                            <form action="{{ route('packs.destroy', $pack->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this pack?');">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

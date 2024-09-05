@extends('layouts.dashboard')
@section('dashboardcss')
    <style>
        /* Custom Pagination Styles */
        .pagination {
            justify-content: center;
            margin: 20px 0;
        }

        .pagination .page-item {
            margin: 0 2px;
        }

        .pagination .page-link {
            border-radius: 0.25rem;
            background-color: #f8f9fa;
            color: #007bff;
            border: 1px solid #dee2e6;
        }

        .pagination .page-link:hover {
            background-color: #e9ecef;
            color: #0056b3;
        }

        .pagination .page-item.active .page-link {
            background-color: #007bff;
            color: #ffffff;
            border-color: #007bff;
        }

        .pagination .page-item.disabled .page-link {
            color: #6c757d;
            pointer-events: none;
            background-color: #ffffff;
            border-color: #dee2e6;
        }

        /* Responsive Styling */
        @media (max-width: 576px) {
            .pagination {
                font-size: 0.8rem;
            }
        }

        /* Styles for the card header with image background */
        .card-header {
            background-size: contain;
            background-position: center;
            background-repeat: no-repeat;
            height: 150px;
            /* Adjust height as needed */
            border-bottom: 1px solid #dee2e6;
            /* Border to separate from card body */
            border-radius: 0.25rem 0.25rem 0 0;
            /* Rounded top corners */
        }

        /* Optional: Style for card body */
        .card-body {
            padding: 15px;
            background-color: #ffffff;
            /* Background color for readability */
        }

        /* Optional: Style for card title */
        .card-title {
            font-size: 1.2rem;
            margin-bottom: 1rem;
        }

        /* Responsive adjustments */
        @media (max-width: 576px) {
            .card-header {
                height: 100px;
                /* Adjust height for smaller screens */
            }
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
                <h1>Categories List</h1>
            </div>
            <div class="col-md-6 text-end">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addcategorie">
                    Add New Category
                </button>
            </div>
        </div>
        <!-- Search Form -->
        <div class="mb-3 search-container">
            <div class="input-group">
                <input type="text" id="search" class="form-control" placeholder="Search categories...">
                <div class="input-group-append">
                    <a href="{{ route('categories') }}" class="btn btn-outline-secondary">Clear</a>
                </div>
            </div>
        </div>

        <!-- Categories Cards -->
        <div id="categories-list" class="row">
            @foreach ($categories as $category)
                <div class="col-md-3 mb-4">
                    <div class="card">
                        <div class="p-2">

                            <div class="card-header"
                                style="background-image: url('{{ $category->picture ? asset('images/categories/' . $category->picture) : 'https://via.placeholder.com/150' }}');">

                            </div>
                            <!-- Image is styled as background in card-header -->
                        </div>
                        <div class="card-body d-flex flex-column justify-content-between">
                            <h5 class="card-title">{{ $category->nom }}</h5>
                            <div class="d-flex justify-content-between mt-2">
                                <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-info btn-sm">Edit</a>
                                <form action="{{ route('categories.destroy', $category->id) }}" method="POST"
                                    style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure you want to delete this category?');">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $categories->links('pagination::bootstrap-4', ['class' => 'pagination bg-light border rounded']) }}
        </div>



    </div>

    <!-- Add Category Modal -->
    <div id="addcategorie" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Add New Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="nom">Category Name</label>
                            <input type="text" name="nom" id="nom"
                                class="form-control @error('nom') is-invalid @enderror" value="{{ old('nom') }}"
                                required>

                            @error('nom')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group mt-3">
                            <label for="picture">Category Image</label>
                            <input type="file" name="picture" id="picture" class="form-control" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Create Category</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('dashboardscripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#search').on('keyup', function() {
                let search = $(this).val();
                $.ajax({
                    url: '{{ route('categories.search') }}',
                    method: 'GET',
                    data: {
                        search: search
                    },
                    success: function(response) {
                        $('#categories-list').html(response);
                    }
                });
            });
        });
    </script>
@endsection

@foreach ($categories as $category)
    <div class="col-md-3 mb-4">
        <div class="card">
            <div class="card-header" style="background-image: url('{{ $category->picture ? asset('images/categories/' . $category->picture) : 'https://via.placeholder.com/150' }}');">
                <!-- Image is styled as background in card-header -->
            </div>
            <div class="card-body d-flex flex-column justify-content-between">
                <h5 class="card-title">{{ $category->nom }}</h5>
                <div class="d-flex justify-content-between mt-2">
                    <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-info btn-sm">Edit</a>
                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display: inline;">
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



<!-- Pagination -->
<div class="d-flex justify-content-center mt-4">
    {{ $categories->links('pagination::bootstrap-4', ['class' => 'pagination bg-light border rounded']) }}
</div>

@extends('layouts.app')

@section('content')
<h2>Edit Category</h2>

<form action="{{ route('categories.update', $category->category_id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label>Category Name</label>
        <input type="text" name="category_name" class="form-control" value="{{ old('category_name', $category->category_name) }}" required>
        @error('category_name') <small class="text-danger">{{ $message }}</small> @enderror
    </div>
    <div class="mb-3">
        <label>Status</label>
        <select name="status" class="form-control" required>
            <option value="active" {{ $category->status == 'active' ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ $category->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
        </select>
        @error('status') <small class="text-danger">{{ $message }}</small> @enderror
    </div>
    <button class="btn btn-success">Update</button>
    <a href="{{ route('categories.index') }}" class="btn btn-secondary">Back</a>
</form>
@endsection
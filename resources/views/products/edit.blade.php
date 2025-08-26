@extends('layouts.app')

@section('content')
<h2>Edit Product</h2>

<form action="{{ route('products.update', $product->product_id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label>Product Name</label>
        <input type="text" name="product_name" class="form-control" value="{{ old('product_name', $product->product_name) }}" required>
        @error('product_name') <small class="text-danger">{{ $message }}</small> @enderror
    </div>
    <div class="mb-3">
        <label>Price</label>
        <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price', $product->price) }}" required>
        @error('price') <small class="text-danger">{{ $message }}</small> @enderror
    </div>
    <div class="mb-3">
        <label>Status</label>
        <select name="status" class="form-control" required>
            <option value="active" {{ $product->status == 'active' ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ $product->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
        </select>
        @error('status') <small class="text-danger">{{ $message }}</small> @enderror
    </div>
    <button class="btn btn-success">Update</button>
    <a href="{{ route('products.index') }}" class="btn btn-secondary">Back</a>
</form>
@endsection
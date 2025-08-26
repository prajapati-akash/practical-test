@extends('layouts.app')
@section('title','Dashboard')
@section('content')
<div class="card p-4">
  <h3>Welcome, {{ auth()->user()->user_name ?? 'Guest' }}</h3>
  <p>Your role: {{ auth()->user()->user_type ?? 'n/a' }}</p>
  <div class="mt-3">
    <a href="{{ route('categories.index') }}" class="btn btn-outline-primary">Categories</a>
    <a href="{{ route('products.index') }}" class="btn btn-outline-primary">Products</a>
    @if(auth()->check() && auth()->user()->isAdmin())
      <a href="{{ route('users.index') }}" class="btn btn-outline-success">Manage Users</a>
    @endif
  </div>
</div>
@endsection
@extends('layouts.app')
@section('title','Login')
@section('content')
<div class="row justify-content-center">
  <div class="col-md-6">
    <div class="card p-4">
      <h3>Login</h3>
      <form action="{{ route('login.post') }}" method="POST">
        @csrf
        <div class="mb-3">
          <label class="form-label">Email</label>
          <input name="user_email" value="{{ old('user_email') }}" class="form-control" />
        </div>
        <div class="mb-3">
          <label class="form-label">Password</label>
          <input name="password" type="password" class="form-control" />
        </div>
        <div class="mb-3 form-check">
          <input type="checkbox" name="remember" class="form-check-input" id="remember">
          <label class="form-check-label" for="remember">Remember me</label>
        </div>
        <button class="btn btn-primary">Login</button>
      </form>
    </div>
  </div>
</div>
@endsection
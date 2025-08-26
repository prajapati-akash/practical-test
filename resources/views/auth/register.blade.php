@extends('layouts.app')
@section('title','Register')
@section('content')
<div class="row justify-content-center">
  <div class="col-md-6">
    <div class="card p-4">
      <h3>Register</h3>
      <form action="{{ route('register.post') }}" method="POST">
        @csrf
        <div class="mb-3">
          <label class="form-label">Name</label>
          <input name="user_name" value="{{ old('user_name') }}" class="form-control" />
        </div>
        <div class="mb-3">
          <label class="form-label">Email</label>
          <input name="user_email" value="{{ old('user_email') }}" class="form-control" />
        </div>
        <div class="mb-3">
          <label class="form-label">Mobile</label>
          <input name="user_mobile_no" value="{{ old('user_mobile_no') }}" class="form-control" />
        </div>
        <div class="mb-3">
          <label class="form-label">Password</label>
          <input name="password" type="password" class="form-control" />
        </div>
        <div class="mb-3">
          <label class="form-label">Confirm Password</label>
          <input name="password_confirmation" type="password" class="form-control" />
        </div>
        <div class="mb-3">
          <label class="form-label">Type</label>
          <select name="user_type" class="form-select">
            <option value="user">User</option>
            <option value="employee">Employee</option>
            <option value="sub_user">Sub User</option>
            <option value="admin">Admin</option>
          </select>
        </div>
        <button class="btn btn-primary">Register</button>
      </form>
    </div>
  </div>
</div>
@endsection
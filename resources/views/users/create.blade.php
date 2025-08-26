@extends('layouts.app')
@section('title','Create User')
@section('content')
<div class="col-md-8">
  <div class="card p-4">
    <h4>Create User</h4>
    <form action="{{ route('users.store') }}" method="POST">
      @csrf
      <div class="mb-3">
        <label>Name</label>
        <input name="user_name" value="{{ old('user_name') }}" class="form-control"/>
      </div>
      <div class="mb-3">
        <label>Email</label>
        <input name="user_email" value="{{ old('user_email') }}" class="form-control"/>
      </div>
      <div class="mb-3">
        <label>Mobile</label>
        <input name="user_mobile_no" value="{{ old('user_mobile_no') }}" class="form-control"/>
      </div>
      <div class="mb-3">
        <label>Password</label>
        <input name="password" type="password" class="form-control"/>
      </div>
      <div class="mb-3">
        <label>Confirm Password</label>
        <input name="password_confirmation" type="password" class="form-control"/>
      </div>
      <div class="mb-3">
        <label>Type</label>
        <select name="user_type" class="form-select">
          <option value="user">User</option>
          <option value="employee">Employee</option>
          <option value="sub_user">Sub User</option>
          <option value="admin">Admin</option>
        </select>
      </div>
      <button class="btn btn-primary">Save</button>
    </form>
  </div>
</div>
@endsection
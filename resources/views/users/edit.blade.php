@extends('layouts.app')
@section('title','Edit User')
@section('content')
<div class="col-md-8">
  <div class="card p-4">
    <h4>Edit User</h4>
    <form action="{{ route('users.update', $user->user_id) }}" method="POST">
      @csrf @method('PUT')
      <div class="mb-3">
        <label>Name</label>
        <input name="user_name" value="{{ old('user_name',$user->user_name) }}" class="form-control"/>
      </div>
      <div class="mb-3">
        <label>Email</label>
        <input name="user_email" value="{{ old('user_email',$user->user_email) }}" class="form-control"/>
      </div>
      <div class="mb-3">
        <label>Mobile</label>
        <input name="user_mobile_no" value="{{ old('user_mobile_no',$user->user_mobile_no) }}" class="form-control"/>
      </div>
      <div class="mb-3">
        <label>Password (leave blank to keep current)</label>
        <input name="password" type="password" class="form-control"/>
      </div>
      <div class="mb-3">
        <label>Confirm Password</label>
        <input name="password_confirmation" type="password" class="form-control"/>
      </div>
      <div class="mb-3">
        <label>Type</label>
        <select name="user_type" class="form-select">
          <option value="user" {{ $user->user_type=='user' ? 'selected' : '' }}>User</option>
          <option value="employee" {{ $user->user_type=='employee' ? 'selected' : '' }}>Employee</option>
          <option value="sub_user" {{ $user->user_type=='sub_user' ? 'selected' : '' }}>Sub User</option>
          <option value="admin" {{ $user->user_type=='admin' ? 'selected' : '' }}>Admin</option>
        </select>
      </div>
      <div class="mb-3">
        <label>Status</label>
        <select name="user_status" class="form-select">
          <option value="inactive" {{ $user->user_status=='inactive' ? 'selected': '' }}>Inactive</option>
          <option value="active" {{ $user->user_status=='active' ? 'selected': '' }}>Active</option>
          <option value="blocked" {{ $user->user_status=='blocked' ? 'selected': '' }}>Blocked</option>
        </select>
      </div>
      <button class="btn btn-primary">Update</button>
    </form>
  </div>
</div>
@endsection
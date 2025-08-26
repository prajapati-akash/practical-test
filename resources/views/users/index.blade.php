@extends('layouts.app')
@section('title','Users')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3>Users</h3>
  <a href="{{ route('users.create') }}" class="btn btn-success">Add User</a>
</div>

<table class="table table-bordered">
  <thead>
    <tr>
      <th>#</th>
      <th>Name</th>
      <th>Email</th>
      <th>Mobile</th>
      <th>Type</th>
      <th>Status</th>
      <th>Created</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    @foreach($users as $user)
    <tr>
      <td>{{ $user->user_id }}</td>
      <td>{{ $user->user_name }}</td>
      <td>{{ $user->user_email }}</td>
      <td>{{ $user->user_mobile_no }}</td>
      <td>{{ $user->user_type }}</td>
      <td>{{ $user->user_status }}</td>
      <td>{{ $user->created_at->format('Y-m-d') }}</td>
      <td>
        <a href="{{ route('users.edit', $user->user_id) }}" class="btn btn-sm btn-primary">Edit</a>
        <form action="{{ route('users.destroy', $user->user_id) }}" method="POST" style="display:inline">
          @csrf @method('DELETE')
          <button class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</button>
        </form>
        <form action="{{ route('users.toggleStatus', $user->user_id) }}" method="POST" style="display:inline">
          @csrf
          <button class="btn btn-sm btn-warning">{{ $user->user_status === 'blocked' ? 'Unblock' : 'Block' }}</button>
        </form>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>

{{ $users->links() }}
@endsection
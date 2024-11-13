@extends('layout.app')

@section('title', 'User Institute Setting')

@section('page-title', 'User Institute Setting')

@section('content')
    <h1>Edit User Institute Information</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('user.institute.update') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>

        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" class="form-control" value="{{ old('username', $user->username) }}" required>
        </div>

        <div class="form-group">
            <label for="password">New Password</label>
            <input type="password" id="password" name="password" class="form-control">
            <small class="form-text text-muted">Leave blank if you don't want to change the password.</small>
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
@endsection
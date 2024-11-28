@extends('layouts.app')

@section('title', 'Add Institute')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Add Institute</h1>

    <!-- Display validation errors -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form to add an institute -->
    <form action="{{ route('institute.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Institute Name</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Enter institute name" required>
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <textarea class="form-control" id="address" name="address" rows="3" placeholder="Enter address" required></textarea>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter phone number" required>
        </div>

        <button type="submit" class="btn btn-primary">Add Institute</button>
        <a href="{{ route('institute.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection

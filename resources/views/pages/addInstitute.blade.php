@extends('layout.app')

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

        <form id="addInstituteForm" method="POST">
            @csrf
            <div class="mb-3">
                <label for="npsn" class="form-label">NPSN</label>
                <input type="text" class="form-control" id="npsn" name="npsn" value="{{ old('npsn') }}"
                    placeholder="Enter NPSN" required>
            </div>

            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}"
                    placeholder="Enter institute name" required>
            </div>

            <div class="mb-3">
                <label for="status-institute" class="form-label">Status</label>
                <input type="text" class="form-control" id="status-institute" name="status" value="{{ old('status') }}"
                    placeholder="Enter status" required>
            </div>

            <div class="mb-3">
                <label for="educational_level" class="form-label">Educational Level</label>
                <input type="text" class="form-control" id="educational_level" name="educational_level"
                    value="{{ old('educational_level') }}" placeholder="Enter level" required style="display: block;">
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <textarea class="form-control" id="address" name="address" rows="3" placeholder="Enter address" required>{{ old('address') }}</textarea>
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}"
                    placeholder="Enter phone number" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}"
                    placeholder="Enter email" required>
            </div>

            <div class="mb-3">
                <label for="account_number" class="form-label">Account Number (Optional)</label>
                <input type="text" class="form-control" id="account_number" name="account_number"
                    value="{{ old('account_number') }}" placeholder="Enter account number">
            </div>

            <button type="submit" class="btn btn-primary">Add Institute</button>
            <a href="{{ route('institutions.index') }}" class="btn btn-secondary">Cancel</a>
        </form>

    </div>

    <script>
        document.getElementById('addInstituteForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission

            // Collect data from the form
            const formData = {
                npsn: document.getElementById('npsn').value,
                name: document.getElementById('name').value,
                status: document.getElementById('status-institute').value,
                educational_level: document.getElementById('educational_level').value,
                address: document.getElementById('address').value,
                phone: document.getElementById('phone').value,
                email: document.getElementById('email').value,
                account_number: document.getElementById('account_number').value,
            };

            // Get CSRF token from the meta tag
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Make API call
            fetch('http://localhost:8000/api/institutions', {
                    mode: 'no-cors',
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken, // Use the CSRF token from the meta tag
                    },
                    body: JSON.stringify(formData),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.message === 'Institute created successfully') {
                        // Redirect to instituteList page
                        window.location.href = '/pages/instituteList';
                    } else {
                        console.error('Failed to create institute:', data);
                        alert('Failed to add institute. Please try again.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred. Please try again.');
                });
        });
    </script>
@endsection

@extends('layout.app')

@section('title', 'Add New Student')

@section('page-title', 'Add New Student')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">Add New Student</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <!-- Add New Student Form -->
                    <form id="addStudentForm">
                        @csrf
                        <div class="row">
                            <!-- Student ID (NIM) -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="student_id">Student ID (NIM)</label>
                                    <input type="text" id="student_id" name="student_id" class="form-control" required>
                                </div>
                            </div>

                            <!-- Name -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" id="name" name="name" class="form-control" required>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" id="email" name="email" class="form-control" required>
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" id="password" name="password" class="form-control" required>
                                </div>
                            </div>

                            <!-- Phone -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone">Phone</label>
                                    <input type="text" id="phone" name="phone" class="form-control" required>
                                </div>
                            </div>

                            <!-- Year -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="year">Year</label>
                                    <input type="number" id="year" name="year" class="form-control" required>
                                </div>
                            </div>

                            <!-- Major -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="major">Major</label>
                                    <input type="text" id="major" name="major" class="form-control" required>
                                </div>
                            </div>

                            <!-- Gender -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="gender">Gender</label>
                                    <select id="gender" name="gender" class="form-control" required>
                                        <option value="">Select Gender</option>
                                        <option value="Pria">Pria</option>
                                        <option value="Wanita">Wanita</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Institution -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="institution">Institution</label>
                                    <select id="institution" name="institution_id" class="form-control" required>
                                        <option value="">Select Institution</option>
                                        @foreach ($institutions as $institution)
                                            <option value="{{ $institution->id }}">{{ $institution->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12 text-right">
                                <button type="submit" class="btn btn-primary">Save Student</button>
                            </div>

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        console.log('Script Loaded')
        // Handle form submission with AJAX
        document.getElementById('addStudentForm').addEventListener('submit', function(e) {
            e.preventDefault();
            console.log('Form submission triggered');

            // Create FormData from the form
            let formData = new FormData(this);

            // Make the AJAX POST request
            fetch('/api/students', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': 'Bearer ' + localStorage.getItem('token') // Use token if necessary
                    },
                    body: formData
                }).then(response => {
                    console.log('Response:', response); // Log the response
                    return response.json();
                })
                .then(data => {
                    console.log('Data:', data);
                    // Check for success message
                    if (data.message) {
                        alert(data.message); // Show success message
                        window.location.href = '/studentList'; // Redirect to students list
                    } else {
                        // If no message, display a general error message
                        alert('Failed to create student');
                    }
                })
                .catch(error => {
                    // Handle any AJAX errors (e.g., network issues)
                    alert('Error: ' + error.message);
                });
        });
    </script>
@endsection

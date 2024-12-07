@extends('layout.app')

@section('title', 'Student Profile')

@section('content')
    <div class="container mt-5" id="student-profile">
        <!-- Breadcrumbs -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/studentList') }}">Students List</a></li>
                <li class="breadcrumb-item active" aria-current="page">Student Profile</li>
            </ol>
        </nav>

        <!-- Back Button -->
        <a href="{{ url('/studentList') }}" class="btn btn-secondary mb-3">Back to List</a>

        <!-- Loading State -->
        <div class="text-center" id="loading-state">
            <h1>Loading...</h1>
        </div>

        <!-- Profile Content (Initially Hidden) -->
        <div id="profile-content" class="d-none">
            <div class="row">
                <div class="col-md-8">
                    <!-- Student Details -->
                    <form id="student-form">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="student-name-input" disabled>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="student-email" disabled>
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="student-phone" disabled>
                        </div>

                        <div class="mb-3">
                            <label for="year" class="form-label">Year</label>
                            <input type="text" class="form-control" id="student-year" disabled>
                        </div>

                        <div class="mb-3">
                            <label for="major" class="form-label">Major</label>
                            <input type="text" class="form-control" id="student-major" disabled>
                        </div>

                        <div class="mb-3">
                            <label for="gender" class="form-label">Gender</label>
                            <input type="text" class="form-control" id="student-gender" disabled>
                        </div>

                        <div class="mb-3">
                            <label for="institution" class="form-label">Institution</label>
                            <select class="form-control" id="student-institution" disabled>
                                <!-- Options will be populated dynamically -->
                            </select>
                        </div>

                    </form>
                </div>

                <!-- Actions -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5>Actions</h5>
                            <button id="edit-button" class="btn btn-warning mb-2">Edit</button>
                            <button id="save-button" class="btn btn-success mb-2 d-none">Save</button>
                            <a href="#" id="delete-button" class="btn btn-danger mb-2">Delete</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Fetch the student ID from the Blade variable
        const studentId = @json($id);

        // Fetch the student profile when the page loads
        function loadProfile(id) {
            fetch(`http://localhost:8000/api/students/${id}`)
                .then(response => response.json())
                .then(student => {
                    // Hide loading state and show profile content
                    document.getElementById('loading-state').classList.add('d-none');
                    document.getElementById('profile-content').classList.remove('d-none');

                    // Populate fields
                    document.getElementById('student-name-input').value = student.name;
                    document.getElementById('student-email').value = student.email;
                    document.getElementById('student-phone').value = student.phone;
                    document.getElementById('student-year').value = student.year;
                    document.getElementById('student-major').value = student.major;
                    document.getElementById('student-gender').value = student.gender;

                    // Fetch institutions and populate the dropdown
                    fetch(`http://localhost:8000/api/institutions`)
                        .then(response => response.json())
                        .then(institutions => {
                            const institutionDropdown = document.getElementById('student-institution');
                            institutionDropdown.innerHTML = institutions.map(inst => `
                        <option value="${inst.id}" ${inst.id === student.institution_id ? 'selected' : ''}>
                            ${inst.name}
                        </option>
                    `).join('');
                        });

                    // Set up edit and save functionality
                    setupActions(id);
                })
                .catch(error => {
                    console.error('Error fetching profile:', error);
                    alert('Failed to load student profile.');
                });
        }


        // Set up edit and save functionality
        function setupActions(id) {
            const editButton = document.getElementById('edit-button');
            const saveButton = document.getElementById('save-button');
            const formElements = document.querySelectorAll(
                '#student-form input, #student-form textarea, #student-form select');

            // Enable fields for editing when 'Edit' button is clicked
            editButton.addEventListener('click', function() {
                formElements.forEach(element => element.removeAttribute('disabled')); // Re-enable the fields
                editButton.classList.add('d-none');
                saveButton.classList.remove('d-none');
            });

            // Handle saving the edited data
            saveButton.addEventListener('click', function() {
                const formData = new FormData(document.getElementById('student-form'));
                const data = Object.fromEntries(formData);

                // Add student name to the updated data
                data.name = document.getElementById('student-name-input').value;
                // Ensure that the selected institution_id is included
                data.institution_id = document.getElementById('student-institution').value;

                fetch(`http://localhost:8000/api/students/${id}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(data),
                    })
                    .then(response => response.json())
                    .then(updatedData => {
                        alert('Student updated successfully!');
                        loadProfile(id); // Reload the profile with updated data

                        // Disable all fields and reset the form for non-editable state
                        formElements.forEach(element => {
                            element.setAttribute('disabled', true); // Disable the input fields
                        });

                        // Hide save button and show the edit button
                        saveButton.classList.add('d-none');
                        editButton.classList.remove('d-none');
                    })
                    .catch(error => {
                        console.error('Error saving student:', error);
                        alert('Failed to save student.');
                    });
            });

            // Set up delete button
            const deleteButton = document.getElementById('delete-button');
            deleteButton.addEventListener('click', function(event) {
                event.preventDefault();
                deleteStudent(id);
            });
        }

        // Function to delete the student
        function deleteStudent(id) {
            if (confirm('Are you sure you want to delete this student?')) {
                fetch(`http://localhost:8000/api/students/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                    })
                    .then(response => {
                        if (response.ok) {
                            alert('Student deleted successfully');
                            window.location.href = '/studentList'; // Redirect to the student list page
                        } else {
                            alert('Failed to delete the student');
                        }
                    })
                    .catch(error => {
                        console.error('Error deleting student:', error);
                        alert('Failed to delete student.');
                    });
            }
        }

        // Call the function when the page loads
        document.addEventListener("DOMContentLoaded", function() {
            loadProfile(studentId);
        });
    </script>
@endsection

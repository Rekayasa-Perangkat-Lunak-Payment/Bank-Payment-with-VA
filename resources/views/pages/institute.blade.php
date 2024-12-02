@extends('layout.app')

@section('title', 'Institution Profile')

@section('content')
    <div class="container mt-5" id="institution-profile">
        <!-- Loading State -->
        <div class="text-center" id="loading-state">
            <h1>Loading...</h1>
        </div>

        <!-- Profile Content (Initially Hidden) -->
        <div id="profile-content" class="d-none">
            <div class="row">
                <div class="col-md-8">
                    <!-- Institution Details -->
                    <h2 id="institution-name"></h2>
                    <form id="institution-form">
                        <div class="mb-3">
                            <label for="name" class="form-label">Institution Name</label>
                            <input type="text" class="form-control" id="institution-name-input" disabled>
                        </div>

                        <div class="mb-3">
                            <label for="npsn" class="form-label">NPSN</label>
                            <input type="text" class="form-control" id="institution-npsn" disabled>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <input type="text" class="form-control" id="institution-status" disabled>
                        </div>

                        <div class="mb-3">
                            <label for="educational-level" class="form-label">Educational Level</label>
                            <input type="text" class="form-control" id="institution-educational-level" disabled>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea class="form-control" id="institution-address" rows="3" disabled></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="institution-phone" disabled>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="institution-email" disabled>
                        </div>

                        <div class="mb-3">
                            <label for="account-number" class="form-label">Account Number</label>
                            <input type="text" class="form-control" id="institution-account-number" disabled>
                        </div>
                    </form>
                </div>

                <!-- Actions and Counts -->
                <div class="col-md-4">
                    <!-- Cards for Admin and Student Count -->
                    <div class="card mb-3">
                        <div class="card-body text-center">
                            <h5 class="card-title">Admins Count</h5>
                            <p class="display-4" id="admins-count">0</p>
                        </div>
                    </div>

                    <div class="card mb-3">
                        <div class="card-body text-center">
                            <h5 class="card-title">Students Count</h5>
                            <p class="display-4" id="students-count">0</p>
                        </div>
                    </div>

                    <!-- Edit and Save Actions -->
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
        // Fetch the institution ID from the URL or Blade view
        const institutionId = @json($id);

        // Fetch the institution profile when the page loads
        function loadProfile(id) {
            fetch(`http://localhost:8000/api/institutions/${id}`)
                .then(response => response.json())
                .then(data => {
                    console.log('Fetched data:', data); // Check the API response

                    // Show profile content and hide loading state
                    document.getElementById('loading-state').classList.add('d-none');
                    document.getElementById('profile-content').classList.remove('d-none');

                    // Populate the profile fields
                    document.getElementById('institution-name').textContent = data.name;
                    document.getElementById('institution-name-input').value = data.name; // Set name in editable input
                    document.getElementById('institution-npsn').value = data.npsn;
                    document.getElementById('institution-status').value = data.status;
                    document.getElementById('institution-educational-level').value = data.educational_level;
                    document.getElementById('institution-address').value = data.address;
                    document.getElementById('institution-phone').value = data.phone;
                    document.getElementById('institution-email').value = data.email;
                    document.getElementById('institution-account-number').value = data.account_number;

                    // Populate admin and student count
                    document.getElementById('admins-count').textContent = data.admins_count;
                    document.getElementById('students-count').textContent = data.students_count;

                    // Set up actions (Edit, Save, Delete)
                    setupActions(id);
                })
                .catch(error => {
                    console.error('Error fetching profile:', error);
                    alert('Failed to load institution profile.');
                });
        }

        // Set up edit and save functionality
        function setupActions(id) {
            const editButton = document.getElementById('edit-button');
            const saveButton = document.getElementById('save-button');
            const formElements = document.querySelectorAll('#institution-form input, #institution-form textarea');
            
            // Enable fields for editing when 'Edit' button is clicked
            editButton.addEventListener('click', function () {
                formElements.forEach(element => element.removeAttribute('disabled'));
                editButton.classList.add('d-none');
                saveButton.classList.remove('d-none');
            });

            // Handle saving the edited data
            saveButton.addEventListener('click', function () {
                const formData = new FormData(document.getElementById('institution-form'));
                const data = Object.fromEntries(formData);

                // Add institution name to the updated data
                data.name = document.getElementById('institution-name-input').value;

                fetch(`http://localhost:8000/api/institutions/${id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        //'Authorization': 'Bearer YOUR_API_TOKEN', // If authentication is required
                    },
                    body: JSON.stringify(data),
                })
                    .then(response => response.json())
                    .then(updatedData => {
                        alert('Institution updated successfully!');
                        loadProfile(id); // Reload the profile with updated data
                    })
                    .catch(error => {
                        console.error('Error saving institution:', error);
                        alert('Failed to save institution.');
                    });
            });

            // Set up delete button
            const deleteButton = document.getElementById('delete-button');
            deleteButton.addEventListener('click', function (event) {
                event.preventDefault();
                deleteInstitution(id);
            });
        }

        // Function to delete the institution
        function deleteInstitution(id) {
            if (confirm('Are you sure you want to delete this institution?')) {
                fetch(`http://localhost:8000/api/institutions/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': 'Bearer YOUR_API_TOKEN', // If authentication is required
                    },
                })
                    .then(response => {
                        if (response.ok) {
                            alert('Institution deleted successfully');
                            window.location.href = '/instituteList'; // Redirect to the institution list page
                        } else {
                            alert('Failed to delete the institution');
                        }
                    })
                    .catch(error => {
                        console.error('Error deleting institution:', error);
                        alert('Failed to delete institution.');
                    });
            }
        }

        // Call the function when the page loads
        document.addEventListener("DOMContentLoaded", function () {
            loadProfile(institutionId);
        });
    </script>
@endsection

@extends('layout.app')

@section('title', 'Add New User Institute')

@section('content')
    <div class="container">
        <div class="card mb-4">
            <div class="card-header">
                <h4>Create New Admin for Institution</h4>
            </div>
            <div class="card-body">
                <form id="addInstitutionAdminForm">
                    @csrf

                    <h5 class="mb-3">User Information</h5>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" name="username" id="username" class="form-control"
                            placeholder="Enter username" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="Enter email"
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" id="password" class="form-control"
                            placeholder="Enter password" required>
                    </div>

                    <hr>

                    <h5 class="mb-3">Institution Admin Information</h5>
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Enter name"
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" name="title" id="title" class="form-control"
                            placeholder="Enter title (e.g., Manager)" required>
                    </div>

                    <div class="mb-3">
                        <label for="institution" class="form-label">Institution</label>
                        <select name="institution_id" id="institution" class="form-control" required>
                            <option value="" disabled selected>Select an Institution</option>
                        </select>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const institutionSelect = document.getElementById('institution');

            // Display "Loading..." in the dropdown until the data is fetched
            const loader = document.createElement('option');
            loader.textContent = 'Loading...';
            institutionSelect.appendChild(loader);

            // Fetch institution data
            fetch('/api/institutions')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to fetch institutions');
                    }
                    return response.json();
                })
                .then(data => {
                    institutionSelect.innerHTML = ''; // Clear loading text

                    // Default placeholder option
                    const defaultOption = document.createElement('option');
                    defaultOption.value = "";
                    defaultOption.disabled = true;
                    defaultOption.selected = true;
                    defaultOption.textContent = 'Select an Institution';
                    institutionSelect.appendChild(defaultOption);

                    // Populate institution options
                    data.forEach(institution => {
                        const option = document.createElement('option');
                        option.value = institution.id;
                        option.textContent = institution.name;
                        institutionSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Error fetching institutions:', error);
                });

            // Handle form submission via AJAX
            const form = document.getElementById('addInstitutionAdminForm');
            form.addEventListener('submit', function(e) {
                e.preventDefault(); // Prevent form from submitting the default way

                const formData = new FormData(form);

                // Make POST request to API
                fetch('/api/userInstitutions', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({
                            user: {
                                email: document.getElementById('email').value,
                                password: document.getElementById('password').value,
                                username: document.getElementById('username').value,
                            },
                            name: document.getElementById('name').value,
                            title: document.getElementById('title').value || null,
                            institution_id: document.getElementById('institution').value,
                        }),
                    })
                    .then(response => {
                        console.log('Response Status:', response.status); // Log response status
                        if (!response.ok) throw response;
                        return response.json();
                    })

                    .then(data => {
                        if (data.message) {
                            alert('Institution Admin created successfully');
                            window.location.href =
                                '/userInstituteList'; // Redirect to the institution admin list page
                        } else {
                            alert('Failed to create Institution Admin');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while submitting the form');
                    });
            });
        });
    </script>
@endsection

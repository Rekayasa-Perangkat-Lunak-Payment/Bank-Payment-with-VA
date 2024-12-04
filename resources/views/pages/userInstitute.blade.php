@extends('layout.app')
@section('content')
    <div class="container">
        <div class="row">
            <!-- Left Column -->
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header text-center">
                        <h5 class="mb-0">User Options</h5>
                    </div>
                    <div class="card-body text-center">
                        <img src="{{ asset('default-avatar.png') }}" alt="User Avatar" class="img-fluid rounded-circle mb-3"
                            width="100">
                        <h5>{{ $userInstitute['name'] }}</h5>
                        <p class="text-muted">{{ $userInstitute['title'] ?? 'N/A' }}</p>
                        <div class="d-grid gap-2">
                            <button id="disable-btn" class="btn btn-danger btn-sm"
                                onclick="disableUser({{ $userInstitute['id'] }})">
                                Disable Account
                            </button>

                            <div id="password-section" style="display: none;">
                                <input type="password" id="new-password" class="form-control mb-2"
                                    placeholder="Enter new password">
                                <button class="btn btn-success btn-sm"
                                    onclick="updatePassword({{ $userInstitute['id'] }})">
                                    Save Password
                                </button>
                            </div>
                            <button id="change-password-btn" class="btn btn-warning btn-sm" onclick="showPasswordSection()">
                                Change Password
                            </button>

                            <button class="btn btn-primary btn-sm" id="edit-btn" onclick="toggleEditMode(true)">
                                Edit Information
                            </button>
                            <button class="btn btn-success btn-sm d-none" id="save-btn"
                                onclick="saveChanges({{ $userInstitute['id'] }})">
                                Save Changes
                            </button>
                            <button class="btn btn-secondary btn-sm d-none" id="cancel-btn" onclick="toggleEditMode(false)">
                                Cancel
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h4>User Information</h4>
                    </div>
                    <div class="card-body">
                        <form id="user-info-form">
                            <table class="table">
                                <tr>
                                    <th>Name</th>
                                    <td>
                                        <span id="name-text">{{ $userInstitute['name'] }}</span>
                                        <input type="text" id="name-input" class="form-control d-none"
                                            value="{{ $userInstitute['name'] }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>Position</th>
                                    <td>
                                        <span id="title-text">{{ $userInstitute['title'] ?? 'N/A' }}</span>
                                        <input type="text" id="title-input" class="form-control d-none"
                                            value="{{ $userInstitute['title'] }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>Institution</th>
                                    <td>
                                        <span id="institution-text">{{ $userInstitute['institution']['name'] }}</span>
                                        <select id="institution-input" class="form-select d-none">
                                            <!-- Options will be populated dynamically -->
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>
                                        <span id="email-text">{{ $userInstitute['user']['email'] }}</span>
                                        <input type="email" id="email-input" class="form-control d-none"
                                            value="{{ $userInstitute['user']['email'] }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>Username</th>
                                    <td>
                                        <span id="username-text">{{ $userInstitute['user']['username'] }}</span>
                                        <input type="text" id="username-input" class="form-control d-none"
                                            value="{{ $userInstitute['user']['username'] }}">
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            populateInstitutionDropdown();

            function populateInstitutionDropdown() {
                fetch('/api/institutions', {
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        const institutionDropdown = document.getElementById('institution-input');
                        institutionDropdown.innerHTML = ''; // Clear existing options

                        // Populate dropdown with institutions
                        data.forEach(institution => {
                            const option = document.createElement('option');
                            option.value = institution.id;
                            option.textContent = institution.name;

                            // Select current institution by default
                            if (institution.name === document.getElementById('institution-text')
                                .innerText) {
                                option.selected = true;
                            }
                            institutionDropdown.appendChild(option);
                        });
                    })
                    .catch(error => {
                        console.error('Error fetching institutions:', error);
                        alert("Failed to load institutions. Please try again.");
                    });
            }
        });

        function toggleEditMode(isEdit) {
            // Toggle visibility of text and input fields
            document.querySelectorAll('span[id$="-text"]').forEach(span => span.classList.toggle('d-none', isEdit));
            document.querySelectorAll('input[id$="-input"]').forEach(input => input.classList.toggle('d-none', !isEdit));

            // Specifically toggle the institution dropdown visibility
            document.getElementById('institution-input').classList.toggle('d-none', !isEdit);

            // Enable/Disable buttons
            document.getElementById('edit-btn').classList.toggle('d-none', isEdit);
            document.getElementById('save-btn').classList.toggle('d-none', !isEdit);
            document.getElementById('cancel-btn').classList.toggle('d-none', !isEdit);

            // Disable/Enable other options
            document.getElementById('disable-btn').disabled = isEdit;
            document.getElementById('change-password-btn').disabled = isEdit;

            // Reset input fields if canceled
            if (!isEdit) {
                document.getElementById('name-input').value = document.getElementById('name-text').innerText;
                document.getElementById('title-input').value = document.getElementById('title-text').innerText;
                document.getElementById('institution-input').value = document.getElementById('institution-text').innerText;
                document.getElementById('email-input').value = document.getElementById('email-text').innerText;
                document.getElementById('username-input').value = document.getElementById('username-text').innerText;
            }
        }

        function saveChanges(userId) {
            const formData = {
                name: document.getElementById('name-input').value,
                title: document.getElementById('title-input').value,
                institution_id: document.getElementById('institution-input').value,
                user: {
                    username: document.getElementById('username-input').value,
                    email: document.getElementById('email-input').value,
                }
            };
            // console.log(formData);
            fetch(`/api/userInstitutions/${userId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify(formData)
                })
                .then(response => {
                    if (!response.ok) {
                        return response.text().then(text => {
                            throw new Error(text)
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    alert("User information has been updated.");
                    location.reload(); // Reload to reflect updated data
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert(`An error occurred: ${error.message}`);
                });


        }


        function disableUser(userId) {
            if (confirm("Are you sure you want to disable this user?")) {
                fetch(`/api/userInstitutions/${userId}/disable`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                    })
                    .then(response => {
                        if (response.ok) {
                            alert("User has been disabled. With ID: " + userId);
                            location.reload();
                        } else {
                            alert("Failed to disable user. Please try again.");
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert("An error occurred. Please try again.");
                    });
            }
        }

        function showPasswordSection() {
            document.getElementById('password-section').style.display = 'block';
        }

        function updatePassword(userId) {
            const newPassword = document.getElementById('new-password').value;

            if (!newPassword) {
                alert("Please enter a new password.");
                return;
            }

            fetch(`/api/userInstitutions/${userId}/password`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        password: newPassword
                    })
                })
                .then(response => {
                    if (response.ok) {
                        alert("Password has been updated.");
                        document.getElementById('password-section').style.display = 'none';
                    } else {
                        alert("Failed to update password. Please try again.");
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert("An error occurred. Please try again.");
                });
        }
    </script>
@endsection

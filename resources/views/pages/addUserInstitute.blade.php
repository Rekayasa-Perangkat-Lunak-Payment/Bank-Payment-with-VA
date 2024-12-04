@extends('layout.app')

@section('title', 'Add New Student')

@section('content')
    <div class="container">
        <div class="card mb-4">
            <div class="card-header">
                <h4>Tambah Mahasiswa</h4>
            </div>
            <div class="card-body">
                <form id="addStudentForm">
                    @csrf
                    <div class="mb-3">
                        <label for="student_id" class="form-label">Student ID (NIM)</label>
                        <input type="text" name="student_id" id="student_id" class="form-control" placeholder="Masukkan NIM" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Masukkan nama" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="Masukkan email" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password" required>
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" name="phone" id="phone" class="form-control" placeholder="Masukkan phone" required>
                    </div>

                    <div class="mb-3">
                        <label for="year" class="form-label">Year</label>
                        <input type="number" name="year" id="year" class="form-control" placeholder="Masukkan year" required>
                    </div>

                    <div class="mb-3">
                        <label for="major" class="form-label">Major</label>
                        <input type="text" name="major" id="major" class="form-control" placeholder="Masukkan major" required>
                    </div>

                    <div class="mb-3">
                        <label for="gender" class="form-label">Gender</label>
                        <select name="gender" id="gender" class="form-control" required>
                            <option value="">Pilih Gender</option>
                            <option value="Pria">Pria</option>
                            <option value="Wanita">Wanita</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="institution" class="form-label">Institution</label>
                        <select name="institution_id" id="institution" class="form-control" required>
                            <option value="" disabled selected>Pilih Instansi</option>
                        </select>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Simpan</button>
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
                defaultOption.textContent = 'Pilih instansi';
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
        const form = document.getElementById('addStudentForm');
        form.addEventListener('submit', function(e) {
            e.preventDefault(); // Prevent form from submitting the default way

            const formData = new FormData(form);

            // Make POST request to API
            fetch('/api/students', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + localStorage.getItem('token') // Optional: If using token-based auth
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.message) {
                    alert('Student created successfully');
                    window.location.href = '/studentList'; // Redirect to the student list page
                } else {
                    alert('Failed to create student');
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

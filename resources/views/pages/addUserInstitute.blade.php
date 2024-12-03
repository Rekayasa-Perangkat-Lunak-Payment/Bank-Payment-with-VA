@extends('layout.app')

@section('content')
    <div class="container">
        <div class="card mb-4">
            <div class="card-header">
                <h4>Tambah Admin Institusi</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('userInstitutions.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Masukkan nama" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="title" class="form-label">Jabatan</label>
                        <input type="text" name="title" id="title" class="form-control" placeholder="Masukkan jabatan" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="institution_id" class="form-label">Instansi</label>
                        <select name="institution_id" id="institution" class="form-control" required>
                            <option value="" disabled selected>Pilih instansi</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="user[email]" id="email" class="form-control" placeholder="Masukkan email" required>
                    </div>

                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="username" name="user[username]" id="username" class="form-control" placeholder="Masukkan username" required>
                    </div>

                    <div class="mb-3">
                        <label for="user.password" class="form-label">Kata Sandi</label>
                        <input type="password" name="user[password]" id="user.password" class="form-control" placeholder="Masukkan kata sandi" required>
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

        // Fetch data from API
        fetch('/api/institutions')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                // Populate the dropdown with institutions
                data.forEach(institution => {
                    const option = document.createElement('option');
                    option.value = institution.id; // Assuming the institution has an 'id' field
                    option.textContent = institution.name; // Assuming the institution has a 'name' field
                    institutionSelect.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error fetching institutions:', error);
            });
    });
</script>
@endsection

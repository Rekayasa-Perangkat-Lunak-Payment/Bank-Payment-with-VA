@extends('layout.app')

@section('content')
    <div class="container">
        <div class="card mb-4">
            <div class="card-header">
                <h4>Tambah Admin Institusi</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.institute.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Masukkan nama" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="position" class="form-label">Jabatan</label>
                        <input type="text" name="position" id="position" class="form-control" placeholder="Masukkan jabatan" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="institution" class="form-label">Instansi</label>
                        <input type="text" name="institution" id="institution" class="form-control" placeholder="Masukkan nama instansi" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="Masukkan email" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Kata Sandi</label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan kata sandi" required>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

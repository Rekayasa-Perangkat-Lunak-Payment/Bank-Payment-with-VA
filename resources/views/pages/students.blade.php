@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Daftar Mahasiswa</h2>


    <form method="GET" action="{{ route('students.index') }}" class="mb-4">
        <div class="row">

            <div class="col-md-4">
                <label for="institution_id" class="form-label">Filter Institusi</label>
                <select name="institution_id" id="institution_id" class="form-select">
                    <option value="">Semua Institusi</option>
                    @foreach ($institutions as $institution)
                        <option value="{{ $institution->id }}" {{ request('institution_id') == $institution->id ? 'selected' : '' }}>
                            {{ $institution->name }}
                        </option>
                    @endforeach
                </select>
            </div>


            <div class="col-md-4">
                <label for="search" class="form-label">Cari Nama/ID Mahasiswa</label>
                <input type="text" name="search" id="search" class="form-control" placeholder="Masukkan Nama atau ID" value="{{ request('search') }}">
            </div>


            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
        </div>
    </form>

    <div class="card">
        <div class="card-header">Daftar Mahasiswa</div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>ID Mahasiswa</th>
                        <th>Nama</th>
                        <th>Institusi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($students as $student)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $student->student_id }}</td>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->institution->name ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Tidak ada data mahasiswa.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-4">
        {{ $students->links() }}
    </div>
</div>
@endsection

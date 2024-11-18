@extends('layout.app')

@section('content')
    <div class="container">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4>Daftar Institusi</h4>
                <a href="{{ route('institute.create') }}" class="btn btn-primary">Tambah Institusi</a>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Institusi</th>
                            <th>Alamat</th>
                            <th>Email</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($institutes as $index => $institute)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $institute->name }}</td>
                                <td>{{ $institute->address }}</td>
                                <td>{{ $institute->email }}</td>
                                <td>
                                    <a href="{{ route('institute.edit', $institute->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('institute.destroy', $institute->id) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus institusi ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada data institusi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

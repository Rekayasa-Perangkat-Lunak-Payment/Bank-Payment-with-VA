@extends('layouts.app')
@section('content')

<div class="container">
    <h2>Halaman User Institute</h2>
    <div class="card mb-4">
        <div class="card-header">
            <h4>Informasi Admin</h4>
        </div>
        <div class="card-body">
            <p><strong>Nama:</strong> {{ $admin['name'] }}</p>
            <p><strong>Email:</strong> {{ $admin['email'] }}</p>
            <p><strong>Telepon:</strong> {{ $admin['phone'] }}</p>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h4>Jumlah Siswa per Angkatan</h4>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Angkatan</th>
                        <th>Jumlah Siswa</th>
                        <th>Detail</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($studentCounts as $year => $count)
                    <tr>
                        <td>{{ $year }}</td>
                        <td>{{ $count }}</td>
                        <td>
                            <a href="{{ route('student.details', $year) }}" class="btn btn-primary">Lihat Detail</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

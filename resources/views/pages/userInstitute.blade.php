@extends('layout.app')
@section('content')
    <div class="container">
        <div class="card mb-4">
            <div class="card-header">
                <h4>Informasi Admin</h4>
            </div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <th>Nama</th>
                        <td>Supri</td>
                    </tr>
                    <tr>
                        <th>Jabatan</th>
                        <td>Biro 2</td>
                    </tr>
                    <tr>
                        <th>Instansi</th>
                        <td>Universitas Muhammadiyah Riau</td>
                    </tr>
                </table>
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
                        {{-- @foreach ($studentCounts as $year => $count)
                    <tr>
                        <td>{{ $year }}</td>
                        <td>{{ $count }}</td>
                        <td>
                            <a href="{{ route('student.details', $year) }}" class="btn btn-primary">Lihat Detail</a>
                        </td>
                    </tr>
                    @endforeach --}}
                        <tr>
                            <td>2019</td>
                            <td>2000</td>
                            <td>
                                {{-- <a href="{{ route('student.details', $year) }}" class="btn btn-primary">Lihat Detail</a> --}}
                                <a href="/" class="btn btn-primary">Lihat Detail</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

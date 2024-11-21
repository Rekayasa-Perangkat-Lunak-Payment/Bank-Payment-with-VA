@extends('layout.app')

@section('content')
    <div class="container">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <!-- Ini Judul Halaman -->
                <h4>Daftar Periode Bayar</h4>
                
                <!-- Ini Filter -->
                <form method="GET" action="{{ route('payment-period.index') }}" class="d-flex align-items-center" style="gap: 10px;">
                    <label for="filterPeriode" class="me-2 mb-0" style="font-weight: bold;">Filter Periode:</label>
                    <select name="filterPeriode" id="filterPeriode" class="form-select"
                        style="width: 150px; padding: 8px 12px; border-radius: 25px; border: 1px solid #ced4da;">
                        <option value="">Semua Periode</option>
                        <!-- Loop untuk menampilkan daftar periode -->
                        @foreach ($availablePeriods as $availablePeriod)
                            <option value="{{ $availablePeriod->id }}" 
                                {{ request('filterPeriode') == $availablePeriod->id ? 'selected' : '' }}>
                                {{ $availablePeriod->periode }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-primary" style="border-radius: 25px;">
                        <i class="bi bi-filter"></i> Filter
                    </button>
                </form>
            </div>
            <div class="card-body">
                <!-- Tabel Daftar Periode Bayar -->
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <!-- Header Kolom Tabel -->
                            <th>No</th>
                            <th>Periode</th>
                            <th>Jumlah Dibayar</th>
                            <th>Jumlah Belum Dibayar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Looping Data Periode Bayar -->
                        @forelse ($periods as $index => $period)
                            <tr>
                                <!-- Nomor Urut -->
                                <td>{{ $index + 1 }}</td>
                                <!-- Data Periode -->
                                <td>{{ $period['periode'] }}</td>
                                <!-- Jumlah yang Telah Dibayar -->
                                <td>{{ number_format($period['dibayar'], 0, ',', '.') }}</td>
                                <!-- Jumlah yang Belum Dibayar -->
                                <td>{{ number_format($period['belum_dibayar'], 0, ',', '.') }}</td>
                                <td>
                                    <!-- Tombol Edit -->
                                    <a href="{{ route('payment-period.edit', $period['id']) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <!-- Tombol Hapus dengan Konfirmasi -->
                                    <form action="{{ route('payment-period.destroy', $period['id']) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus periode ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <!-- Jika Tidak Ada Data -->
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada data periode.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

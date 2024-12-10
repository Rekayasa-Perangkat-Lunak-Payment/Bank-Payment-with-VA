@extends('layout.app')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard Overview')

@section('content')
    <div class="container-fluid"> <!-- Tambahkan container-fluid di sini -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">Selamat datang, Elseva Vadiarama Puteri Jelita</h4>
                </div>
            </div>
            <!-- end col -->
        </div>

        <!-- Kotak Atas -->
        <div class="row">
            <!-- Total Tagihan -->
            <div class="col-xl-3 col-md-6">
                <div class="card h-100">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between">
                            <h3 class="mb-3">Total Tagihan</h3>
                            <i class="fa fa-file-invoice" style="font-size: 30px; color: #17a2b8;"></i> <!-- Ikon untuk Total Tagihan -->
                        </div>
                        <h5 class="text-muted font-size-12">Jumlah Nilai Tagihan</h5>
                        <h3 class="mb-3">Rp. <span class="counter_value" data-target="8500000"></span></h3> <!-- Update angka di data-target -->
                    </div>
                </div>
            </div>

            <!-- Total SKS -->
            <div class="col-xl-3 col-md-6">
                <div class="card h-100">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between">
                            <h3 class="mb-3">Total SKS</h3>
                            <i class="fa fa-book" style="font-size: 30px; color: #007bff;"></i> <!-- Ikon untuk Total SKS -->
                        </div>
                        <h5 class="text-muted font-size-12">Jumlah SKS yang diambil</h5>
                        <h3 class="mb-3">18</h3>
                    </div>
                </div>
            </div>

            <!-- Tanggal Pembayaran -->
            <div class="col-xl-3 col-md-6">
                <div class="card h-100">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between">
                            <h3 class="mb-3">Tanggal Pembayaran</h3>
                            <i class="fa fa-calendar" style="font-size: 30px; color: #ffc107;"></i> <!-- Ikon untuk Tanggal Pembayaran -->
                        </div>
                        <h5 class="text-muted font-size-12">Batas Tanggal Pembayaran</h5>
                        <h3 class="mb-3">25-08-2024</h3>
                    </div>
                </div>
            </div>


            <!-- Invoice & Pembayaran -->
            <div class="col-xl-3 col-md-6">
                <div class="card h-100">
                    <div class="card-body p-4">
                        <h3 class="mb-3">Invoice & Pembayaran</h3>
                        <h5 class="text-primary font-size-12">Elseva Vadiarama Puteri Jelita / 72220528</h5>
                        <button type="button" class="btn btn-primary btn-sm w-100 mt-3">
                            <i class="fas fa-file-invoice"></i> Bayar
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Kotak Atas -->

        <!-- Tabel Riwayat Transaksi -->
        <div class="row mt-4">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">PRODI Sistem Informasi</h4>
                        <table id="datatable" class="table table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Kode Matakuliah</th>
                                    <th>Nama Matakuliah</th>
                                    <th>Grup</th>
                                    <th>SKS</th>
                                    <th>Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>PR2413</td>
                                    <td>PRAKTIKUM REKAYASA PERANGKAT LUNAK</td>
                                    <td>B</td>
                                    <td>0</td>
                                    <td>4.0</td>
                                </tr>
                                <tr>
                                    <td>SI2413</td>
                                    <td>REKAYASA PERANGKAT LUNAK</td>
                                    <td>B</td>
                                    <td>3</td>
                                    <td>2.0</td>
                                </tr>
                                <tr>
                                    <td>SI3423</td>
                                    <td>PEMROGRAMAN TERINTEGRASI TERAPAN</td>
                                    <td>A</td>
                                    <td>3</td>
                                    <td>3.0</td>
                                </tr>
                                <tr>
                                    <td>SE4323</td>
                                    <td>DATA MINING</td>
                                    <td>A</td>
                                    <td>3</td>
                                    <td>3.0</td>
                                </tr>
                                <tr>
                                    <td>SE3343</td>
                                    <td>KEAMANAN TEKNOLOGI INFORMASI</td>
                                    <td>A</td>
                                    <td>3</td>
                                    <td>3.0</td>
                                </tr>
                                <tr>
                                    <td>SI2373</td>
                                    <td>KOMUNIKASI ANTAR PERSONAL</td>
                                    <td>A</td>
                                    <td>3</td>
                                    <td>3.0</td>
                                </tr>
                                <tr>
                                    <td>MH2033</td>
                                    <td>APRESIASI SENI MUSIK MBKM</td>
                                    <td>A</td>
                                    <td>3</td>
                                    <td>3.0</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Tabel Riwayat Transaksi -->
    </div>
@endsection
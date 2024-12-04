@extends('layout.app')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard Overview')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">Selamat datang, Elseva Vadiarama Puteri Jelita</h4>
            </div>
        </div>
        <!-- end col -->
    </div>

    <div class="row">
        <!-- Kotak Nilai Transaksi -->
        <div class="col-xl-4 col-md-2">
            <div class="card">
                <div class="card-body p-0">
                    <div class="p-4">
                        <div class="d-flex">
                            <div class="flex-1">
                                <h3 class="mb-3">Nilai Transaksi</h3>
                            </div>
                            <div>
                                <i class="fa fa-credit-card" style="font-size: 30px; color: #8928a7;"></i>
                            </div>
                        </div>
                        <h5 class="text-muted font-size-12">Jumlah Nilai Transaksi</h5>
                        <div class="flex-1">
                            <h3 class="mb-3">Rp. <span class="counter_value" data-target="125000000"></span></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        <!-- Kotak Berhasil -->
        <div class="col-xl-2 col-md-2">
            <div class="card">
                <div class="card-body p-0">
                    <div class="p-4">
                        <div class="d-flex">
                            <div class="flex-1">
                                <h3 class="mb-3">Berhasil</h3>
                            </div>
                            <div>
                                <i class="fa fa-check-circle" style="font-size: 30px; color: #28a745;"></i>
                            </div>
                        </div>
                        <h5 class="text-muted font-size-12">Jumlah Transaksi Berhasil</h5>
                        <div class="flex-1">
                            <h3 class="mb-3">8</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        <!-- Kotak Tertunda -->
        <div class="col-xl-2 col-md-2">
            <div class="card">
                <div class="card-body p-0">
                    <div class="p-4">
                        <div class="d-flex">
                            <div class="flex-1">
                                <h3 class="mb-3">Tertunda</h3>
                            </div>
                            <div>
                                <i class="fa fa-clock" style="font-size: 30px; color: #ffc107;"></i>
                            </div>
                        </div>
                        <h5 class="text-muted font-size-12">Jumlah Transaksi Tertunda</h5>
                        <div class="flex-1">
                            <h3 class="mb-3">2</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        <!-- Kotak Gagal -->
        <div class="col-xl-2 col-md-2">
            <div class="card">
                <div class="card-body p-0">
                    <div class="p-4">
                        <div class="d-flex">
                            <div class="flex-1">
                                <h3 class="mb-3">Gagal</h3>
                            </div>
                            <div>
                                <i class="fa fa-times-circle" style="font-size: 30px; color: #dc3545;"></i>
                            </div>
                        </div>
                        <h5 class="text-muted font-size-12">Jumlah Transaksi Gagal</h5>
                        <div class="flex-1">
                            <h3 class="mb-3">1</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        <!-- Kotak Total Tagihan -->
        <div class="col-xl-2 col-md-2">
            <div class="card">
                <div class="card-body p-0">
                    <div class="p-4">
                        <div class="d-flex">
                            <div class="flex-1">
                                <h3 class="mb-3">Total Tagihan</h3>
                            </div>
                            <div>
                                <i class="fa fa-file-invoice" style="font-size: 30px; color: #17a2b8;"></i>
                            </div>
                        </div>
                        <h5 class="text-muted font-size-12">Jumlah semua tagihan anda</h5>
                        <div class="flex-1">
                            <h3 class="mb-3">10</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

    <!-- end row -->
    <div class="row">
        <!-- Tabel Riwayat Transaksi -->
        <div class="col-xl-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Riwayat Transaksi</h4>
                    <table id="datatable" class="table table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Universitas</th>
                                <th>Transaksi</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Susan</td>
                                <td>Universitas Negeri Yogyakarta</td>
                                <td>Pembayaran</td>
                                <td><span class="badge bg-success">Berhasil</span></td>
                                <td>2012/05/15</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Michael</td>
                                <td>Universitas Gadjah Mada</td>
                                <td>Pengembalian</td>
                                <td><span class="badge bg-success">Berhasil</span></td>
                                <td>2013/07/18</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Linda</td>
                                <td>Universitas Kristen Satya Wacana</td>
                                <td>Pembayaran</td>
                                <td><span class="badge bg-warning">Tertunda</span></td>
                                <td>2014/08/22</td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>David</td>
                                <td>Universitas Diponegoro</td>
                                <td>Pembayaran</td>
                                <td><span class="badge bg-success">Berhasil</span></td>
                                <td>2015/09/10</td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>Emma</td>
                                <td>Universitas Sebelas Maret</td>
                                <td>Pengembalian</td>
                                <td><span class="badge bg-success">Berhasil</span></td>
                                <td>2016/11/05</td>
                            </tr>
                            <tr>
                                <td>6</td>
                                <td>Chris</td>
                                <td>Universitas Bina Nusantara</td>
                                <td>Pembayaran</td>
                                <td><span class="badge bg-danger">Gagal</span></td>
                                <td>2017/01/12</td>
                            </tr>
                            <tr>
                                <td>7</td>
                                <td>Jessica</td>
                                <td>Universitas Pelita Harapan</td>
                                <td>Pembayaran</td>
                                <td><span class="badge bg-success">Berhasil</span></td>
                                <td>2018/02/23</td>
                            </tr>
                            <tr>
                                <td>8</td>
                                <td>Daniel</td>
                                <td>Universitas Indonesia</td>
                                <td>Pengembalian</td>
                                <td><span class="badge bg-warning">Tertunda</span></td>
                                <td>2019/03/18</td>
                            </tr>
                            <tr>
                                <td>9</td>
                                <td>Sarah</td>
                                <td>Universitas Al Azhar Indonesia</td>
                                <td>Pembayaran</td>
                                <td><span class="badge bg-success">Berhasil</span></td>
                                <td>2020/04/14</td>
                            </tr>
                            <tr>
                                <td>10</td>
                                <td>Kevin</td>
                                <td>Universitas Pancasila</td>
                                <td>Pembayaran</td>
                                <td><span class="badge bg-success">Berhasil</span></td>
                                <td>2021/05/21</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    
        <!-- Grafik Analisa Transaksi dan Riwayat Aktivitas -->
        <div class="col-xl-4">
            <!-- Analisa Transaksi -->
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-0">Analisa Transaksi</h4>
                    <div class="text-center">
                        <p class="text-muted font-size-14 fw-bold mt-4">Grafik dari total transaksi anda</p>
                        <div id="column_chart_datalabel" class="column-chart"></div>
                    </div>
                </div>
            </div>
    
            <!-- Riwayat Aktivitas Transaksi -->
            <div class="card">
                <div class="card-body bg-transparent">
                    <h4 class="card-title mb-4">Riwayat Aktifitas Transaksi</h4>
                    <div class="pe-lg-3" data-simplebar style="max-height: 350px;">
                        <ul class="list-unstyled activity-wid">
                            <li class="activity-list">
                                <div class="activity-icon avatar-xs">
                                    <span class="avatar-title bg-soft-primary text-primary rounded-circle">
                                        <i class="ri-bank-card-fill"></i>
                                    </span>
                                </div>
                                <div>
                                    <div class="d-flex">
                                        <div class="flex-1">
                                            <h5 class="font-size-13">25 Nov, 2024</h5>
                                        </div>
                                        <div>
                                            <small class="text-muted">10:15 am</small>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="text-muted mb-0">Melakukan pembayaran di Universitas Negeri Yogyakarta</p>
                                    </div>
                                </div>
                            </li>
                            <li class="activity-list">
                                <div class="activity-icon avatar-xs">
                                    <span class="avatar-title bg-soft-primary text-primary rounded-circle">
                                        <i class="ri-check-fill"></i>
                                    </span>
                                </div>
                                <div>
                                    <div class="d-flex">
                                        <div class="flex-1">
                                            <h5 class="font-size-13">18 Nov, 2024</h5>
                                        </div>
                                        <div>
                                            <small class="text-muted">02:30 pm</small>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="text-muted mb-0">Transaksi berhasil di Universitas Gadjah Mada</p>
                                    </div>
                                </div>
                            </li>
                            <!-- Tambahkan item lainnya sesuai kebutuhan -->
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>    
        <!-- end row -->
    @endsection

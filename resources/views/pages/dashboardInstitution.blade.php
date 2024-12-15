@extends('layout.app')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard Overview')

@section('content')
    <div class="container-fluid"> <!-- Tambahkan container-fluid di sini -->
        <div class="row">

            <!-- end col -->
        </div>

        <!-- Kotak Atas -->
        <div class="row">
            <!-- Total Tagihan -->
            <div class="col-xl-3 col-md-6">
                <div class="card h-60">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between">
                            <h3 class="mb-3">Balance</h3>
                            <i class="fa fa-file-invoice" style="font-size: 30px; color: #17a2b8;"></i>
                            <!-- Ikon untuk Total Tagihan -->
                        </div>
                        <h5 class="text-muted font-size-12">SD Negeri 1 Jelita</h5>
                        <h3 class="mb-3">Rp. <span class="counter_value" data-target="1200000"></span></h3>
                        <!-- Update angka di data-target -->
                    </div>
                </div>
            </div>

            <!-- Total SKS -->
            <div class="col-xl-3 col-md-6">
                <div class="card h-70">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between">
                            <h3 class="mb-3">Active VA</h3>
                            <i class="fa fa-book" style="font-size: 30px; color: #007bff;"></i>
                            <!-- Ikon untuk Total SKS -->
                        </div>
                        <h5 class="text-muted font-size-12">Unpaid VA</h5>
                        <h3 class="mb-3">{{ $active_va }}</h3>
                    </div>
                </div>
            </div>

            <!-- Tanggal Pembayaran -->
            <div class="col-xl-6 col-md-6">
                <div class="card h-70">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between">
                            <h3 class="mb-3">Payment Period</h3>
                            <i class="fa fa-calendar" style="font-size: 30px; color: #ffc107;"></i>
                            <!-- Ikon untuk Tanggal Pembayaran -->
                        </div>
                        <h5 class="text-muted font-size-12">Current Active Payment Period</h5>
                        <h3 class="mb-3">{{ $payment_period['year'] }} - {{ $payment_period['month'] }} -
                            {{ $payment_period['semester'] }}</h3>
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
                        <table id="datatable" class="table table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Virtual Account Number</th>
                                    <th>Student Name</th>
                                    <th>Institution</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($active_virtual_accounts as $va)
                                    <tr>
                                        <td>{{ $va->virtual_account_number }}</td>
                                        <td>{{ $va->student->name ?? 'N/A' }}</td>
                                        <td>{{ $va->student->institution->name ?? 'N/A' }}</td>
                                        <td>{{ $va->total_amount ?? 'N/A' }}</td>
                                        <td>{{ $va->status ?? 'N/A' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Tabel Riwayat Transaksi -->
    </div>
@endsection

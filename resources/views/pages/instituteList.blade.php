@extends('layout.app')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard Overview')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">Institute List</h4>
            </div>
        </div>
        <!-- end col -->
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        {{-- <div class="col-md-5 col-9">
                            <h5 class="font-size-15 mb-3">List Bank</h5>
                        </div> --}}
                        <!-- end col -->
                        {{-- <div class="col-md-7 col-3"> --}}
                            <ul class="list-inline user-chat-nav text-end mb-2">
                                <li class="list-inline-item">
                                    <div class="dropdown">
                                        <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            <i class="mdi mdi-magnify text-muted"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-md p-0">
                                            <form class="p-2">
                                                <div class="search-box">
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control rounded bg-light border-0"
                                                            placeholder="Search...">
                                                        <i class="mdi mdi-magnify search-icon"></i>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </li>
                                <!-- end li -->
                                <li class="list-inline-item d-none d-sm-inline-block">
                                    <div class="dropdown">
                                        <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            <i class="mdi mdi-cog text-muted"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item" href="#">View Profile</a>
                                            <a class="dropdown-item" href="#">Add Product</a>
                                            <a class="dropdown-item" href="#">Remove Product</a>
                                        </div>
                                    </div>
                                </li>
                                <!-- end li -->
                            </ul>
                            <!-- end ul -->
                        {{-- </div> --}}
                        <!-- end col -->
                    </div>
                    <!-- end row -->

                    <div class="table-responsive">
                        <table class="table table-nowrap mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Name</th>
                                    {{-- <th scope="col">Address</th> --}}
                                    <th scope="col">Contact</th>
                                    <th scope="col">Admin</th>
                                    <th scope="col">Student</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    {{-- <td>
                                        <div class="avatar-sm">
                                            <span class="avatar-title rounded bg-light">
                                                <img src="assets/images/product/img-11.png" class="avatar-sm"
                                                    alt="Error">
                                            </span>
                                        </div>
                                    </td> --}}
                                    <td>
                                        <div class="">
                                            <h6 class="mb-0">INS001</h6>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="">
                                            <h6 class="mb-0">SD Negeri Kebonjati 1</h6>
                                            <a href="" class="text-primary fw-bold font-size-11">NPSN: 73703453</a>
                                        </div>
                                    </td>
                                    {{-- <td>
                                        <div class="">
                                            <h6 class="mb-0">Total Admin</h6>
                                            <p class="fw-bold mb-0">Jl. Raya Kebonjati No. 1</p>
                                            <p class="fw-bold mb-0">Sumedang, Sumatera Barat</p>
                                        </div>
                                    </td> --}}
                                    <td>
                                        <div class="">
                                            {{-- <h6 class="mb-0">Total Admin</h6> --}}
                                            <p class="fw-bold mb-0">kebonjati@gmail.com</p>
                                            <p>+62 1234 5678</p>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="">
                                            {{-- <h6 class="mb-0">Total Admin</h6> --}}
                                            <p class="fw-bold mb-0">6</p>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="">
                                            {{-- <h6 class="mb-0">Total Student</h6> --}}
                                            <p class="fw-bold mb-0">446</p>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <button type="button" class="btn btn-primary btn-sm">Read More</button>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    {{-- <td>
                                        <div class="avatar-sm">
                                            <span class="avatar-title rounded bg-light">
                                                <img src="assets/images/product/img-11.png" class="avatar-sm"
                                                    alt="Error">
                                            </span>
                                        </div>
                                    </td> --}}
                                    <td>
                                        <div class="">
                                            <h6 class="mb-0">INS002</h6>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="">
                                            <h6 class="mb-0">Universitas Gadjah Mulya</h6>
                                            <a href="" class="text-primary fw-bold font-size-11">NPSN: 36808211</a>
                                        </div>
                                    </td>
                                    {{-- <td>
                                        <div class="">
                                            <h6 class="mb-0">Total Admin</h6>
                                            <p class="fw-bold mb-0">Jl. Suzuki Itada</p>
                                            <p class="fw-bold mb-0">Slebewe, Niagara</p>
                                        </div>
                                    </td> --}}
                                    <td>
                                        <div class="">
                                            {{-- <h6 class="mb-0">Total Admin</h6> --}}
                                            <p class="fw-bold mb-0">kebonjati@gmail.com</p>
                                            <p>+62 1234 5678</p>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="">
                                            {{-- <h6 class="mb-0">Total Admin</h6> --}}
                                            <p class="fw-bold mb-0">2</p>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="">
                                            {{-- <h6 class="mb-0">Total Student</h6> --}}
                                            <p class="fw-bold mb-0">876</p>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <button type="button" class="btn btn-primary btn-sm">Read More</button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    {{-- <td>
                                        <div class="avatar-sm">
                                            <span class="avatar-title rounded bg-light">
                                                <img src="assets/images/product/img-11.png" class="avatar-sm"
                                                    alt="Error">
                                            </span>
                                        </div>
                                    </td> --}}
                                    <td>
                                        <div class="">
                                            <h6 class="mb-0">INS003</h6>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="">
                                            <h6 class="mb-0">SMA Budi Dipake Terus</h6>
                                            <a href="" class="text-primary fw-bold font-size-11">NPSN: 3453234</a>
                                        </div>
                                    </td>
                                    {{-- <td>
                                        <div class="">
                                            <h6 class="mb-0">Total Admin</h6>
                                            <p class="fw-bold mb-0">Jl. Mundur Terus</p>
                                            <p class="fw-bold mb-0">Gamaju, Jawa Koentji</p>
                                        </div>
                                    </td> --}}
                                    <td>
                                        <div class="">
                                            {{-- <h6 class="mb-0">Total Admin</h6> --}}
                                            <p class="fw-bold mb-0">budibosen@gmail.com</p>
                                            <p>+62 4562 8977</p>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="">
                                            {{-- <h6 class="mb-0">Total Admin</h6> --}}
                                            <p class="fw-bold mb-0">3</p>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="">
                                            {{-- <h6 class="mb-0">Total Student</h6> --}}
                                            <p class="fw-bold mb-0">1670</p>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <button type="button" class="btn btn-primary btn-sm">Read More</button>
                                        </div>
                                    </td>
                                </tr>
                                <!-- end tr -->
                            </tbody>
                            <!-- end t-body -->
                        </table>
                        <!-- end table -->
                    </div>
                    <!-- end table-responsive -->
                </div>
                <!-- end cardbody -->
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->
@endsection

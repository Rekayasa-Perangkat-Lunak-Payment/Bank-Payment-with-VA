@extends('layout.app')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard Overview')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0">Institute List Bank</h4>
        </div>
    </div>
    <!-- end col -->
</div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-5 col-9">
                            <h5 class="font-size-15 mb-3">List Bank</h5>
                        </div>
                        <!-- end col -->
                        <div class="col-md-7 col-3">
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
                                                        <input type="text"
                                                            class="form-control rounded bg-light border-0"
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
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->

                    <div class="table-responsive">
                        <table class="table table-nowrap mb-0">
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="avatar-sm">
                                            <span class="avatar-title rounded bg-light">
                                                <img src="assets/images/product/img-11.png" class="avatar-sm"
                                                    alt="Error">
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="">
                                            <h6 class="mb-0">BNI</h6>
                                            <a href="" class="text-primary fw-bold font-size-11">ID
                                                :
                                                #NC1097</a>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="">
                                            <h6 class="mb-0">Total User</h6>
                                            <p class="fw-bold mb-0">91</p>
                                        </div>
                                    </td>
                                    <td>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="avatar-sm">
                                            <span class="avatar-title rounded bg-light">
                                                <img src="assets/images/product/img-11.png" class="avatar-sm"
                                                    alt="Error">
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="">
                                            <h6 class="mb-0">BNI</h6>
                                            <a href="" class="text-primary fw-bold font-size-11">ID
                                                :
                                                #NC1097</a>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="">
                                            <h6 class="mb-0">Total User</h6>
                                            <p class="fw-bold mb-0">91</p>
                                        </div>
                                    </td>
                                    <td>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="avatar-sm">
                                            <span class="avatar-title rounded bg-light">
                                                <img src="assets/images/product/img-11.png" class="avatar-sm"
                                                    alt="Error">
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="">
                                            <h6 class="mb-0">BNI</h6>
                                            <a href="" class="text-primary fw-bold font-size-11">ID
                                                :
                                                #NC1097</a>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="">
                                            <h6 class="mb-0">Total User</h6>
                                            <p class="fw-bold mb-0">91</p>
                                        </div>
                                    </td>
                                    <td>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="avatar-sm">
                                            <span class="avatar-title rounded bg-light">
                                                <img src="assets/images/product/img-11.png" class="avatar-sm"
                                                    alt="Error">
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="">
                                            <h6 class="mb-0">BNI</h6>
                                            <a href="" class="text-primary fw-bold font-size-11">ID
                                                :
                                                #NC1097</a>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="">
                                            <h6 class="mb-0">Total User</h6>
                                            <p class="fw-bold mb-0">91</p>
                                        </div>
                                    </td>
                                    <td>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="avatar-sm">
                                            <span class="avatar-title rounded bg-light">
                                                <img src="assets/images/product/img-11.png" class="avatar-sm"
                                                    alt="Error">
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="">
                                            <h6 class="mb-0">BNI</h6>
                                            <a href="" class="text-primary fw-bold font-size-11">ID
                                                :
                                                #NC1097</a>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="">
                                            <h6 class="mb-0">Total User</h6>
                                            <p class="fw-bold mb-0">91</p>
                                        </div>
                                    </td>
                                    <td>
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

@extends('layout.app')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard Overview')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0">User Institute List</h4>
        </div>
    </div>
    <!-- end col -->
</div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="dropdown float-end">
                        <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="mdi mdi-dots-vertical text-muted"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">Status</a>
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">Profit</a>
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">Action</a>
                        </div>
                    </div>
                    <!-- end dropdown -->
                    <h4 class="card-title mb-4">Latest Transactions</h4>
                    <div class="table-responsive">
                        <table class="table table-centered border table-nowrap mb-0"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead class="table-light">
                                <tr>
                                    <th>Customer ID</th>
                                    <th>Billing Name</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th colspan="2">Action</th>
                                </tr>
                                <!-- end tr -->
                            </thead>
                            <!-- end thead -->
                            <tbody>
                                <tr>
                                    <td>
                                        #DD4951
                                        <p class="text-muted mb-0 font-size-11">24-03-2021</p>
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <div class="me-3">
                                                <img src="assets/images/users/avatar-1.jpg"
                                                    class="avatar-xs h-auto rounded-circle" alt="Error">
                                            </div>
                                            <div>
                                                <h5 class="font-size-13 text-truncate mb-1"><a href="#"
                                                        class="text-dark">Julia Fox</a>
                                                </h5>
                                                <p class="text-muted mb-0 font-size-11 text-uppercase">
                                                    Grenada</p>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <h6 class="mb-1 font-size-13">$32,960</h6>
                                        <p class="text-success text-uppercase  mb-0 font-size-11"><i
                                                class="mdi mdi-circle-medium"></i>paid</p>
                                    </td>
                                    <td>
                                        <h6 class="mb-1 font-size-13">Stock</h6>
                                        <p class="text-primary mb-0 font-size-11">ORDS- 2546881</p>
                                    </td>
                                    <td>
                                        <ul class="d-flex list-inline mb-0">
                                            <li class="list-inline-item">
                                                <a href="#"
                                                    class="btn btn-light p-0 avatar-xs d-block rounded-circle">
                                                    <span class="avatar-title bg-transparent text-body">
                                                        <i class="mdi mdi-trash-can-outline"></i>
                                                    </span>
                                                </a>
                                            </li>
                                            <!-- end li -->
                                            <li class="list-inline-item">
                                                <a href="#"
                                                    class="btn btn-light p-0 avatar-xs d-block rounded-circle">
                                                    <span class="avatar-title bg-transparent text-body">
                                                        <i class="mdi mdi-heart-outline"></i>
                                                    </span>
                                                </a>
                                            </li>
                                            <!-- end li -->
                                        </ul>
                                    </td>

                                    <td style="width: 134px">
                                        <div class="btn btn-soft-primary btn-sm">View more<i
                                                class="mdi mdi-arrow-right ms-1"></i></div>
                                    </td>
                                </tr>
                                <!-- end /tr -->
                                <tr>
                                    <td>
                                        #DD4952
                                        <p class="text-muted mb-0 font-size-11">25-03-2021</p>
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <div class="me-3">
                                                <img src="assets/images/users/avatar-2.jpg"
                                                    class="avatar-xs h-auto rounded-circle" alt="Error">
                                            </div>
                                            <div>
                                                <h5 class="font-size-13 text-truncate mb-1"><a href="#"
                                                        class="text-dark">Max Jazz</a>
                                                </h5>
                                                <p class="text-muted mb-0 font-size-11 text-uppercase">
                                                    Vatican City</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <h6 class="mb-1 font-size-13">$30,785</h6>
                                        <p class="text-success text-uppercase mb-0 font-size-11"><i
                                                class="mdi mdi-circle-medium "></i>paid</p>
                                    </td>
                                    <td>
                                        <h6 class="mb-1 font-size-13">Out of Stock</h6>
                                        <p class="text-primary mb-0 font-size-11">ORDS- 2546882</p>
                                    </td>
                                    <td>
                                        <ul class="d-flex list-inline mb-0">
                                            <li class="list-inline-item">
                                                <a href="#"
                                                    class="btn btn-light p-0 avatar-xs d-block rounded-circle">
                                                    <span class="avatar-title bg-transparent text-body">
                                                        <i class="mdi mdi-trash-can-outline"></i>
                                                    </span>
                                                </a>
                                            </li>
                                            <!-- end li -->
                                            <li class="list-inline-item">
                                                <a href="#"
                                                    class="btn btn-light p-0 avatar-xs d-block rounded-circle">
                                                    <span class="avatar-title bg-transparent text-body">
                                                        <i class="mdi mdi-heart-outline"></i>
                                                    </span>
                                                </a>
                                            </li>
                                            <!-- end li -->
                                        </ul>
                                    </td>

                                    <td>
                                        <div class="btn btn-soft-primary btn-sm">View more<i
                                                class="mdi mdi-arrow-right ms-1"></i>
                                        </div>
                                    </td>
                                </tr>
                                <!-- end /tr -->
                                <tr>
                                    <td>
                                        #DD4953
                                        <p class="text-muted mb-0 font-size-11">26-03-2021</p>
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <div class="me-3">
                                                <img src="assets/images/users/avatar-3.jpg"
                                                    class="avatar-xs h-auto rounded-circle" alt="Error">
                                            </div>
                                            <div>
                                                <h5 class="font-size-13 text-truncate mb-1"><a href="#"
                                                        class="text-dark">Jems Clarence</a>
                                                </h5>
                                                <p class="text-muted mb-0 font-size-11 text-uppercase">
                                                    Grenada</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <h6 class="mb-1 font-size-13">$19,191</h6>
                                        <p class="text-warning text-uppercase  mb-0 font-size-11"><i
                                                class="mdi mdi-circle-medium"></i>Pending</p>
                                    </td>
                                    <td>
                                        <h6 class="mb-1 font-size-13">Stock</h6>
                                        <p class="text-primary mb-0 font-size-11">ORDS- 2546883</p>
                                    </td>
                                    <td>
                                        <ul class="d-flex list-inline mb-0">
                                            <li class="list-inline-item">
                                                <a href="#"
                                                    class="btn btn-light p-0 avatar-xs d-block rounded-circle">
                                                    <span class="avatar-title bg-transparent text-body">
                                                        <i class="mdi mdi-trash-can-outline"></i>
                                                    </span>
                                                </a>
                                            </li>
                                            <!-- end li -->
                                            <li class="list-inline-item">
                                                <a href="#"
                                                    class="btn btn-light p-0 avatar-xs d-block rounded-circle">
                                                    <span class="avatar-title bg-transparent text-body">
                                                        <i class="mdi mdi-heart-outline"></i>
                                                    </span>
                                                </a>
                                            </li>
                                            <!-- end li -->
                                        </ul>
                                    </td>
                                    <td>
                                        <div class="btn btn-soft-primary btn-sm">View more<i
                                                class="mdi mdi-arrow-right ms-1"></i>
                                        </div>
                                    </td>

                                </tr>
                                <!-- end /tr -->
                                <tr>
                                    <td>
                                        #DD4954
                                        <p class="text-muted mb-0 font-size-11">27-03-2021</p>
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <div class="me-3">
                                                <img src="assets/images/users/avatar-4.jpg"
                                                    class="avatar-xs h-auto rounded-circle" alt="Error">
                                            </div>
                                            <div>
                                                <h5 class="font-size-13 text-truncate mb-1"><a href="#"
                                                        class="text-dark">Prezy Summa</a>
                                                </h5>
                                                <p class="text-muted mb-0 font-size-11 text-uppercase">
                                                    Maldivse</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <h6 class="mb-1 font-size-13">$34,450</h6>
                                        <p class="text-success text-uppercase mb-0 font-size-11"><i
                                                class="mdi mdi-circle-medium "></i>paid</p>
                                    </td>
                                    <td>
                                        <h6 class="mb-1 font-size-13">Out of Stock</h6>
                                        <p class="text-primary mb-0 font-size-11">ORDS- 2546884</p>
                                    </td>
                                    <td>
                                        <ul class="d-flex list-inline mb-0">
                                            <li class="list-inline-item">
                                                <a href="#"
                                                    class="btn btn-light p-0 avatar-xs d-block rounded-circle">
                                                    <span class="avatar-title bg-transparent text-body">
                                                        <i class="mdi mdi-trash-can-outline"></i>
                                                    </span>
                                                </a>
                                            </li>
                                            <!-- end li -->
                                            <li class="list-inline-item">
                                                <a href="#"
                                                    class="btn btn-light p-0 avatar-xs d-block rounded-circle">
                                                    <span class="avatar-title bg-transparent text-body">
                                                        <i class="mdi mdi-heart-outline"></i>
                                                    </span>
                                                </a>
                                            </li>
                                            <!-- end li -->
                                        </ul>
                                    </td>
                                    <td>
                                        <div class="btn btn-soft-primary btn-sm">View more<i
                                                class="mdi mdi-arrow-right ms-1"></i>
                                        </div>
                                    </td>
                                </tr>
                                <!-- end /tr -->
                                <tr>
                                    <td>
                                        #DD4955
                                        <p class="text-muted mb-0 font-size-11">29-03-2021</p>
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <div class="me-3">
                                                <img src="assets/images/users/avatar-5.jpg"
                                                    class="avatar-xs h-auto rounded-circle" alt="Error">
                                            </div>
                                            <div>
                                                <h5 class="font-size-13 text-truncate mb-1"><a href="#"
                                                        class="text-dark">Julia Fox</a>
                                                </h5>
                                                <p class="text-muted mb-0 font-size-11 text-uppercase">
                                                    Glory
                                                    Road</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <h6 class="mb-1 font-size-13">$24,450</h6>
                                        <p class="text-danger text-uppercase mb-0 font-size-11"><i
                                                class="mdi mdi-circle-medium"></i>Canceled</p>
                                    </td>
                                    <td>
                                        <h6 class="mb-1 font-size-13">Stock</h6>
                                        <p class="text-primary mb-0 font-size-11">ORDS- 2546885</p>
                                    </td>
                                    <td>
                                        <ul class="d-flex list-inline mb-0">
                                            <li class="list-inline-item">
                                                <a href="#"
                                                    class="btn btn-light p-0 avatar-xs d-block rounded-circle">
                                                    <span class="avatar-title bg-transparent text-body">
                                                        <i class="mdi mdi-trash-can-outline"></i>
                                                    </span>
                                                </a>
                                            </li>
                                            <!-- end li -->
                                            <li class="list-inline-item">
                                                <a href="#"
                                                    class="btn btn-light p-0 avatar-xs d-block rounded-circle">
                                                    <span class="avatar-title bg-transparent text-body">
                                                        <i class="mdi mdi-heart-outline"></i>
                                                    </span>
                                                </a>
                                            </li>
                                            <!-- end li -->
                                        </ul>
                                    </td>
                                    <td>
                                        <div class="btn btn-soft-primary btn-sm">View more<i
                                                class="mdi mdi-arrow-right ms-1"></i>
                                        </div>
                                    </td>
                                </tr>
                                <!-- end /tr -->
                            </tbody>
                            <!-- end tbody -->
                        </table>
                        <!-- end table -->
                    </div>
                    <!-- end tableresponsive -->
                </div>
            </div>
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->
@endsection

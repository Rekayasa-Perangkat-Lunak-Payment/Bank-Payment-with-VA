<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex align-items-center">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="/" class="logo logo-light">
                    <span class="logo-sm">
                        {{-- logo closed --}}
                        {{-- <img src="assets/images/logo-dummin2.png" alt="logo-sm-light" height="22"> --}}
                        <span class="fs-4">IPay</span>
                    </span>
                    <span class="logo-lg">
                        {{-- logo open --}}
                        {{-- <img src="assets/images/logo-light.png" alt="logo-light" height="22"> --}}
                        <span class="fw-bolder fs-3 light">Institute Pay</span>
                    </span>
                </a>
            </div>

            <!-- Menu Button -->
            <div class="ms-3">
                <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
                    <i class="ri-menu-2-line align-middle"></i>
                </button>
            </div>
        </div>

        <div class="d-flex align-items-center justify-content-between w-100">
            <!-- Page Title -->
            <div class="d-flex align-items-center ms-3">
                <h4 class="mb-0" style="color: #fff">@yield('page-title')</h4>
            </div>

            <!-- User Dropdown -->
            <div class="dropdown d-inline-block user-dropdown">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="assets/images/users/avatar-7.jpg"
                        alt="Header Avatar">
                    <span class="d-none d-xl-inline-block ms-1">Elseva Jelita</span>
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    <a class="dropdown-item" href="#"><i class="ri-user-line align-middle me-1"></i> Profile</a>
                    <a class="dropdown-item d-block" href="#"><span
                            class="badge bg-success float-end mt-1">11</span><i
                            class="ri-settings-2-line align-middle me-1"></i> Settings</a>
                    <a class="dropdown-item" href="#"><i class="ri-lock-unlock-line align-middle me-1"></i> Lock
                        screen</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="/login"><i
                            class="ri-shut-down-line align-middle me-1 text-danger"></i> Logout</a>
                </div>
            </div>
            <!-- end user -->
        </div>
    </div>
</header>

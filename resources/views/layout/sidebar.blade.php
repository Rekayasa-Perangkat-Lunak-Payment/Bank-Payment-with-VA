<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Menu</li>

                <!-- Dashboard (common for all users) -->
                <li>
                    <a href="/" class="waves-effect">
                        <i class="ri-dashboard-line"></i><span class="badge rounded-pill bg-success float-end">3</span>
                        <span>Dashboard</span>
                    </a>
                </li>

                <!-- User Institute List (Only for Institution Admin) -->
                {{-- @if(auth()->check() && auth()->user()->institutionAdmin !== null) --}}
                    <li>
                        <a href="/userInstituteList" class="waves-effect">
                            <i class="fas fa-align-justify"></i>
                            <span>User Institute List</span>
                        </a>
                    </li>

                    <li>
                        <a href="/instituteList" class="waves-effect">
                            <i class="ri-chat-1-line"></i>
                            <span>Institute List</span>
                        </a>
                    </li>
                {{-- @endif --}}

                <!-- Bank Transactions (Only for Bank Admin) -->
                {{-- @if(auth()->check() && auth()->user()->bankAdmin !== null) --}}
                    <li>
                        <a href="/bankTransactions" class="waves-effect">
                            <i class="ri-wallet-line"></i>
                            <span>Bank Transactions</span>
                        </a>
                    </li>

                    <li>
                        <a href="/paymentHistory" class="waves-effect">
                            <i class="ri-history-line"></i>
                            <span>Payment History</span>
                        </a>
                    </li>

                    <li>
                        <a href="/studentList" class="waves-effect">
                            <i class="ri-parent-line"></i>
                            <span>Student List</span>
                        </a>
                    </li>
                {{-- @endif --}}
            </ul>
            <!-- end ul -->
        </div>
        <!-- Sidebar -->
    </div>
</div>

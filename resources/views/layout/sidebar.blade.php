<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Menu</li>

                <!-- Dashboard (common for all users) -->
                <li>
                    <a href="/dashboard" class="waves-effect">
                        <i class="ri-dashboard-line"></i><span class="badge rounded-pill bg-success float-end">3</span>
                        <span>Dashboard</span>
                    </a>
                </li>

                <!-- User Institute List (Only for Institution Admin) -->
                <li id="userInstituteList" style="display:none;">
                    <a href="/userInstituteList" class="waves-effect">
                        <i class="fas fa-align-justify"></i>
                        <span>User Institute List</span>
                    </a>
                </li>

                <li id="instituteList" style="display:none;">
                    <a href="/instituteList" class="waves-effect">
                        <i class="ri-chat-1-line"></i>
                        <span>Institute List</span>
                    </a>
                </li>

                <!-- Bank Transactions (Only for Bank Admin) -->
                <li id="transactions" style="display:none;">
                    <a href="/transactions" class="waves-effect">
                        <i class="ri-wallet-line"></i>
                        <span>Transactions</span>
                    </a>
                </li>

                <li id="paymentPeriodList" style="display:none;">
                    <a href="/paymentPeriodList" class="waves-effect">
                        <i class="ri-history-line"></i>
                        <span>Payment Period</span>
                    </a>
                </li>

                <li id="studentList" style="display:none;">
                    <a href="/studentList" class="waves-effect">
                        <i class="ri-parent-line"></i>
                        <span>Student List</span>
                    </a>
                </li>
            </ul>
            <!-- end ul -->
        </div>
        <!-- Sidebar -->
    </div>
</div>

<script>
    // Get the role from localStorage
    const userRole = localStorage.getItem('role');

    // Show/hide menu items based on role
    if (userRole === 'bank_admin') {
        document.getElementById('userInstituteList').style.display = 'block';
        document.getElementById('instituteList').style.display = 'block';
    } else if (userRole === 'institution_admin') {
        document.getElementById('transactions').style.display = 'block';
        document.getElementById('paymentPeriodList').style.display = 'block';
        document.getElementById('studentList').style.display = 'block';
    }
</script>

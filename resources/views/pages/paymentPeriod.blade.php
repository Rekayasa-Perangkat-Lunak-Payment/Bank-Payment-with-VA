@extends('layout.app')

@section('title', 'Create Virtual Accounts')

@section('content')
    <h1>Create Virtual Accounts</h1>

    <!-- Institution and Payment Period Details -->
    <div class="mb-4">
        <h5>Institution: <span id="institution-name"></span></h5>
        <h5>Payment Period: <span id="payment-period-details"></span></h5>
    </div>

    <!-- Filter Students -->
    <form id="filter-students-form" class="mb-4">
        <div class="row">
            <div class="col-md-6">
                <input type="text" id="filter-student-name" class="form-control" placeholder="Search by Student Name">
            </div>
            <div class="col-md-6">
                <input type="text" id="filter-student-email" class="form-control" placeholder="Search by Student Email">
            </div>
        </div>
        <div class="mt-3">
            <button type="button" id="filter-button" class="btn btn-primary">Filter</button>
            <button type="button" id="reset-button" class="btn btn-secondary">Reset</button>
        </div>
    </form>

    <!-- Virtual Accounts Table -->
    <form id="virtual-account-form">
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Student Name</th>
                    <th>Institution</th>
                    <th>Virtual Account Number</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody id="students-table-body">
                <tr>
                    <td colspan="5" class="text-center">Loading...</td>
                </tr>
            </tbody>
        </table>


        <a href="{{ url('/virtualAccountCreate/' . $id) }}" class="btn btn-success">
            Create Virtual Accounts
        </a>        
        
        
    </form>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const apiUrl = '/api/students'; // API endpoint for fetching students
            const createVirtualAccountUrl = '/api/virtualAccount'; // API endpoint for creating virtual accounts
            const paymentPeriodId = {{ $id }}; // Pass paymentPeriodId dynamically from controller
            const institutionNameElement = document.getElementById('institution-name');
            const paymentPeriodDetailsElement = document.getElementById('payment-period-details');
            const studentsTableBody = document.getElementById('students-table-body');

            // Load Institution and Payment Period Details
            function loadPaymentPeriodDetails() {
                const monthNames = [
                    "January", "February", "March", "April", "May", "June",
                    "July", "August", "September", "October", "November", "December"
                ];

                fetch(`/api/paymentPeriod/${paymentPeriodId}`)
                    .then(response => response.json())
                    .then(data => {
                        const monthName = monthNames[parseInt(data.month, 10) -
                            1]; // Convert numeric month to name
                        institutionNameElement.textContent = data.institution.name;
                        paymentPeriodDetailsElement.textContent =
                            `${data.year} - ${monthName} (${data.semester})`;
                    })
                    .catch(error => console.error('Error loading payment period details:', error));
            }
            // Utility function to format numbers into Rupiah
            function formatRupiah(amount) {
                if (amount == null) return 'N/A';
                return new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0,
                }).format(amount);
            }

            // Function to get status with colored labels
            function getStatusWithColor(status) {
                let className = '';
                switch (status) {
                    case 'Expired':
                        className = 'badge badge-danger';
                        break;
                    case 'Paid':
                        className = 'badge badge-success';
                        break;
                    case 'Unpaid':
                        // Custom yellow with dark text
                        customStyle = 'background-color: #FFD700; color: #000;';
                        break;
                    default:
                        className = 'badge badge-secondary';
                }
                if (customStyle) {
                    return `<span class="badge" style="${customStyle}">${status}</span>`;
                }
                return `<span class="${className}">${status}</span>`;
            }

            // Function to determine the status
            function determineStatus(va) {
                const now = new Date();
                const expiredDate = new Date(va.expired_date);

                if (expiredDate < now) {
                    return 'Expired';
                }
                return va.is_active === 0 ? 'Paid' : 'Unpaid';
            }

            // Load Virtual Accounts
            function loadVirtualAccounts() {
                studentsTableBody.innerHTML = '<tr><td colspan="5" class="text-center">Loading...</td></tr>';

                fetch(`/api/virtualAccountList/${paymentPeriodId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.length === 0) {
                            studentsTableBody.innerHTML =
                                '<tr><td colspan="5" class="text-center">No virtual accounts found</td></tr>';
                            return;
                        }

                        studentsTableBody.innerHTML = data.map(va => {
                            const student = va.invoice?.student;
                            const institution = student?.institution;
                            const status = determineStatus(va);
                            return `
                                <tr>
                                    <td>${student?.name || 'N/A'}</td>
                                    <td>${institution?.name || 'N/A'}</td>
                                    <td>${va.virtual_account_number || 'N/A'}</td>
                                    <td>${formatRupiah(va.total_amount)}</td>
                                    <td>${getStatusWithColor(status)}</td>
                                </tr>
                            `;
                        }).join('');
                    })
                    .catch(error => {
                        console.error('Error loading virtual accounts:', error);
                        studentsTableBody.innerHTML =
                            '<tr><td colspan="5" class="text-center">Failed to load data</td></tr>';
                    });
            }

            // Filter Students (Optional functionality, may need modifications depending on backend)
            document.getElementById('filter-button').addEventListener('click', function() {
                const filters = {
                    name: document.getElementById('filter-student-name').value,
                    email: document.getElementById('filter-student-email').value,
                };
                loadStudents(filters);
            });

            // Reset Filters
            document.getElementById('reset-button').addEventListener('click', function() {
                document.getElementById('filter-students-form').reset();
                loadStudents();
            });

            // Initial Load
            loadPaymentPeriodDetails();
            loadVirtualAccounts();
        });
    </script>
@endsection
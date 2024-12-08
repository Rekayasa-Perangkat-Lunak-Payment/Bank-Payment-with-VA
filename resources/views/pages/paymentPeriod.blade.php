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
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Student Name</th>
                    <th>Email</th>
                    <th>Institution</th>
                    <th>Virtual Account Number</th>
                </tr>
            </thead>
            <tbody id="students-table-body">
                <tr>
                    <td colspan="4" class="text-center">Loading...</td>
                </tr>
            </tbody>
        </table>

        <button type="submit" class="btn btn-success">Create Virtual Accounts</button>
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
                        const monthName = monthNames[parseInt(data.month, 10) - 1]; // Convert numeric month to name
                        institutionNameElement.textContent = data.institution.name;
                        paymentPeriodDetailsElement.textContent =
                            `${data.year} - ${monthName} (${data.semester})`;
                    })
                    .catch(error => console.error('Error loading payment period details:', error));
            }

            // Load Virtual Accounts
            function loadVirtualAccounts() {
                studentsTableBody.innerHTML = '<tr><td colspan="4" class="text-center">Loading...</td></tr>';

                fetch(`/api/virtualAccountList/${paymentPeriodId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.length === 0) {
                            studentsTableBody.innerHTML =
                                '<tr><td colspan="4" class="text-center">No virtual accounts found</td></tr>';
                            return;
                        }

                        studentsTableBody.innerHTML = data.map(va => {
                            const student = va.invoice?.student;
                            const institution = student?.institution;
                            return `
                                <tr>
                                    <td>${student?.name || 'N/A'}</td>
                                    <td>${student?.email || 'N/A'}</td>
                                    <td>${institution?.name || 'N/A'}</td>
                                    <td>${va.virtual_account_number || 'N/A'}</td>
                                </tr>
                            `;
                        }).join('');
                    })
                    .catch(error => {
                        console.error('Error loading virtual accounts:', error);
                        studentsTableBody.innerHTML =
                            '<tr><td colspan="4" class="text-center">Failed to load data</td></tr>';
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

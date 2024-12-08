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

    <!-- Students Table -->
    <form id="virtual-account-form">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Select</th>
                    <th>Student Name</th>
                    <th>Email</th>
                    <th>Institution</th>
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
        document.addEventListener('DOMContentLoaded', function () {
            const apiUrl = '/api/students'; // API endpoint for fetching students
            const createVirtualAccountUrl = '/api/virtualAccount'; // API endpoint for creating virtual accounts
            const paymentPeriodId = "{{ $paymentPeriodId }}"; // Pass paymentPeriodId dynamically from controller
            const institutionNameElement = document.getElementById('institution-name');
            const paymentPeriodDetailsElement = document.getElementById('payment-period-details');
            const studentsTableBody = document.getElementById('students-table-body');

            // Load Institution and Payment Period Details
            function loadPaymentPeriodDetails() {
                fetch(`/api/paymentPeriod/${paymentPeriodId}`)
                    .then(response => response.json())
                    .then(data => {
                        institutionNameElement.textContent = data.institution.name;
                        paymentPeriodDetailsElement.textContent = `${data.year} - ${data.month} (${data.semester})`;
                    })
                    .catch(error => console.error('Error loading payment period details:', error));
            }

            // Load Students
            function loadStudents(filters = {}) {
                studentsTableBody.innerHTML = '<tr><td colspan="4" class="text-center">Loading...</td></tr>';

                const params = new URLSearchParams({ payment_period_id: paymentPeriodId, ...filters }).toString();
                fetch(`${apiUrl}?${params}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.length === 0) {
                            studentsTableBody.innerHTML =
                                '<tr><td colspan="4" class="text-center">No students found</td></tr>';
                            return;
                        }

                        studentsTableBody.innerHTML = data.map(student => `
                            <tr>
                                <td>
                                    <input type="checkbox" name="student_ids[]" value="${student.id}">
                                </td>
                                <td>${student.name}</td>
                                <td>${student.email}</td>
                                <td>${student.institution.name}</td>
                            </tr>
                        `).join('');
                    })
                    .catch(error => {
                        console.error('Error loading students:', error);
                        studentsTableBody.innerHTML =
                            '<tr><td colspan="4" class="text-center">Failed to load data</td></tr>';
                    });
            }

            // Handle Virtual Account Form Submission
            document.getElementById('virtual-account-form').addEventListener('submit', function (e) {
                e.preventDefault();

                const selectedStudents = Array.from(document.querySelectorAll('input[name="student_ids[]"]:checked'))
                    .map(input => input.value);

                if (selectedStudents.length === 0) {
                    alert('Please select at least one student.');
                    return;
                }

                const data = {
                    payment_period_id: paymentPeriodId,
                    student_ids: selectedStudents
                };

                fetch(createVirtualAccountUrl, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(data),
                })
                    .then(response => response.json())
                    .then(result => {
                        if (result.success) {
                            alert('Virtual Accounts created successfully!');
                            loadStudents(); // Reload students
                        } else {
                            alert('Failed to create Virtual Accounts.');
                        }
                    })
                    .catch(error => {
                        console.error('Error creating virtual accounts:', error);
                        alert('An error occurred while creating Virtual Accounts.');
                    });
            });

            // Filter Students
            document.getElementById('filter-button').addEventListener('click', function () {
                const filters = {
                    name: document.getElementById('filter-student-name').value,
                    email: document.getElementById('filter-student-email').value,
                };
                loadStudents(filters);
            });

            // Reset Filters
            document.getElementById('reset-button').addEventListener('click', function () {
                document.getElementById('filter-students-form').reset();
                loadStudents();
            });

            // Initial Load
            loadPaymentPeriodDetails();
            loadStudents();
        });
    </script>
@endsection

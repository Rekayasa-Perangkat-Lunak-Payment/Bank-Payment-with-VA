@extends('layout.app')

@section('title', 'Payment Periods')

@section('content')
    {{-- <div class="container mt-5"> --}}
    <h1>Payment Periods</h1>

    <!-- Filter and Search Form -->
    <form id="filter-form" class="mb-4">
        <div class="row">
            <div class="col-md-3">
                <input type="text" id="filter-institution" class="form-control" placeholder="Search by Institution Name">
            </div>
            <div class="col-md-3">
                <select id="filter-semester" class="form-control">
                    <option value="">Filter by Semester</option>
                    <option value="GANJIL">GANJIL</option>
                    <option value="GENAP">GENAP</option>
                </select>
            </div>
            <div class="col-md-3">
                <input type="number" id="filter-year" class="form-control" placeholder="Filter by Year">
            </div>
            <div class="col-md-3">
                <button type="button" id="filter-button" class="btn btn-primary">Search</button>
                <button type="button" id="reset-button" class="btn btn-secondary">Reset</button>
            </div>
        </div>
    </form>

    <!-- Add Payment Period Button -->
    <div class="mb-3">
        <button id="add-payment-period-button" class="btn btn-success" data-bs-toggle="modal"
            data-bs-target="#addPaymentPeriodModal">Add Payment Period</button>
    </div>

    <!-- Payment Periods Table -->
    <table class="table table-bordered" id="payment-periods-table">
        <thead>
            <tr>
                <th>Year</th>
                <th>Month</th>
                <th>Semester</th>
                <th>Institution</th>
                <th>Fixed Cost</th>
                <th>Credit Cost</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="payment-periods-table-body">
            <tr>
                <td colspan="7" class="text-center">Loading...</td>
            </tr>
        </tbody>
    </table>
    {{-- </div> --}}

    <!-- Modal for Adding Payment Period -->
    <!-- Modal for Adding Payment Period -->
    <div class="modal fade" id="addPaymentPeriodModal" tabindex="-1" aria-labelledby="addPaymentPeriodModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPaymentPeriodModalLabel">Add Payment Period</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form to Add Payment Period -->
                    <form id="add-payment-period-form">
                        <div class="mb-3">
                            <label for="institution-select" class="form-label">Institution</label>
                            <select id="institution-select" class="form-select" required>
                                <!-- Options will be populated dynamically -->
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="year" class="form-label">Year</label>
                            <input type="number" id="year" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="month" class="form-label">Month</label>
                            <select id="month" class="form-select" required>
                                <option value="01">January</option>
                                <option value="02">February</option>
                                <option value="03">March</option>
                                <option value="04">April</option>
                                <option value="05">May</option>
                                <option value="06">June</option>
                                <option value="07">July</option>
                                <option value="08">August</option>
                                <option value="09">September</option>
                                <option value="10">October</option>
                                <option value="11">November</option>
                                <option value="12">December</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="semester" class="form-label">Semester</label>
                            <select id="semester" class="form-select" required>
                                <option value="GANJIL">GANJIL</option>
                                <option value="GENAP">GENAP</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="fixed-cost" class="form-label">Fixed Cost</label>
                            <input type="number" id="fixed-cost" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="credit-cost" class="form-label">Credit Cost</label>
                            <input type="number" id="credit-cost" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Payment Period</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const apiUrl = '/api/paymentPeriod'; // API endpoint for payment periods
            const institutionApiUrl = '/api/institutions'; // API endpoint for institutions

            // Fetch and populate the institution select options
            function loadInstitutions() {
                fetch(institutionApiUrl)
                    .then(response => response.json())
                    .then(data => {
                        const institutionSelect = document.getElementById('institution-select');
                        institutionSelect.innerHTML = data.map(institution => `
                        <option value="${institution.id}">${institution.name}</option>
                    `).join('');
                    })
                    .catch(error => console.error('Error loading institutions:', error));
            }

            // Load payment periods with optional filters
            function loadPaymentPeriods(filters = {}) {
                const tbody = document.getElementById('payment-periods-table-body');
                tbody.innerHTML = '<tr><td colspan="7" class="text-center">Loading...</td></tr>';

                const params = new URLSearchParams(filters).toString();
                fetch(`${apiUrl}?${params}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.length === 0) {
                            tbody.innerHTML =
                                '<tr><td colspan="7" class="text-center">No payment periods found</td></tr>';
                            return;
                        }

                        tbody.innerHTML = data.map(paymentPeriod => `
                        <tr>
                            <td>${paymentPeriod.year}</td>
                            <td>${paymentPeriod.month}</td>
                            <td>${paymentPeriod.semester}</td>
                            <td>${paymentPeriod.institution.name}</td>
                            <td>${new Intl.NumberFormat('id-ID').format(paymentPeriod.fixed_cost)}</td>
                            <td>${new Intl.NumberFormat('id-ID').format(paymentPeriod.credit_cost)}</td>
                            <td>
                                <a href="/payment-periods/${paymentPeriod.id}/edit" class="btn btn-warning btn-sm">Edit</a>
                            </td>
                        </tr>
                    `).join('');
                    })
                    .catch(error => {
                        console.error('Error fetching payment periods:', error);
                        tbody.innerHTML =
                            '<tr><td colspan="7" class="text-center">Failed to load data</td></tr>';
                    });
            }

            // Handle form submit to add new payment period
            document.getElementById('add-payment-period-form').addEventListener('submit', function(e) {
                e.preventDefault();

                // Gather form data
                const data = {
                    institution_id: document.getElementById('institution-select').value,
                    year: document.getElementById('year').value,
                    month: document.getElementById('month').value,
                    semester: document.getElementById('semester').value,
                    fixed_cost: document.getElementById('fixed-cost').value,
                    credit_cost: document.getElementById('credit-cost').value,
                };

                // Debug: Check the data being sent to the API
                console.log('Form Data:', data);

                // Send data to the API
                fetch(apiUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(data),
                    })
                    .then(response => {
                        // Debug: Check if the response status is OK (e.g., 200)
                        console.log('Response status:', response.status);

                        if (!response.ok) {
                            // If response is not OK, log the error and throw an exception
                            console.error('Failed to add Payment Period: ', response.status);
                            throw new Error('Failed to add Payment Period');
                        }
                        return response.json();
                    })
                    .then(result => {
                        // Debug: Log the result from the API
                        console.log('API Response:', result);

                        if (result.success) {
                            alert('Payment Period added successfully');
                            $('#addPaymentPeriodModal').modal('hide');
                            loadPaymentPeriods();
                        } else {
                            // If the result indicates failure, log the error message
                            alert('Failed to add Payment Period');
                            console.error('Error message:', result.message);
                        }
                    })
                    .catch(error => {
                        // Debug: Log any errors that happen during the fetch request
                        console.error('Error adding payment period:', error);
                        alert('Failed to add Payment Period');
                    });
            });


            // Filter button click event
            document.getElementById('filter-button').addEventListener('click', function() {
                const filters = {
                    institution_name: document.getElementById('filter-institution').value,
                    semester: document.getElementById('filter-semester').value,
                    year: document.getElementById('filter-year').value,
                };
                loadPaymentPeriods(filters);
            });

            // Reset button click event
            document.getElementById('reset-button').addEventListener('click', function() {
                document.getElementById('filter-form').reset();
                loadPaymentPeriods();
            });

            // Initial load
            loadInstitutions();
            loadPaymentPeriods();
        });
    </script>
@endsection

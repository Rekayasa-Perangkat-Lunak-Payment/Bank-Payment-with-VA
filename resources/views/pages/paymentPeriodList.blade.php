@extends('layout.app')

@section('title', 'Payment Periods')
@section('page-title', 'Payment Period List')
@section('content')
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
                    <form id="add-payment-period-form">
                        <div class="mb-3">
                            <label for="institution-select" class="form-label">Institution</label>
                            <select id="institution-select" class="form-select" required></select>
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
                                <!-- Add other months here -->
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
        document.addEventListener("DOMContentLoaded", function () {
            const apiUrl = '/api/paymentPeriods';

            // Fetch and display payment periods
            function loadPaymentPeriods() {
                const tbody = document.getElementById('payment-periods-table-body');
                tbody.innerHTML = '<tr><td colspan="7" class="text-center">Loading...</td></tr>';

                fetch(apiUrl)
                    .then(response => response.json())
                    .then(data => {
                        if (data.length === 0) {
                            tbody.innerHTML = '<tr><td colspan="7" class="text-center">No payment periods found</td></tr>';
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
                                    <a href="/paymentPeriod/${paymentPeriod.id}" class="btn btn-primary btn-sm">
                                        View More
                                    </a>
                                </td>
                            </tr>
                        `).join('');
                    })
                    .catch(error => {
                        console.error('Error fetching payment periods:', error);
                        tbody.innerHTML = '<tr><td colspan="7" class="text-center">Failed to load data</td></tr>';
                    });
            }

            // Initial load
            loadPaymentPeriods();
        });
    </script>
@endsection

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
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const addPaymentPeriodForm = document.getElementById('add-payment-period-form');

            addPaymentPeriodForm.addEventListener('submit', function(event) {
                event.preventDefault();

                const year = document.getElementById('year').value;
                const month = document.getElementById('month').value;
                const semester = document.getElementById('semester').value;
                const fixedCost = document.getElementById('fixed-cost').value;
                const creditCost = document.getElementById('credit-cost').value;

                fetch('http://127.0.0.1:8000/api/paymentPeriods', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({
                            institution_id: localStorage.getItem('institution_id'),
                            year: year,
                            month: parseInt(month, 10),
                            semester: semester,
                            fixed_cost: fixedCost,
                            credit_cost: creditCost,
                        }),
                    })
                    .then(response => {
                        console.log('Response Status:', response.status); // Log response status
                        if (!response.ok) {
                            throw new Error('Failed to submit form');
                        }else{
                            alert("Payment period added succesfully.");
                            window.location.href = '/paymentPeriodList';
                        }
                        return response.json();
                    })
                    .catch(error => console.error('Error creating payment period:', error));
            });


            const institution_id = localStorage.getItem('institution_id');
            const apiUrl = '/api/paymentPeriods/institution/' + institution_id;

            // Fetch and display payment periods
            function loadPaymentPeriods() {
                const tbody = document.getElementById('payment-periods-table-body');
                tbody.innerHTML = '<tr><td colspan="7" class="text-center">Loading...</td></tr>';

                fetch(apiUrl)
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
                                    <a href="/paymentPeriod/${paymentPeriod.id}" class="btn btn-primary btn-sm">
                                        View More
                                    </a>
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

            // Initial load
            loadPaymentPeriods();
        });
    </script>
@endsection

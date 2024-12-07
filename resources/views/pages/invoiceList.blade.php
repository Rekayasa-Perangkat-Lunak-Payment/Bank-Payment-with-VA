@extends('layout.app')

@section('title', 'Invoice List')

@section('content')
    {{-- <div class="container mt-5"> --}}
    {{-- <div class="d-flex justify-content-between align-items-center mb-1">
        <h1 class="text-primary">Invoice List</h1>
    </div> --}}

    <!-- Filters -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form id="filter-form" class="row g-3">
                <div class="col-md-3">
                    <input type="text" id="filter-student-name" class="form-control" placeholder="Search by Student Name">
                </div>
                <div class="col-md-3">
                    <select id="filter-semester" class="form-select">
                        <option value="" selected>Filter by Semester</option>
                        <option value="GANJIL">GANJIL</option>
                        <option value="GENAP">GENAP</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="number" id="filter-year" class="form-control" placeholder="Filter by Year">
                </div>
                <div class="col-md-3 d-flex">
                    <button type="button" id="filter-button" class="btn btn-primary me-2 w-100">Search</button>
                    <button type="button" id="reset-button" class="btn btn-secondary w-100">Reset</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Invoice Table -->
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover table-bordered mb-0">
                <thead class="table-primary">
                    <tr>
                        <th>Virtual Account</th>
                        <th>Student</th>
                        <th>Payment Period</th>
                        <th>Total Amount</th>
                        <th>Status</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody id="invoice-table-body">
                    <tr>
                        <td colspan="6" class="text-center py-4">Loading...</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal for Invoice Details -->
    <div class="modal fade" id="invoiceDetailsModal" tabindex="-1" aria-labelledby="invoiceDetailsLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-primary" id="invoiceDetailsLabel">Invoice Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="invoice-details-content" class="p-3"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    {{-- </div> --}}
@endsection

@section('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const apiUrl = '/api/virtualAccounts';

            function loadInvoices(filters = {}) {
                const tbody = document.getElementById('invoice-table-body');
                tbody.innerHTML = '<tr><td colspan="6" class="text-center py-4">Loading...</td></tr>';

                const params = new URLSearchParams(filters).toString();
                fetch(`${apiUrl}?${params}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.length === 0) {
                            tbody.innerHTML =
                                '<tr><td colspan="6" class="text-center py-4">No invoices found</td></tr>';
                            return;
                        }

                        tbody.innerHTML = data.map(virtual_account => `
                        <tr>
                            <td>${virtual_account.virtual_account_number}</td>
                            <td>${virtual_account.invoice.student.name}</td>
                            <td>${virtual_account.invoice.payment_period.semester} ${virtual_account.invoice.payment_period.year}</td>
                            <td>${new Intl.NumberFormat('id-ID').format(virtual_account.total_amount)}</td>
                            <td>
                                <span class="badge ${getStatusBadgeClass(virtual_account.status)}">
                                    ${virtual_account.status}
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-info btn-sm" onclick="viewDetails(${virtual_account.id})">View Details</button>
                            </td>
                        </tr>
                    `).join('');
                    })
                    .catch(error => {
                        console.error('Error fetching invoices:', error);
                        tbody.innerHTML =
                            '<tr><td colspan="6" class="text-center py-4">Failed to load data</td></tr>';
                    });
            }

            function getStatusBadgeClass(status) {
                switch (status) {
                    case 'Paid':
                        return 'bg-success text-white';
                    case 'Expired':
                        return 'bg-danger text-white';
                    case 'Unpaid':
                    default:
                        return 'bg-warning text-dark';
                }
            }

            window.viewDetails = function(virtual_account_id) {
                fetch(`${apiUrl}/${virtual_account_id}`)
                    .then(response => response.json())
                    .then(virtual_account => {
                        const statusBadgeClass = getStatusBadgeClass(virtual_account.status);

                        const content = `
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title text-primary mb-3">Invoice Details</h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between">
                                <span><strong>Student</strong></span>
                                <span>${virtual_account.invoice.student.name}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span><strong>Payment Period</strong></span>
                                <span>${virtual_account.invoice.payment_period.semester} ${virtual_account.invoice.payment_period.year}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span><strong>Total Amount</strong></span>
                                <span>${new Intl.NumberFormat('id-ID').format(virtual_account.total_amount)}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span><strong>Status</strong></span>
                                <span class="badge ${statusBadgeClass}">${virtual_account.status}</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="card shadow-sm mt-4">
                    <div class="card-body">
                        <h5 class="card-title text-primary">Invoice Items</h5>
                        <ul class="list-group">
                            ${virtual_account.invoice.invoice_items.map(item => `
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <span>${item.description}</span>
                                            <small class="text-muted d-block">${item.item_type?.name || ''}</small>
                                        </div>
                                        <span>
                                            <strong>${item.quantity}</strong> x ${new Intl.NumberFormat('id-ID').format(item.price)}
                                        </span>
                                    </li>
                                `).join('')}
                        </ul>
                    </div>
                </div>
            `;

                        document.getElementById('invoice-details-content').innerHTML = content;

                        const modal = new bootstrap.Modal(document.getElementById('invoiceDetailsModal'));
                        modal.show();
                    })
                    .catch(error => {
                        console.error('Error fetching invoice details:', error);
                        alert('Failed to load invoice details.');
                    });
            };

            document.getElementById('filter-button').addEventListener('click', function() {
                const filters = {
                    student_name: document.getElementById('filter-student-name').value,
                    semester: document.getElementById('filter-semester').value,
                    year: document.getElementById('filter-year').value,
                };
                loadInvoices(filters);
            });

            document.getElementById('reset-button').addEventListener('click', function() {
                document.getElementById('filter-form').reset();
                loadInvoices();
            });

            loadInvoices();
        });
    </script>
@endsection

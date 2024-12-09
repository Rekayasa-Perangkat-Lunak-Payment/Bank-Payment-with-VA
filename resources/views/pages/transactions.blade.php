@extends('layout.app')

@section('title', 'Transactions')

@section('page-title', 'Transaction Overview')

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Transaction</h4>

                    <!-- Search Box -->
                    <input type="text" id="search-input" class="form-control mb-3" placeholder="Search Transactions">

                    <!-- Filter Dropdown -->
                    <select id="status-filter" class="form-control mb-3">
                        <option value="">Filter by Status</option>
                        <option value="Paid">Paid</option>
                        <option value="Unpaid">Unpaid</option>
                        <option value="Expired">Expired</option>
                    </select>

                    <table id="transactions-table" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                @foreach (['ID', 'VA Number', 'Student Name', 'Institution', 'Period', 'Total', 'Status'] as $column)
                                    <th class="sortable">{{ $column }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody id="transactions-body">
                            <!-- Data will be populated here using JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        let transactionsData = [];

        // Function to fetch transactions data and populate the table
        async function fetchTransactions() {
            try {
                const response = await fetch('/api/transactions');
                transactionsData = await response.json();
                renderTable(transactionsData);
            } catch (error) {
                console.error('Error fetching transactions:', error);
            }
        }

        // Function to render table based on data
        function renderTable(data) {
            const transactionsBody = document.getElementById('transactions-body');
            transactionsBody.innerHTML = ''; // Clear the table body before adding new rows

            data.forEach(transaction => {
                const row = document.createElement('tr');

                row.innerHTML = ` 
                    <td>${transaction.id}</td>
                    <td>${transaction.virtual_account?.virtual_account_number ?? 'N/A'}</td>
                    <td>${transaction.virtual_account?.invoice?.student?.name ?? 'N/A'}</td>
                    <td>${transaction.virtual_account?.invoice?.payment_period?.institution?.name ?? 'N/A'}</td>
                    <td>${transaction.virtual_account?.invoice?.payment_period?.year ?? 'N/A'} (${transaction.virtual_account?.invoice?.payment_period?.semester ?? 'N/A'})</td>
                    <td>Rp. ${new Intl.NumberFormat('id-ID').format(transaction.total)}</td>
                    <td>
                        <span class="badge" style="background-color: ${
                            transaction.virtual_account?.status === 'Paid' ? '#28a745' :
                            transaction.virtual_account?.status === 'Expired' ? '#dc3545' :
                            transaction.virtual_account?.status === 'Unpaid' ? '#ffc107' : '#6c757d'
                        }; color: white;">
                            ${transaction.virtual_account?.status ? transaction.virtual_account.status.charAt(0).toUpperCase() + transaction.virtual_account.status.slice(1) : 'Unknown'}
                        </span>
                    </td>
                `;

                transactionsBody.appendChild(row);
            });
        }

        // Function to search the table based on the search input
        function searchTable() {
            const searchTerm = document.getElementById('search-input').value.toLowerCase();
            const filteredData = transactionsData.filter(transaction => {
                return (
                    transaction.id.toString().includes(searchTerm) ||
                    (transaction.virtual_account?.virtual_account_number ?? '').toLowerCase().includes(searchTerm) ||
                    (transaction.virtual_account?.invoice?.student?.name ?? '').toLowerCase().includes(searchTerm) ||
                    (transaction.virtual_account?.invoice?.payment_period?.institution?.name ?? '').toLowerCase().includes(searchTerm) ||
                    (transaction.virtual_account?.invoice?.payment_period?.year ?? '').toString().includes(searchTerm) ||
                    (transaction.virtual_account?.invoice?.payment_period?.semester ?? '').toLowerCase().includes(searchTerm) ||
                    transaction.total.toString().includes(searchTerm)
                );
            });
            renderTable(filteredData);
        }

        // Function to filter the table by status
        function filterByStatus() {
            const status = document.getElementById('status-filter').value;
            const filteredData = status ? transactionsData.filter(transaction => transaction.virtual_account?.status === status) : transactionsData;
            renderTable(filteredData);
        }

        // Function to sort the table by column
        function sortTable(index) {
            const sortedData = [...transactionsData];
            sortedData.sort((a, b) => {
                const valueA = Object.values(a)[index];
                const valueB = Object.values(b)[index];

                if (typeof valueA === 'string') {
                    return valueA.localeCompare(valueB);
                } else if (typeof valueA === 'number') {
                    return valueA - valueB;
                }
                return 0;
            });
            renderTable(sortedData);
        }

        // Add event listeners
        document.getElementById('search-input').addEventListener('input', searchTable);
        document.getElementById('status-filter').addEventListener('change', filterByStatus);

        // Add sort functionality to table headers
        const headers = document.querySelectorAll('#transactions-table th');
        headers.forEach((header, index) => {
            header.addEventListener('click', () => sortTable(index));
        });

        // Fetch the transactions when the page is loaded
        document.addEventListener('DOMContentLoaded', fetchTransactions);
    </script>
@endsection

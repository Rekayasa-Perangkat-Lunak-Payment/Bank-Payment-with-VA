@extends('layout.app')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard')

@section('content')
    <div class="container-fluid">
        <div class="row">
        </div>
        <!-- Kotak Atas -->
        <div class="row" id="card-section">
            <span class="text-center">
                Loading...
            </span>
        </div>
        <!-- End Kotak Atas -->

        <!-- Tabel Riwayat Transaksi -->
        <div class="row mt-4">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <!-- Search input for Transactions -->
                        <div class="mb-3">
                            <input type="text" id="transactionSearchInput" class="form-control"
                                placeholder="Search for Transaction ID or VA Number...">
                        </div>
                        <table class="table table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Virtual Account Number</th>
                                    <th>Transaction Date</th>
                                    <th>Total</th>
                                    <th>Student</th>
                                    <th id="institutionHeader">Institution</th>
                                </tr>
                            </thead>
                            <tbody id="transactions-table-body">
                                <!-- Data will be inserted here dynamically -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


        <!-- Tabel Riwayat Transaksi -->
        <div class="row mt-4">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <!-- Search input -->
                        <div class="mb-3">
                            <input type="text" id="searchInput" class="form-control"
                                placeholder="Search for Virtual Account...">
                        </div>
                        <table id="virtual-accounts-table" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Virtual Account Number</th>
                                    <th id="institutionHeader">Institution</th>
                                    <th>Student Name</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody id="virtual-accounts-table-body">
                                {{-- <tr><td colspan="5" class="text-center">No data available</td></tr> --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Tabel Riwayat Transaksi -->
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            async function fetchTransactions(institutionId, paymentPeriodId) {
                try {
                    const response = await fetch(
                        `http://127.0.0.1:8000/api/transactions/institution/${institutionId}/paymentPeriod/${paymentPeriodId}`
                    );
                    const transactions = await response.json();

                    return transactions.data || [];
                } catch (error) {
                    console.error('Error fetching transactions:', error);
                    return [];
                }
            }

            async function fetchAllTransactions() {
                try {
                    const response = await fetch(
                        `http://127.0.0.1:8000/api/transactions`
                    );
                    const transactions = await response.json();

                    return transactions.data || [];
                } catch (error) {
                    console.error('Error fetching transactions:', error);
                    return [];
                }
            }

            async function fetchAllVirtualAccounts() {
                try {
                    const response = await fetch(
                        `http://127.0.0.1:8000/api/virtualAccounts`
                    );
                    const virtualAccounts = await response.json();
                    console.log("fetching all virtual accounts");
                    console.log(virtualAccounts);
                    return virtualAccounts.data || [];
                } catch (error) {
                    console.error('Error fetching virtual accounts:', error);
                    return [];
                }
            }

            async function countActiveVirtualAccounts() {
                try {
                    const institutionId = localStorage.getItem('institution_id');
                    if (!institutionId) {
                        console.error('Institution ID not found in localStorage');
                        return 0;
                    }

                    const response = await fetch(
                        `http://127.0.0.1:8000/api/virtualAccounts/institution/${institutionId}`);
                    const virtualAccounts = await response.json();

                    const activeVaCount = virtualAccounts.filter(va => va.is_active === 1).length;
                    console.log(
                        `Active Virtual Accounts for Institution ID ${institutionId}: ${activeVaCount}`);
                    return activeVaCount || 0;
                } catch (error) {
                    console.error('Error fetching virtual accounts:', error);
                    return 0;
                }
            }

            async function countInstitution() {
                try {
                    const response = await fetch(
                        `http://127.0.0.1:8000/api/institutions`);
                    const institutions = await response.json();

                    const institutionCount = institutions.length;
                    console.log(`Total Institutions: ${institutionCount}`);
                    return institutionCount || 0;
                } catch (error) {
                    console.error('Error fetching institutions:', error);
                    return 0;
                }
            }

            async function countTransaction() {
                try {
                    const response = await fetch(
                        `http://127.0.0.1:8000/api/transactions`);
                    const transactions = await response.json();

                    const transactionCount = transactions.data.length;
                    console.log(`Total Transactions: ${transactionCount}`);
                    return transactionCount || 0;
                } catch (error) {
                    console.error('Error fetching transactions:', error);
                    return 0;
                }
            }


            async function countVirtualAccounts() {
                try {
                    const response = await fetch(
                        `http://127.0.0.1:8000/api/virtualAccounts`);
                    const virtualAccounts = await response.json();

                    const virtualAccountCount = virtualAccounts.data.length;
                    console.log(`Total Virtual Accounts: ${virtualAccountCount}`);
                    return virtualAccountCount || 0;
                } catch (error) {
                    console.error('Error fetching virtual accounts:', error);
                    return 0;
                }
            }

            async function fetchPaymentPeriod(institutionId) {
                try {
                    const response = await fetch(
                        `http://127.0.0.1:8000/api/paymentPeriods/institution/${institutionId}`);
                    const paymentPeriods = await response.json();

                    const latestPaymentPeriod = paymentPeriods[0];
                    console.log(
                        `Latest Payment Period for Institution ID ${institutionId}: ${latestPaymentPeriod}`);
                    return latestPaymentPeriod;
                } catch (error) {
                    console.error('Error fetching payment period:', error);
                    return null;
                }
            }

            async function fetchBalance(institutionId) {
                try {
                    const response = await fetch(
                        `http://127.0.0.1:8000/api/institutions/${institutionId}`);
                    const institution = await response.json();

                    const balance = institution.balance;
                    return balance || 0;
                } catch (error) {
                    console.error('Error fetching balance:', error);
                    return null;
                }
            }

            async function fetchVirtualAccounts(institutionId, paymentPeriodId) {
                try {
                    const response = await fetch(
                        `http://127.0.0.1:8000/api/virtualAccounts/institution/${institutionId}/paymentPeriod/${paymentPeriodId}`
                    );
                    const virtualAccounts = await response.json();
                    return virtualAccounts || [];
                } catch (error) {
                    console.error('Error fetching virtual accounts:', error);
                    return [];
                }
            }

            async function loadDashboard() {
                const institutionId = localStorage.getItem('institution_id');
                if (!institutionId) {
                    console.error('Institution ID not found in localStorage');
                    return;
                }

                const activeVa = await countActiveVirtualAccounts();
                const balance = await fetchBalance(institutionId);
                const totalInstitution = await countInstitution();
                const totalVirtualAccounts = await countVirtualAccounts();
                const totalTransaction = await countTransaction();

                let paymentPeriod = await fetchPaymentPeriod(institutionId);
                if (paymentPeriod === null) {
                    paymentPeriod = {
                        'year': 'N/A',
                        'month': 'N/A',
                        'semester': 'N/A'
                    };
                }

                const virtualAccounts = await fetchVirtualAccounts(institutionId, paymentPeriod.id);
                const transactions = await fetchTransactions(institutionId, paymentPeriod.id);
                const allTransactions = await fetchAllTransactions();
                const allVirtualAccounts = await fetchAllVirtualAccounts();
                console.log("initializing...");
                console.log(allVirtualAccounts);
                return {
                    activeVa,
                    paymentPeriod,
                    balance,
                    virtualAccounts,
                    transactions,
                    totalInstitution,
                    totalVirtualAccounts,
                    totalTransaction,
                    allTransactions,
                    allVirtualAccounts
                };
            }

            const role = localStorage.getItem('role');
            const cardSection = document.getElementById('card-section');
            const tableBody = document.getElementById('virtual-accounts-table-body');
            const searchInput = document.getElementById('searchInput');
            const transactionSearchInput = document.getElementById('transactionSearchInput');
            const transactionsTableBody = document.getElementById('transactions-table-body');

            const institutionAdminContent = `
                <!-- Total Tagihan -->
                <div class="col-xl-3 col-md-6">
                    <div class="card h-60">
                        <div class="card-body p-4" id="card-1">
                            <div class="d-flex justify-content-between">
                                <h3 class="mb-3">Balance</h3>
                                <i class="fa fa-file-invoice" style="font-size: 30px; color: #17a2b8;"></i>
                            </div>
                            <h5 class="text-muted font-size-12">Your institution balance</h5>
                            <h3 class="mb-3" id="balance">Loading...</h3>
                        </div>
                    </div>
                </div>

                <!-- Total SKS -->
                <div class="col-xl-3 col-md-6">
                    <div class="card h-70">
                        <div class="card-body p-4" id="card-2">
                            <div class="d-flex justify-content-between">
                                <h3 class="mb-3">Active VA</h3>
                                <i class="fa fa-book" style="font-size: 30px; color: #007bff;"></i>
                            </div>
                            <h5 class="text-muted font-size-12">Unpaid VA</h5>
                            <h3 class="mb-3" id="active-va">Loading...</h3>
                        </div>
                    </div>
                </div>

                <!-- Tanggal Pembayaran -->
                <div class="col-xl-6 col-md-6">
                    <div class="card h-70">
                        <div class="card-body p-4" id="card-3">
                            <div class="d-flex justify-content-between">
                                <h3 class="mb-3">Payment Period</h3>
                                <i class="fa fa-calendar" style="font-size: 30px; color: #ffc107;"></i>
                            </div>
                            <h5 class="text-muted font-size-12">Current Active Payment Period</h5>
                            <h3 class="mb-3" id="payment-period">Loading...</h3>
                        </div>
                    </div>
                </div>
            `;

            const bankAdminContent = `
                <!-- Total Tagihan -->
                <div class="col-xl-3 col-md-6">
                    <div class="card h-60">
                        <div class="card-body p-4" id="card-1">
                            <div class="d-flex justify-content-between">
                                <h3 class="mb-3">Institutions</h3>
                                <i class="fa fa-file-invoice" style="font-size: 30px; color: #17a2b8;"></i>
                            </div>
                            <h5 class="text-muted font-size-12">Count of institutions</h5>
                            <h3 class="mb-3" id="count-institutions">Loading...</h3>
                        </div>
                    </div>
                </div>

                <!-- Total SKS -->
                <div class="col-xl-5 col-md-6">
                    <div class="card h-70">
                        <div class="card-body p-4" id="card-2">
                            <div class="d-flex justify-content-between">
                                <h3 class="mb-3">Virtual Account Created</h3>
                                <i class="fa fa-book" style="font-size: 30px; color: #007bff;"></i>
                            </div>
                            <h5 class="text-muted font-size-12">Total Virtual Account Created</h5>
                            <h3 class="mb-3" id="va-created">Loading...</h3>
                        </div>
                    </div>
                </div>

                <!-- Tanggal Pembayaran -->
                <div class="col-xl-4 col-md-6">
                    <div class="card h-70">
                        <div class="card-body p-4" id="card-3">
                            <div class="d-flex justify-content-between">
                                <h3 class="mb-3">Transactions</h3>
                                <i class="fa fa-calendar" style="font-size: 30px; color: #ffc107;"></i>
                            </div>
                            <h5 class="text-muted font-size-12">Total Count of Transactions</h5>
                            <h3 class="mb-3" id="count-transactions">Loading...</h3>
                        </div>
                    </div>
                </div>
            `;

            async function renderCardSection(
                activeVa = null, paymentPeriod = null, balance = null, virtualAccounts = null,
                totalInstitutions = null, totalTransactions = null, totalVaCreated = null, allVirtualAccounts = null
            ) {
                console.log("rendering card section");
                console.log(allVirtualAccounts)
                if (role === 'institution_admin') {
                    const institutionHeader = document.getElementById('institutionHeader');
                    institutionHeader.style.display = 'hidden';
                    cardSection.innerHTML = institutionAdminContent;

                    const activeVaElement = document.getElementById('active-va');
                    if (activeVaElement) {
                        activeVaElement.textContent = activeVa;
                    }

                    const paymentPeriodElement = document.getElementById('payment-period');
                    if (paymentPeriodElement && paymentPeriod) {
                        paymentPeriodElement.textContent =
                            `${paymentPeriod.year} - ${paymentPeriod.month} - ${paymentPeriod.semester}`;
                    }

                    const balanceElement = document.getElementById('balance');
                    if (balanceElement) {
                        balanceElement.textContent = new Intl.NumberFormat('id-ID').format(balance);
                    }

                    tableBody.innerHTML = '';
                    virtualAccounts.forEach(va => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${va.virtual_account_number}</td>
                            <td>${va.invoice.student.name ?? 'N/A'}</td>
                            <td>Rp. ${new Intl.NumberFormat('id-ID').format(va.total_amount)}</td>
                            <td>
                                <span class="badge" style="background-color: ${
                                    va.status === 'Paid' ? '#28a745' :
                                    va.status === 'Expired' ? '#dc3545' :
                                    va.status === 'Unpaid' ? '#ffc107' : '#6c757d'
                                }; color: white;">
                                    ${va.status ? va.status.charAt(0).toUpperCase() + va.status.slice(1) : 'Unknown'}
                                </span>
                            </td>
                        `;
                        tableBody.appendChild(row);
                    });
                } else {
                    cardSection.innerHTML = bankAdminContent;
                    const institutionHeader = document.getElementById('institutionHeader');
                    institutionHeader.style.display = 'show';
                    const countInstitutionsElement = document.getElementById('count-institutions');
                    if (countInstitutionsElement) {
                        countInstitutionsElement.textContent = totalInstitutions;
                    }

                    const vaCreatedElement = document.getElementById('va-created');
                    if (vaCreatedElement) {
                        vaCreatedElement.textContent = totalVaCreated;
                    }

                    const countTransactionsElement = document.getElementById('count-transactions');
                    if (countTransactionsElement) {
                        countTransactionsElement.textContent = totalTransactions;
                    }

                    tableBody.innerHTML = '';
                    allVirtualAccounts.forEach(va => {
                        const row = document.createElement('tr');
                        // Safely access nested data with optional chaining
                        const virtualAccountNumber = va.virtual_account_number ||
                            'N/A';
                        const studentName = va.invoice?.student?.name || 'N/A';
                        const institutionName = va.invoice?.payment_period
                            ?.institution?.name || 'N/A';
                        const formattedTotalAmount = new Intl.NumberFormat('id-ID').format(va.total_amount);
                        const status = va.status || 'Unknown';

                        row.innerHTML = `
        <td>${virtualAccountNumber}</td>
        <td>${studentName}</td>
        <td>${institutionName}</td>
        <td>Rp. ${formattedTotalAmount}</td>
        <td>
            <span class="badge" style="background-color: ${
                status === 'Paid' ? '#28a745' :
                status === 'Expired' ? '#dc3545' :
                status === 'Unpaid' ? '#ffc107' : '#6c757d'
            }; color: white;">
                ${status}
            </span>
        </td>
    `;

                        tableBody.appendChild(row);
                    });
                }
            }

            async function renderTransactionTable(transactions = null, allTransactions = null) {
                console.log(allTransactions);
                if (role === 'institution_admin') {
                    const institutionHeader = document.getElementById('institutionHeader');
                    institutionHeader.style.display = 'hidden';
                    const tableBody = document.getElementById('transactions-table-body');
                    if (transactions) {
                        transactionsTableBody.innerHTML = '';
                        transactions.forEach(transaction => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                    <td>${transaction.id}</td>
                    <td>${transaction.virtual_account.virtual_account_number}</td>
                    <td>${transaction.transaction_date}</td>
                    <td>Rp. ${new Intl.NumberFormat('id-ID').format(transaction.total)}</td>
                    <td>
                        ${transaction.virtual_account.invoice.student.name ?? 'N/A'}
                    </td>
                    `;
                            tableBody.appendChild(row);
                        });
                    } else {
                        transactionsTableBody.innerHTML =
                            '<tr><td colspan="5" class="text-center">No data available</td></tr>';
                    }
                } else {
                    const tableBody = document.getElementById('transactions-table-body');
                    const institutionHeader = document.getElementById('institutionHeader');
                    institutionHeader.style.display = 'show';
                    if (allTransactions) {
                        transactionsTableBody.innerHTML = '';
                        allTransactions.forEach(transaction => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                    <td>${transaction.id}</td>
                    <td>${transaction.virtual_account.virtual_account_number}</td>
                    <td>${transaction.transaction_date}</td>
                    <td>Rp. ${new Intl.NumberFormat('id-ID').format(transaction.total)}</td>
                    <td>
                        ${transaction.virtual_account.invoice.student.name ?? 'N/A'}
                    </td>
                    <td>
                        ${transaction.virtual_account.invoice.payment_period.institution.name ?? 'N/A'}
                    </td>
                    `;
                            tableBody.appendChild(row);
                        });
                    } else {
                        transactionsTableBody.innerHTML =
                            '<tr><td colspan="5" class="text-center">No data available</td></tr>';
                    }
                }

            }

            // Add search functionality for transactions
            transactionSearchInput.addEventListener('input', function() {
                const filter = transactionSearchInput.value.toLowerCase();
                const rows = transactionsTableBody.getElementsByTagName('tr');
                Array.from(rows).forEach(row => {
                    const cells = row.getElementsByTagName('td');
                    const textContent = Array.from(cells)
                        .map(cell => cell.textContent.toLowerCase())
                        .join(' ');
                    if (textContent.includes(filter)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });

            // Add search functionality
            searchInput.addEventListener('input', function() {
                const filter = searchInput.value.toLowerCase();
                const rows = tableBody.getElementsByTagName('tr');
                Array.from(rows).forEach(row => {
                    const cells = row.getElementsByTagName('td');
                    const textContent = Array.from(cells)
                        .map(cell => cell.textContent.toLowerCase())
                        .join(' ');
                    if (textContent.includes(filter)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });

            loadDashboard().then(dashboardData => {
                renderCardSection(
                    dashboardData.activeVa,
                    dashboardData.paymentPeriod,
                    dashboardData.balance,
                    dashboardData.virtualAccounts,
                    dashboardData.totalInstitution,
                    dashboardData.totalVirtualAccounts,
                    dashboardData.totalTransaction,
                    dashboardData.allVirtualAccounts
                );

                renderTransactionTable(dashboardData.transactions, dashboardData.allTransactions);
            }).catch(error => {
                console.error('Error loading dashboard:', error);
            });
        });
    </script>
@endsection

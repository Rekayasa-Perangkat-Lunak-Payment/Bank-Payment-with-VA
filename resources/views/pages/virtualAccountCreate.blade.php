@extends('layout.app')

@section('title', 'Bulk Create Virtual Accounts')

@section('content')
    <h1>Create Virtual Accounts</h1>
    <h5>Institution: <span id="institution-name"></span></h5>
    <h5>Payment Period: <span id="payment-period-details"></span></h5>

    <!-- Filter Section -->
    <form id="filter-form" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <select id="filter-year" class="form-control">
                    <option value="">Select Year</option>
                </select>
            </div>
            <div class="col-md-4">
                <select id="filter-major" class="form-control">
                    <option value="">Select Major</option>
                </select>
            </div>
            <div class="col-md-4">
                <button type="button" id="apply-filters" class="btn btn-primary">Apply Filters</button>
                <button type="button" id="clear-filters" class="btn btn-secondary">Clear Filters</button>
            </div>
        </div>
    </form>

    <!-- Bulk Create Form -->
    <form id="bulk-create-form">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th><input type="checkbox" id="select-all-checkbox"></th>
                    <th>Student Name</th>
                    <th>Major</th>
                    <th>Invoices and Invoice Items</th>
                </tr>
            </thead>
            <tbody id="students-table">
                <!-- Populated via JavaScript -->
            </tbody>
        </table>

        <!-- Credit and Fixed Cost Inputs -->
        <div class="form-group">
            <label for="credit-cost">Credit Cost</label>
            <input type="number" id="credit-cost" class="form-control" name="credit_cost" placeholder="Enter credit cost"
                required>
        </div>

        <div class="form-group">
            <label for="fixed-cost">Fixed Cost</label>
            <input type="number" id="fixed-cost" class="form-control" name="fixed_cost" placeholder="Enter fixed cost"
                required>
        </div>

        <button type="submit" class="btn btn-primary">Generate Virtual Accounts</button>
    </form>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const paymentPeriodId = {{ $paymentPeriodId }};
            const apiUrl = `/api/students/paymentPeriod/${paymentPeriodId}`;
            const institutionNameElement = document.getElementById('institution-name');
            const paymentPeriodDetailsElement = document.getElementById('payment-period-details');
            const form = document.getElementById('bulk-create-form');
            const tableBody = document.getElementById('students-table');
            const filterYear = document.getElementById('filter-year');
            const filterMajor = document.getElementById('filter-major');
            const selectAllCheckbox = document.getElementById('select-all-checkbox');
            const creditCostInput = document.getElementById('credit-cost');
            const fixedCostInput = document.getElementById('fixed-cost');
            const institutionId = {{ $institutionId }}; // Assuming the institution ID is passed to the page

            // Fetch institution and payment period details
            function loadInstitutionAndPaymentPeriod() {
                fetch(`/api/paymentPeriod/${paymentPeriodId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.institution) {
                            institutionNameElement.textContent = data.institution.name;
                            paymentPeriodDetailsElement.textContent =
                                `${data.month} - ${data.year} - ${data.semester}`;
                        } else {
                            institutionNameElement.textContent = 'Institution information not available';
                            paymentPeriodDetailsElement.textContent =
                                'Payment period information not available';
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching institution and payment period:', error);
                        institutionNameElement.textContent = 'Failed to load institution data';
                        paymentPeriodDetailsElement.textContent = 'Failed to load payment period data';
                    });
            }

            // Fetch available years and majors for the filter options
            function loadFilterOptions() {
                fetch(`/api/available-filter-options/${paymentPeriodId}`)
                    .then(response => response.json())
                    .then(data => {
                        const years = data.years || [];
                        const majors = data.majors || [];

                        // Populate Year dropdown
                        years.forEach(year => {
                            const option = document.createElement('option');
                            option.value = year;
                            option.textContent = year;
                            filterYear.appendChild(option);
                        });

                        // Populate Major dropdown
                        majors.forEach(major => {
                            const option = document.createElement('option');
                            option.value = major;
                            option.textContent = major;
                            filterMajor.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error fetching filter options:', error));
            }

            // Fetch ItemTypes for the institution
            function loadItemTypes() {
                return fetch(`/api/institution/${institutionId}/itemTypes`)
                    .then(response => response.json())
                    .then(data => {
                        if (data && Array.isArray(data)) {
                            return data;
                        } else {
                            console.error('ItemTypes not found for institution');
                            return []; // Return an empty array if no data or invalid data
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching item types:', error);
                        return []; // Return an empty array in case of error
                    });
            }

            // Function to add an invoice item for a student
            window.addInvoiceItem = function(studentId) {
                const invoiceItemsContainer = document.getElementById(`invoice-items-container-${studentId}`);
                loadItemTypes().then(itemTypes => {
                    const newItemHTML = `
                        <div class="invoice-item">
                            <select name="invoice_item_type[${studentId}][]" class="form-control">
                                <option value="">Select Item Type</option>
                                ${itemTypes.map(itemType => `
                                            <option value="${itemType.id}">${itemType.name}</option>
                                        `).join('')}
                            </select>
                            <input type="text" name="invoice_item_description[${studentId}][]" placeholder="Description" class="form-control">
                            <input type="number" name="invoice_item_amount[${studentId}][]" placeholder="Amount" class="form-control">
                            <button type="button" class="btn btn-danger" onclick="removeInvoiceItem(this)">Remove</button>
                        </div>
                    `;
                    invoiceItemsContainer.insertAdjacentHTML('beforeend', newItemHTML);
                });
            };

            // Function to remove an invoice item
            window.removeInvoiceItem = function(button) {
                button.parentElement.remove();
            };

            // Fetch students with applied filters, including invoices and items (if applicable)
            async function fetchStudents() {
                const selectedYear = filterYear.value;
                const selectedMajor = filterMajor.value;

                let filterParams = {};

                if (selectedYear) {
                    filterParams.year = selectedYear;
                }
                if (selectedMajor) {
                    filterParams.major = selectedMajor;
                }

                const queryString = new URLSearchParams(filterParams).toString();
                const url = queryString ? `${apiUrl}?${queryString}` : apiUrl;

                try {
                    const response = await fetch(url);
                    const students = await response.json();

                    if (students.length === 0) {
                        tableBody.innerHTML =
                            `<tr><td colspan="5" class="text-center">No students found for this filter.</td></tr>`;
                        return;
                    }

                    tableBody.innerHTML = students.map(student => `
                        <tr>
                            <td><input type="checkbox" class="student-checkbox" name="students[]" value="${student.id}"></td>
                            <td>${student.name}</td>
                            <td>${student.major}</td>
                            <td>
                                <div id="invoices-${student.id}">
                                    <label>Select Invoice Items for Student #${student.id}:</label>
                                    <div class="invoice-items-container" id="invoice-items-container-${student.id}">
                                        <!-- Invoice item select fields will be added here dynamically -->
                                    </div>
                                    <button type="button" class="btn btn-secondary" onclick="addInvoiceItem(${student.id})">Add Invoice Item</button>
                                </div>
                            </td>
                        </tr>
                    `).join('');
                } catch (error) {
                    console.error('Error fetching students:', error);
                    tableBody.innerHTML =
                        `<tr><td colspan="5" class="text-center text-danger">Failed to load students. Please try again later.</td></tr>`;
                }
            }

            // Handle Select All checkbox toggle
            selectAllCheckbox.addEventListener('change', function() {
                const isChecked = selectAllCheckbox.checked;
                const studentCheckboxes = document.querySelectorAll('.student-checkbox');
                studentCheckboxes.forEach(checkbox => {
                    checkbox.checked = isChecked;
                });
            });

            // Event listeners for filter changes
            filterYear.addEventListener('change', fetchStudents);
            filterMajor.addEventListener('change', fetchStudents);

            // Initial data load
            loadInstitutionAndPaymentPeriod();
            loadFilterOptions();
            fetchStudents();

            // Handle form submission for bulk creation
            form.addEventListener('submit', function(event) {
                event.preventDefault();

                const selectedStudents = Array.from(form.querySelectorAll(
                    'input[name="students[]"]:checked')).map(input => input.value);

                const invoiceItems = Array.from(form.querySelectorAll('[name^="invoice_item_type"]')).map(
                    select => {
                        const studentId = select.name.match(/\d+/)[0];
                        const descriptionElement = document.querySelector(
                            `[name="invoice_item_description[${studentId}][]"]`
                        );
                        const amountElement = document.querySelector(
                            `[name="invoice_item_amount[${studentId}][]"]`
                        );

                        return {
                            student_id: studentId,
                            item_type_id: select.value,
                            description: descriptionElement ? descriptionElement.value :
                            '', // Check if description element exists
                            amount: amountElement ? amountElement.value :
                                '' // Check if amount element exists
                        };
                    }
                );


                const creditCost = creditCostInput.value;
                const fixedCost = fixedCostInput.value;

                fetch('/api/bulk-virtual-accounts', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            payment_period_id: paymentPeriodId,
                            students: selectedStudents,
                            invoice_items: invoiceItems,
                            credit_cost: creditCost,
                            fixed_cost: fixedCost
                        }),
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Failed to create virtual accounts');
                        }
                        return response.json();
                    })
                    .then(data => {
                        alert(data.message);
                        window.location.href = `/paymentPeriod/${paymentPeriodId}`;
                    })
                    .catch(error => {
                        console.error('Error creating virtual accounts:', error);
                        alert('An error occurred. Please try again.');
                    });
            });
        });
    </script>
@endsection

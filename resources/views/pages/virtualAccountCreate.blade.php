@extends('layout.app')

@section('title', 'Bulk Create Virtual Accounts')

@section('content')
    <h1>Bulk Create Virtual Accounts</h1>

    <!-- Filter Section -->
    <form id="filter-form" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <select id="filter-year" class="form-control">
                    <option value="">Select Year</option>
                    <!-- Year options will be populated via JavaScript -->
                </select>
            </div>
            <div class="col-md-4">
                <select id="filter-major" class="form-control">
                    <option value="">Select Major</option>
                    <!-- Major options will be populated via JavaScript -->
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
                    <th>
                        <input type="checkbox" id="select-all-checkbox">
                    </th>
                    <th>Student Name</th>
                    <th>Major</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody id="students-table">
                <!-- Populated via JavaScript -->
            </tbody>
        </table>

        <button type="submit" class="btn btn-primary">Generate Virtual Accounts</button>
    </form>

@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const paymentPeriodId = {{ $paymentPeriodId }};
            const apiUrl = `/api/students/paymentPeriod/${paymentPeriodId}`;
            const form = document.getElementById('bulk-create-form');
            const tableBody = document.getElementById('students-table');
            const filterYear = document.getElementById('filter-year');
            const filterMajor = document.getElementById('filter-major');
            const selectAllCheckbox = document.getElementById('select-all-checkbox');

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

            // Fetch students with applied filters
            function fetchStudents() {
                const selectedYear = filterYear.value;
                const selectedMajor = filterMajor.value;

                let filterParams = {};

                // Apply filter based on selected values
                if (selectedYear) {
                    filterParams.year = selectedYear;
                }
                if (selectedMajor) {
                    filterParams.major = selectedMajor;
                }

                // If no filters are applied, skip the filter params in the API call
                const queryString = new URLSearchParams(filterParams).toString();
                const url = queryString ? `${apiUrl}?${queryString}` : apiUrl;

                // Fetch students for the related institution and filter options
                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        if (data.length === 0) {
                            tableBody.innerHTML =
                                `<tr><td colspan="4" class="text-center">No students found for this filter.</td></tr>`;
                            return;
                        }

                        tableBody.innerHTML = data.map(student => `
                    <tr>
                        <td><input type="checkbox" class="student-checkbox" name="students[]" value="${student.id}"></td>
                        <td>${student.name}</td>
                        <td>${student.major}</td>
                        <td>${student.email}</td>
                    </tr>
                `).join('');
                    })
                    .catch(error => {
                        console.error('Error fetching students:', error);
                        tableBody.innerHTML =
                            `<tr><td colspan="4" class="text-center text-danger">Failed to load students. Please try again later.</td></tr>`;
                    });
            }

            // Handle Select All checkbox toggle
            selectAllCheckbox.addEventListener('change', function() {
                const isChecked = selectAllCheckbox.checked;
                const studentCheckboxes = document.querySelectorAll('.student-checkbox');

                studentCheckboxes.forEach(checkbox => {
                    checkbox.checked = isChecked;
                });
            });

            // Check if all student checkboxes are selected, then check the "Select All" checkbox
            tableBody.addEventListener('change', function() {
                const studentCheckboxes = document.querySelectorAll('.student-checkbox');
                const allSelected = Array.from(studentCheckboxes).every(checkbox => checkbox.checked);

                selectAllCheckbox.checked = allSelected;
            });

            // Event listeners for filter changes
            filterYear.addEventListener('change', fetchStudents);
            filterMajor.addEventListener('change', fetchStudents);

            // Initial data load
            loadFilterOptions();
            fetchStudents();

            // Handle form submission for bulk creation
            form.addEventListener('submit', function(event) {
                event.preventDefault();

                const selectedStudents = Array.from(form.querySelectorAll(
                    'input[name="students[]"]:checked')).map(input => input.value);

                fetch('/api/bulk-virtual-accounts', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            payment_period_id: paymentPeriodId,
                            students: selectedStudents,
                        }),
                    })
                    .then(response => response.json())
                    .then(data => {
                        alert(data.message);
                        location.reload();
                    })
                    .catch(error => {
                        console.error('Error creating virtual accounts:', error);
                        alert('An error occurred. Please try again.');
                    });
            });
        });
    </script>
@endsection

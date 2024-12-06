@extends('layout.app')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard Overview')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">Institute List</h4>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-4">
            <input type="text" id="search-input" class="form-control" placeholder="Search by name..." />
        </div>
        <div class="col-md-3">
            <select id="filter-admins" class="form-control">
                <option value="">Filter by Admin Count</option>
                <option value="0">No Admin</option>
                <option value="1-5">1-5 Admins</option>
                <option value=">5">More than 5 Admins</option>
            </select>
        </div>
        <div class="col-md-3">
            <select id="filter-students" class="form-control">
                <option value="">Filter by Student Count</option>
                <option value="0">No Students</option>
                <option value="1-50">1-50 Students</option>
                <option value=">50">More than 50 Students</option>
            </select>
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary" onclick="fetchInstitutes()">Apply Filters</button>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-nowrap mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Contact</th>
                                    <th scope="col">Admin</th>
                                    <th scope="col">Student</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody id="institute-table-body">
                                <!-- Table rows will be injected here dynamically -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Fetch data from the API
        document.addEventListener("DOMContentLoaded", function() {
            fetchInstitutes();
        });

        function fetchInstitutes() {
            const searchQuery = document.getElementById('search-input').value.trim();
            const filterAdmins = document.getElementById('filter-admins').value;
            const filterStudents = document.getElementById('filter-students').value;

            const params = new URLSearchParams();
            if (searchQuery) params.append('search', searchQuery);
            if (filterAdmins) params.append('admins_filter', filterAdmins);
            if (filterStudents) params.append('students_filter', filterStudents);

            console.log('Applying filters with parameters:', params.toString());

            const url = `http://localhost:8000/api/institutions?${params.toString()}`;

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    const tableBody = document.getElementById('institute-table-body');
                    tableBody.innerHTML = '';

                    if (data.length === 0) {
                        tableBody.innerHTML = '<tr><td colspan="6" class="text-center">No results found</td></tr>';
                        return;
                    }

                    data.forEach(institute => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                    <td>${institute.id}</td>
                    <td>
                        <div>
                            <h6 class="mb-0">${institute.name}</h6>
                            <a href="#" class="text-primary fw-bold font-size-11">NPSN: ${institute.npsn}</a>
                        </div>
                    </td>
                    <td>
                        <div>
                            <p class="fw-bold mb-0">${institute.email}</p>
                            <p>${institute.phone}</p>
                        </div>
                    </td>
                    <td><p class="fw-bold mb-0">${institute.admins_count}</p></td>
                    <td><p class="fw-bold mb-0">${institute.students_count}</p></td>
                    <td>
                        <button type="button" class="btn btn-primary btn-sm" 
                                onclick="loadProfile(${institute.id})">Read More</button>
                    </td>
                `;
                        tableBody.appendChild(row);
                    });
                })
                .catch(error => {
                    console.error('Error fetching institutes:', error);
                });
        }


        function loadProfile(id) {
            window.location.href = `/institute/${id}`;
        }
    </script>
@endsection

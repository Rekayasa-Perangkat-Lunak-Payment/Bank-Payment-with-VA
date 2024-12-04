@extends('layout.app')

@section('title', 'Student List')

@section('page-title', 'Student Overview')

@section('content')

    <div class="row">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">Student List</h4>
                <!-- Add New Student Button -->
                <a href="/addStudent" class="btn btn-primary">Add New Student</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <div class="row mb-3">
                            <form id="searchForm">
                                <div class="input-group">
                                    <!-- Search input -->
                                    <input type="text" id="search" class="form-control"
                                        placeholder="Search by name or email" value="{{ request('search') }}">

                                    <!-- Institution filter -->
                                    <select id="institutionFilter" class="form-control mx-2">
                                        <option value="">Select Institution</option>
                                        @foreach ($institutions as $institution)
                                            <option value="{{ $institution->id }}">{{ $institution->name }}</option>
                                        @endforeach
                                    </select>

                                    <button class="btn btn-primary" type="submit">Search</button>
                                </div>
                            </form>
                        </div>

                        <!-- Table for displaying students -->
                        <div class="table-responsive">
                            <table class="table table-centered border table-nowrap mb-0" style="width: 100%;">
                                <thead class="table-light">
                                    <tr>
                                        <th>Student ID</th>
                                        <th>Name</th>
                                        <th>Institution</th>
                                        <th>Year</th>
                                        <th>Gender</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="studentsTableBody">
                                    <!-- Data will be populated via JS -->
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-3" id="paginationLinks">
                            <!-- Pagination links will be inserted here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@section('scripts')
    <script>
        // Fetch students based on the search and institution filter
        function fetchStudents() {
            const search = document.getElementById('search').value;
            const institutionId = document.getElementById('institutionFilter').value;

            const url = `/api/students?search=${search}&institution_id=${institutionId}`;

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    let tableBody = '';
                    data.forEach(student => {
                        tableBody += `
                                <tr>
                                    <td>${student.student_id}</td>
                                    <td>${student.name}</td>
                                    <td>${student.institution.name}</td>
                                    <td>${student.year}</td>
                                    <td>${student.gender}</td>
                                    <td><button class="btn btn-soft-primary btn-sm" onclick="window.location.href='/students/${student.id}/edit'">Edit</button></td>

                                </tr>
                            `;
                    });
                    document.getElementById('studentsTableBody').innerHTML = tableBody;
                })
                .catch(error => console.error('Error fetching students:', error));
        }

        // Event listener for form submit to fetch students based on search or filter change
        document.getElementById('searchForm').addEventListener('submit', function(e) {
            e.preventDefault();
            fetchStudents();
        });

        // Initial fetch
        fetchStudents();
    </script>
@endsection
@endsection

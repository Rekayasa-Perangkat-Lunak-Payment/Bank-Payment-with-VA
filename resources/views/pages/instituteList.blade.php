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
        console.log('Test fetchInstitutes directly');
        fetchInstitutes();

        // Fetch data from the API when the page loads
        document.addEventListener("DOMContentLoaded", function() {
            console.log('Page loaded and JavaScript is running');
            fetchInstitutes();
        });

        function fetchInstitutes() {
            fetch('http://localhost:8000/api/institutions')
                .then(response => response.json())
                .then(data => {
                    const tableBody = document.getElementById('institute-table-body');
                    tableBody.innerHTML = '';

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
                    console.error('Error during fetch:', error);
                });
        }

        function loadProfile(id) {
            window.location.href = `/institute/${id}`;
        }
    </script>
@endsection

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
    // Fetch data from the API when the page loads
    document.addEventListener("DOMContentLoaded", function () {
        fetchInstitutes();
    });

    function fetchInstitutes() {
        fetch('http://localhost:8000/api/institutions')
            .then(response => response.json())
            .then(data => {
                // Assuming 'data' is an array of institute objects
                const tableBody = document.getElementById('institute-table-body');
                tableBody.innerHTML = ''; // Clear existing rows

                // Loop through the data and add rows dynamically
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
                        <td>
                            <div>
                                <p class="fw-bold mb-0">${institute.admin_count}</p>
                            </div>
                        </td>
                        <td>
                            <div>
                                <p class="fw-bold mb-0">${institute.student_count}</p>
                            </div>
                        </td>
                        <td>
                            <div>
                                <button type="button" class="btn btn-primary btn-sm">Read More</button>
                            </div>
                        </td>
                    `;

                    tableBody.appendChild(row);
                });
            })
            .catch(error => {
                console.error('Error fetching data:', error);
                alert('Failed to load data. Please try again.');
            });
    }
</script>
@endsection

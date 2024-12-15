@extends('layout.app')

@section('title', 'Item Types')

@section('content')
    <h1>Item Types</h1>

    <!-- Form to Create New Item Type -->
    <form id="create-item-type-form" class="mb-4">
        <h5>Create New Item Type</h5>
        <div class="form-group">
            <label for="item-type-name">Name</label>
            <input type="text" id="item-type-name" class="form-control" placeholder="Enter Item Type Name" required>
        </div>

        <div class="form-group">
            <label for="item-type-description">Description</label>
            <input type="text" id="item-type-description" class="form-control" placeholder="Enter Item Type Description" required>
        </div>

        <button type="submit" class="btn btn-primary">Create Item Type</button>
    </form>

    <!-- Existing Item Types Table -->
    <h5>Existing Item Types</h5>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Created At</th>
                <th>Updated At</th>
            </tr>
        </thead>
        <tbody id="item-types-table">
            <!-- Populated via JavaScript -->
        </tbody>
    </table>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const createForm = document.getElementById('create-item-type-form');
            const nameInput = document.getElementById('item-type-name');
            const descriptionInput = document.getElementById('item-type-description');
            const tableBody = document.getElementById('item-types-table');

            const institutionId = {{ $id }};

            // Fetch existing item types
            function loadItemTypes() {
                fetch(`/api/institution/${institutionId}/itemTypes`)
                    .then(response => response.json())
                    .then(data => {
                        // Populate the table with existing item types
                        tableBody.innerHTML = data.map(item => `
                            <tr>
                                <td>${item.name}</td>
                                <td>${item.description}</td>
                                <td>${new Date(item.created_at).toLocaleString()}</td>
                                <td>${new Date(item.updated_at).toLocaleString()}</td>
                            </tr>
                        `).join('');
                    })
                    .catch(error => {
                        console.error('Error fetching item types:', error);
                    });
            }

            // Handle form submission to create a new item type
            createForm.addEventListener('submit', function(event) {
                event.preventDefault();
                const newItemType = {
                    name: nameInput.value,
                    description: descriptionInput.value,
                    institution_id: institutionId,
                    is_deleted: 0,  // Convert checkbox value to 1 or 0
                };

                fetch(`/api/itemTypes`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(newItemType),
                })
                .then(data => {
                    alert('Item type created successfully!');
                    loadItemTypes();  // Reload the item types after creation
                    // Clear the form inputs
                    nameInput.value = '';
                    descriptionInput.value = '';
                    isDeletedInput.checked = false;
                })
                .catch(error => {
                    console.error('Error creating item type:', error);
                    // alert('An error occurred while creating the item type. Please try again.');
                });
            });

            // Initial data load
            loadItemTypes();
        });
    </script>
@endsection

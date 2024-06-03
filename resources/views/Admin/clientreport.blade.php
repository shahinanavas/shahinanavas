@extends('admin.base')

@section('base')
<style>
    .approved-status {
        background-color: #d4edda; /* Change the background color as needed */
    }
</style>
<main class="col px-0 py-0">
    <div class="container">
        <!-- Search Filters -->
        <div class="row mt-3">
            <div class="form-group col-3">
                <label for="paymentMethod">Payment Method</label>
                <select class="form-control" id="paymentMethod">
                    <option value="all" selected>Select payment method</option>
                    <option value="Cash">Cash</option>
                    <option value="Credit Card">Credit Card</option>
                    <option value="Bank Transfer">Bank Transfer</option>
                </select>
            </div>
            <div class="form-group col-3">
                <label for="status">Status</label>
                <select class="form-control" id="status">
                    <option value="all" selected>Select status</option>
                    <option value="Pending">Pending</option>
                    <option value="Approved">Approved</option>
                    <option value="Rejected">Rejected</option>
                </select>
            </div>
            <div class="col-3 align-self-end">
                <button class="btn btn-primary" onclick="filterProjects()">Search</button>
            </div>
        </div>

        <!-- Task Information Card -->
        <div class="card shadow mt-3">
            <div class="card-header bg-dark text-white">
                <h5 class="card-title mb-0 text-center">Task Information</h5>
                <div class="d-flex justify-content-end">
                    <a href="{{ url('/taskadd') }}" class="btn btn-primary me-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-plus" viewBox="0 0 16 16">
                            <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
                            <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5"/>
                        </svg> ADD
                    </a>
                </div>
            </div>
        </div>

        <!-- Projects Table -->
        <div class="container mt-2">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Client Name</th>
                                            <th>Project Name</th>
                                            <th>Project Type</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="projectsTableBody">
                                    @foreach($approvedClients as $client)
                                        <tr class="projectRow" data-payment="{{ $client->payment_method }}" data-status="{{ $client->client_project_status }}">
                                            <td>{{ $client->id }}</td>
                                            <td>{{ $client->client_name }}</td>
                                            <td>{{ $client->project_name }}</td>
                                            <td>{{ $client->project_type }}</td>
                                            <td>{{ $client->client_project_status }}</td>
                                            <td>
                                                <a href="#" class="btn btn-success">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                                    </svg>
                                                </a>
                                                <form method="post" style="display: inline-block;">
                                                    <button class="btn btn-danger">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                                            <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0"/>
                                                        </svg> 
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    // Function to filter projects based on payment method and status
    function filterProjects() {
        var paymentMethod = document.getElementById('paymentMethod').value;
        var status = document.getElementById('status').value;
        var projectRows = document.querySelectorAll('.projectRow');

        projectRows.forEach(function(row) {
            var projectPaymentMethod = row.getAttribute('data-payment');
            var projectStatus = row.getAttribute('data-status');

            if ((paymentMethod === 'all' || projectPaymentMethod === paymentMethod) && (status === 'all' || projectStatus === status)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }
</script>

@endsection

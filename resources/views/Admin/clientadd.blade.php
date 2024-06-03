@extends('admin.base')

@section('base')

<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
    </style>
</head>
<body>

<div class="card shadow">
    <div class="card-header bg-dark text-white">
        <h5 class="card-title mb-0 text-center">ADD CLIENT</h5>
    </div>
    <div class="card-body">
                
                    <div class="row p-4">
                        <form  class="row g-3" action="{{ url('/home/clientstore') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row justify-content-center">
                                <div  class="col-md-10">
                                    <div class="mb-3">
                                    <label class="form-label text-primary">Clients Name</label>
                                        <input type="text" class="form-control" placeholder="Enter your Client Name" name="client_name" required>
                                    </div>
                                    </div>
                                    <div class="col-md-10">
                                    <div class="mb-3">
                                        <label class="form-label text-primary">Address</label>
                                        <textarea class="form-control" placeholder="Enter your  Address" name="client_address" required></textarea>
                                    </div>
                                    </div>
                                    <div class="col-md-10">
                                    <div class="mb-3">
                                        <label class="form-label text-primary">Phone Number</label>
                                        <input type="text" class="form-control"   placeholder="Enter your Client Phone number" name="client_phone_no">
                                    </div>
                                    </div>
                                    <div class="col-md-10">
                                    <div class="mb-3">
                                        <label class="form-label text-primary">Project Name</label>
                                        <input type="text" class="form-control" placeholder="Enter your Project Name" name="project_name" required>
                                    </div>
                                    </div>
                                    <div class="col-md-10">
                                    <div class="mb-3">
                                        <label class="form-label text-primary">Project Type</label>
                                        <select class="form-select" name="project_type" id="project_type" required>
                                            <option value="" disabled selected>Select a project type</option>
                                            <option value="Digital Marketing">Digital Marketing</option>
                                            <option value="SEO">SEO</option>
                                            <option value="Software">Software</option>
                                            <option value="Website">Website</option>
                                        </select>
                                    </div>
                                    </div>
                                    
                                    <div class="col-md-10">
                                    <div class="mb-3" id="project-type-container" style="display: none;">
                                        <label class="form-label text-primary" placeholder="Enter your Project type" id="project-type-label"></label>
                                        <input type="text" class="form-control" name="project_type_detail">
                                    </div>
                                    </div>

                                    <div class="col-md-10">
                                    <div class="mb-3">
                                        <label class="form-label text-primary"> Project Status</label>
                                        <select class="form-select" name="client_project_status" id="project_status" required>
                                            <option value="Pending">Pending</option>
                                            <option value="Approved">Approved</option>
                                            <option value="Rejected">Rejected</option>
                                        </select>
                                    </div>
                                    </div>
                                    
                                    <div class="col-md-10">
                                    <div class="mb-3" id="quotation_fields" style="display: none;">
                                        
                                            <label  class="form-label text-primary">Quotation Sent</label>
                                            <select class="form-select" name="quotation_sent" id="quotation_sent">
                                                <option value="No">No</option>
                                                <option value="Yes">Yes</option>
                                            </select>
                                        </div>
                                        </div>
                                        
                                        <div class="col-md-10">
                                        <div  class="mb-3"id="quotation_file_upload" style="display: none;">
                                           
                                                <label class="form-label text-primary">Quotation File Upload</label>
                                                <input type="file" class="form-control" name="quotation_file">
                                            </div>
                                            </div>

                                            <div class="col-md-10">
                                            <div class="mb-3">
                                                <label class="form-label text-primary">Quotation Status</label>
                                                <select class="form-select" name="quotation_status">
                                                    <option value="Pending">Pending</option>
                                                    <option value="Inprogress">Inprogress</option>
                                                    <option value="Completed">Completed</option>
                                                </select>
                                            </div>
                                            </div>
                                     
                                     <div class="col-md-10">
                                    <div class="mb-3">
                                        <label class="form-label text-primary">Total Amount</label>
                                        <input type="number" class="form-control" name="total_amount" id="total_amount" required>
                                    </div>
                                    </div>

                                    <div class="col-md-10">
                                    <div class="mb-3">
                                        <label class="form-label text-primary">Amount Paid</label>
                                        <input type="number" class="form-control" name="amount_paid" id="amount_paid" required>
                                    </div>
                                    </div>

                                    <div class="col-md-10">
                                    <div class="mb-3">
                                        <label class="form-label text-primary">Balance</label>
                                        <input type="number" class="form-control" name="balance" id="balance" readonly>
                                    </div>
                                </div>
                           
                                <div class="col-md-10">
                            <div class="mb-3">
        <label class="form-label text-primary">Payment Method</label>
        <select class="form-select" name="payment_method" required>
            <option value="" disabled selected>Select a payment method</option>
            <option value="Cash">Cash</option>
            <option value="Credit Card">Credit Card</option>
            <option value="Bank Transfer">Bank Transfer</option>
            <!-- Add more options as needed -->
        </select>
    </div>
    </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-info">Submit</button>
                                <button type="button" class="btn btn-secondary" onclick="window.history.back();">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('project_type').addEventListener('change', function() {
        const projectTypeContainer = document.getElementById('project-type-container');
        const projectTypeLabel = document.getElementById('project-type-label');
        if (this.value) {
            projectTypeContainer.style.display = 'block';
            projectTypeLabel.innerText = `Type of ${this.options[this.selectedIndex].text}`;
        } else {
            projectTypeContainer.style.display = 'none';
        }
    });

    document.getElementById('project_status').addEventListener('change', function() {
        const quotationFields = document.getElementById('quotation_fields');
        if (this.value === 'Approved') {
            quotationFields.style.display = 'block';
        } else {
            quotationFields.style.display = 'none';
        }
    });

    document.getElementById('quotation_sent').addEventListener('change', function() {
        const quotationFileUpload = document.getElementById('quotation_file_upload');
        if (this.value === 'Yes') {
            quotationFileUpload.style.display = 'block';
        } else {
            quotationFileUpload.style.display = 'none';
        }
    });

    // Function to update balance
    function updateBalance() {
        const totalAmount = parseFloat(document.getElementById('total_amount').value) || 0;
        const amountPaid = parseFloat(document.getElementById('amount_paid').value) || 0;
        const balance = totalAmount - amountPaid;
        document.getElementById('balance').value = balance;
    }

    // Attach event listeners to amount inputs
    document.getElementById('total_amount').addEventListener('input', updateBalance);
    document.getElementById('amount_paid').addEventListener('input', updateBalance);
</script>

</body>
</html>
@endsection

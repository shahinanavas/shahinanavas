@extends('admin.base')
@section('base')

<div class="text-center">
    <h1>TEAM</h1>
</div>
<div class="card shadow">
    <div class="card-header bg-dark text-white">
        <h5 class="card-title mb-0 text-center">Edit Employee</h5>
    </div>
    <div class="card-body">
        <form class="row g-3" action="/home/employeeupdate/{{ $view->id }}" method="POST">
            @csrf
            @method('PUT')
            <div class="col-md-6">
                <label class="form-label">Employee Name</label>
                <input type="text" class="form-control" name="name" value="{{ $view->name }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Address</label>
                <textarea class="form-control" name="employee_address">{{ $view->employee_address }}</textarea>
            </div>
            <div class="col-md-6">
                <label class="form-label">Aadhar Number</label>
                <input type="text" class="form-control" name="aadhar_no" value="{{ $view->aadhar_no }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Date of Birth</label>
                <input type="date" class="form-control" name="dob" value="{{ $view->dob }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Qualification</label>
                <select class="form-select" name="qualification">
                    <option value="diploma" {{ $view->qualification == 'diploma' ? 'selected' : '' }}>Diploma</option>
                    <option value="ug" {{ $view->qualification == 'ug' ? 'selected' : '' }}>UG</option>
                    <option value="pg" {{ $view->qualification == 'pg' ? 'selected' : '' }}>PG</option>
                    <option value="phd" {{ $view->qualification == 'phd' ? 'selected' : '' }}>Phd</option>
                </select>
            </div>
            <div class="col-md-6"> 
                <label class="form-label">Phone Number</label>
                <input type="text" class="form-control" name="phone_no" value="{{ $view->phone_no }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Designation</label>
                <input type="text" class="form-control" name="designation" value="{{ $view->designation }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Type</label>
                <select class="form-select" name="emptype">
                    <option value="Permanent" {{ $view->emptype == 'Permanent' ? 'selected' : '' }}>Permanent</option>
                    <option value="Probation Period" {{ $view->emptype == 'Probation Period' ? 'selected' : '' }}>Probation Period</option>
                    <option value="Intern" {{ $view->emptype == 'Intern' ? 'selected' : '' }}>Intern</option>
                    <option value="Trainee" {{ $view->emptype == 'Trainee' ? 'selected' : '' }}>Trainee</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Join Date</label>
                <input type="date" class="form-control" name="join_date" value="{{ $view->join_date }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Salary</label>
                <input type="text" class="form-control" name="salary" value="{{ $view->salary }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Salary Date</label>
                <input type="date" class="form-control" name="salary_date" value="{{ $view->salary_date }}">
            </div>
            
            <!-- Submit and Cancel buttons -->
            <div class="text-center">
                <button type="submit" class="btn btn-info">Update</button>
                <a href="/home/employees" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

@endsection

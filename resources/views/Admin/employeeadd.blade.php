@extends('admin.base')
@section('base')


<div class="card shadow">
    <div class="card-header bg-dark text-white">
        <h5 class="card-title mb-0 text-center">Add Employee</h5>
    </div>
    <div class="card-body">
      
    <form class="row g-3" action="/home/employeestore" method="POST" enctype="multipart/form-data">
                @csrf
                   
                        <div class="col-md-6">
                            <label class="form-label  text-primary">Employee Name</label>
                            <input type="text" class="form-control" placeholder="Enter your Employee Name" name="name">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label  text-primary">Address</label>
                            <textarea class="form-control" placeholder="Enter your  Address" name="employee_address"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label  text-primary">Aadhar Number</label>
                            <input type="text" class="form-control" placeholder="Enter your Aadhar Number" name="aadhar_no">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label  text-primary">Date of Birth</label>
                            <input type="date" class="form-control" placeholder="Enter your Date of Birth" name="dob">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label  text-primary">Qualification</label>
                            <select class="form-select" name="qualification">
                                <option value="diploma">Diploma</option>
                                <option value="ug">UG</option>
                                <option value="pg">PG</option>
                                <option value="phd">Phd</option>
                            </select>
                        </div>
                        <div class="col-md-6"> 
                            <label class="form-label  text-primary">Phone Number</label>
                            <input type="text" class="form-control" placeholder="Enter your Phone Number" name="phone_no">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label  text-primary">Designation</label>
                            <input type="text" class="form-control" placeholder="Enter your Designation" name="designation">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label  text-primary">Type</label>
                            <select class="form-select" name="emptype">
                            <option value="Permanent">Permanent</option>
                                <option value="Probation Period">Probation Period</option>
                                <option value="Intern">Intern</option>
                                <option value="Trainee">Trainee</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label  text-primary">Join Date</label>
                            <input type="date" class="form-control" placeholder="Enter your Join Date" name="join_date">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label  text-primary">Salary</label>
                            <input type="text" class="form-control" placeholder="Enter your  Salary" name="salary">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label  text-primary">Salary Date</label>
                            <input type="date" class="form-control" placeholder="Enter your Salary Date" name="salary_date">
                        </div>


                        
                        <div class="col-md-6">
                            <label class="form-label  text-primary">Image</label>
                            <input type="file" class="form-control" placeholder="Enter your Image" name="image">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label  text-primary">Email</label>
                            <input type="email" class="form-control" placeholder="Enter your Email" name="email">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label  text-primary">Password</label>
                            <input type="password" class="form-control" placeholder="Enter your Password" name="password">
                        </div>
                    </div>
                </div>

                <!-- Submit and Cancel buttons -->
                <div class="text-center">
                    <button type="submit" class="btn btn-info">Submit</button>
                    <button type="button" class="btn btn-secondary" onclick="window.history.back();">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

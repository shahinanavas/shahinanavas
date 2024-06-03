@extends('admin.base')

@section('base')


    <div class="card shadow">
    <div class="card-header bg-dark text-white">
        <h5 class="card-title mb-0 text-center" style="font-weight: bold;" >EMPLOYEE DETAILS</h5>
        <div class="d-flex justify-content-end">
                <a href="{{ url('/home/employeeadd') }}" class="btn btn-primary me-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="5" fill="currentColor" class="bi bi-person-plus" viewBox="0 0 16 16">
                        <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
                        <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5"/>
                    </svg> ADD
                </a>      
            </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
        <div class="table-responsive">
           
        
        <table class="table align-items-center mb-0">
        <thead>
            <tr>
                
                
                <th> Name</th>
                <th>Address</th>
                <th>Aadhar</th>
                <th>DOB</th>
                <th>Qualification</th>
                <th>Phoneno</th>
                <th>Designation</th>
                <th>Type</th>
                <th>JoinDate</th>
                <th>Salary</th>
                <th>SalaryDate</th>
             
                <th colspan="2">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($view as $item)
            <tr>
                
                <td>{{ $item->name }}</td>
                <td>{{ $item->employee_address }}</td>
                <td>{{ $item->aadhar_no }}</td>
                <td>{{ $item->dob }}</td>
                <td>{{ $item->qualification }}</td>
                <td>{{ $item->phone_no }}</td>
                <td>{{ $item->designation }}</td>
                <td>{{ $item->emptype }}</td>
                <td>{{ $item->join_date }}</td>
                <td>{{ $item->salary }}</td>
                <td>{{ $item->salary_date }}</td>
              
                <td>
                    <a href="{{ url('/home/employeeedit/'.$item->id) }}" class="btn btn-success">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                        </svg> Edit
                    </a>
                </td>
                <td>
                    <form action="{{ url('/home/employeedelete/'.$item->id) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0"/>
                            </svg> Delete
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

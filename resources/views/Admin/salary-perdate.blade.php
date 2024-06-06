@extends('admin.base')

@section('base')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-dark text-white">
                <h5 style="font-weight: bold;" class="card-title mb-0 text-center">EMPLOYEE SALARIES FOR {{ $currentDate }}</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Employee Name</th>
                                    <th>Employee Type</th>
                                    <th>Remaining Salary</th>
                                    <!-- <th>Next Salary Date</th> -->
                                    <th>Total Salary</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($salaryData as $salary)
                                <tr>
                                    <td>{{ $salary->employee_name }}</td>
                                    <td>{{ $salary->emptype }}</td>
                                    <td>${{ $salary->remaining_salary }}</td>
                                
                                    <td>{{ $salary->salary }}</td>
                                   
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @if($salaryData->isEmpty())
                            <div class="text-center">No salary data found.</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

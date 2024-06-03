@extends('admin.base')

@section('base')
<div class="card shadow">
    <div class="card-header bg-dark text-white">
        <h5  style="font-weight: bold;"  class="card-title mb-0 text-center">LEAVE  APPLICATION</h5>
                    </div>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                
                                <th>Name</th>
                                <th>Leave Type</th>
                                <th>Date</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Total Days</th>
                                <th>Reason</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($leaveApplications as $leave)
                                <tr>
                                   
                                    <td>{{ $leave->employee_name }}</td>
                                    <td>{{ $leave->typeleave }}</td>
                                    <td>{{ $leave->date }}</td>
                                    <td>{{ $leave->startdate }}</td>
                                    <td>{{ $leave->enddate }}</td>
                                    <td>{{ $leave->totaldays }}</td>
                                    <td>{{ $leave->reason }}</td>
                                    <td>
                                    <form method="POST" action="{{ url('/leave/approve/'.$leave->id) }}">
        @csrf
        <select name="status" class="form-select" onchange="this.form.submit()">
            <option value="0" @if($leave->status == 0) selected @endif class="btn btn-danger">Pending</option>
            <option value="1" @if($leave->status == 1) selected @endif class="btn btn-success">Accept</option>
            <option value="2" @if($leave->status == 2) selected @endif class="btn btn-warning">Reject</option>
        </select>
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

@endsection
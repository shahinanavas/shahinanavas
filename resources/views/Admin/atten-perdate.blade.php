@extends('admin.base')

@section('base')
<div class="text-center">
    <h1></h1>
</div>
<div class="card shadow">
    <div class="card-header bg-dark text-white">
        <h5 class="card-title mb-0 text-center">Today Attendance</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table align-items-center mb-0">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Employee Name</th>
                        <th>checkin-time</th>
                        <th>Checkout Time </th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($attendanceData as $attendance)
                    <tr>
                        <td>{{ $attendance->date }}</td>
                        <td>{{ $attendance->employee_name }}</td>
                        <td>{{ $attendance->checkin_time }}</td>
                        <td>{{ $attendance->checkout_time }}</td>
                        <td>{{ $attendance->status }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

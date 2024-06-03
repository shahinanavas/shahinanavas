@extends('admin.base')

@section('base')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-dark text-white">
                    <h5 style="font-weight: bold;" class="card-title mb-0 text-center">EMPLOYEE SALARIES</h5>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            @foreach (range(1, 12) as $month)
                @php
                    $monthName = \Carbon\Carbon::createFromFormat('m', $month)->format('F');
                @endphp
                <div class="card shadow">
                    <div class="card-header bg-dark text-white">
                        <h5 style="font-weight: bold;" class="card-title mb-0 text-center">Salary in {{ $monthName }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Employee Type</th>
                                        <th>Salary</th>
                                        <th>Salary Date</th>
                                        <th>Remaining Salary</th>
                                        <th>Next Salary Date</th>
                                        <th>Status</th>
                                        <th>Mark as Paid</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($salaryData as $employee)
                                        @if (!is_null($employee->remainingSalaries[$month]))
                                            <tr>
                                                <td>{{ $employee->id }}</td>
                                                <td>{{ $employee->name }}</td>
                                                <td>{{ $employee->emptype }}</td>
                                                <td>{{ $employee->salary }}</td>
                                                <td>{{ $employee->remainingSalaries[$month]['date'] }}</td>
                                                <td>{{ $employee->remainingSalaries[$month]['amount'] }}</td>
                                                <td>{{ $employee->remainingSalaries[$month]['next_salary_date'] }}</td>
                                                <td>
                                                    @if ($employee->remainingSalaries[$month]['status'] === 'paid')
                                                        Paid
                                                    @else
                                                        Unpaid
                                                    @endif
                                                </td>
                                                <td>
                                                    <form method="POST" action="{{ url('/admin/mark-salary-paid') }}">
                                                        @csrf
                                                        <input type="hidden" name="employee_id" value="{{ $employee->id }}">
                                                        <input type="hidden" name="month" value="{{ $month }}">
                                                        <select name="status" onchange="this.form.submit()">
                                                            <option value="unpaid" {{ $employee->remainingSalaries[$month]['status'] !== 'paid' ? 'selected' : '' }}>Unpaid</option>
                                                            <option value="paid" {{ $employee->remainingSalaries[$month]['status'] === 'paid' ? 'selected' : '' }}>Paid</option>
                                                        </select>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

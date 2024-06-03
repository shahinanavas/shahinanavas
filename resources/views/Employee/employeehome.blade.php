@extends('Employee.base')

@section('base')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                        <h5 style="font-weight: bold;" class="card-title mb-0">Employee Dashboard</h5>
                        <div>
                            @if ($attendance)
                                @if ($attendance->checkout_time)
                                    @if (session('day_salary'))
                                        <!-- Display Day Salary if available -->
                                    @endif
                                    @if (session('deduction'))
                                        <!-- Display Deduction if available -->
                                    @endif
                                @else
                                    <form action="{{ route('employee.checkout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary">Checkout</button>
                                    </form>
                                @endif
                            @else
                                <form action="{{ route('employee.checkin') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">Checkin</button>
                                </form>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <p>Welcome, {{ Auth::user()->name }}!</p>
                        <p>Today's Date: {{ now('Asia/Kolkata')->format('Y-m-d') }}</p>

                        <div class="row mt-4 justify-content-center">
                            <div class="col-md-4 col-sm-4 col-lg-4 col-xl-3 mb-4">
                                <div class="card dash-widget bg-success">
                                    <div class="card-body">
                                        <span class="dash-widget-icon"><i class="fa fa-money"></i></span>
                                        <div class="dash-widget-info">
                                            <span style="color: white;">Current Month's Remaining Salary</span>
                                            <h3 style="color: white;">${{ number_format($currentMonthRemainingSalary, 2) }}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4 col-sm-4 col-lg-4 col-xl-3 mb-4">
                                <div class="card dash-widget bg-warning">
                                    <div class="card-body">
                                        <span class="dash-widget-icon"><i class="fa fa-money"></i></span>
                                        <div class="dash-widget-info">
                                            <span style="color: white;">Previous Month's Remaining Salary</span>
                                            <h3 style="color: white;">${{ number_format($previousMonthRemainingSalary, 2) }}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

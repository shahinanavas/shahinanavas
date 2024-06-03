@extends('admin.base')
@section('base')


<style>.bg-gradient-custom {
    background-color: #your-color; /* Replace "your-color" with the desired color code */
}
</style>


    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">Welcome {{ Session::get('name') }}!</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->
            <div class="row">
                <div class="col-md-4 col-sm-4 col-lg-4 col-xl-3 mb-4">
                    <div class="card dash-widget bg-primary">
                        <div class="card-body"> <span class="dash-widget-icon"><i class="fa fa-cubes"></i></span>
                            <div class="dash-widget-info">
                               <span style="color: white;">Total Projects</span> <h3 style="color: white;">{{ $totalProjects }}</h3>
                               <a href="/home/projectview" style="color: white;">View</a> 
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 col-lg-4 col-xl-3 mb-4">
                    <div class="card dash-widget bg-success">
                        <div class="card-body"> <span class="dash-widget-icon"><i class="fa fa-usd"></i></span>
                            <div class="dash-widget-info">
                                 <span style="color: white;">Total Clients</span><h3 style="color: white;">{{ $totalClients }}</h3>
                                 <a href="/home/clientview" style="color: white;">View</a>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
                <div class="row">
                <div class="col-md-4 col-sm-4 col-lg-4 col-xl-3 mb-4">
                    <div class="card dash-widget bg-info">
                        <div class="card-body"> <span class="dash-widget-icon"><i class="fa fa-diamond"></i></span>
                            <div class="dash-widget-info">
                            <span style="color: white;">Total Tasks</span>   <h3 style="color: white;">{{  $totalTasks}}</h3> 
                                 <a href="/taskview" style="color: white;">View</a>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-md-4 col-sm-4 col-lg-4 col-xl-3 mb-4">
    <div class="card dash-widget bg-secondary">
        <div class="card-body"> <span class="dash-widget-icon"><i class="fa fa-user"></i></span>
            <div class="dash-widget-info">
                <span style="color: white;">Today's Absent Employees</span>   
                <h3 style="color: white;">{{ $todayAbsentCount }}</h3> 
                <a href="/home/showCurrentDateAttendance" style="color: white;">View</a>
            </div>
        </div>
    </div>
</div>
</div>
<div class="col-md-4 col-sm-4 col-lg-4 col-xl-3 mb-4">
                    <div class="card dash-widget bg-warning">
                        <div class="card-body"> <span class="dash-widget-icon"><i class="fa fa-user"></i></span>
                            <div class="dash-widget-info">
                              <span style="color: white;">Total Employees</span>   <h3 style="color: white;">{{ $totalEmployees }}</h3> 
                              <a href="/home/employeeview" style="color: white;">View</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
 



        <div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
        <div class="card shadow">
                <div class="card-header bg-dark text-white">
                    <h4 class="card-title mb-0 text-center">Employees Attendance</h4>
                </div>

                </div>
                <div class="card-body px-0 pb-2">
                    <div class="row p-4">
                        <div class="table-responsive">
                            <div style="overflow-x: auto; width: 100%;">
                                <table class="table align-items-center mb-0">
                                    
<table class="table table-dark">
    <tr>
        <th colspan="35">
            <span>Attendance 
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
                </svg>Absent 
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16">
                    <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0" />
                </svg>Present 
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-circle-half" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 0 8 1zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16" />
                </svg> Halfday
            </span>
            <span style="float: right">{{ date('F') }}</span>
        </th>
    </tr>

    <tr>
        <th>Date</th>
        @for ($day = 1; $day <= 31; $day++)
            <th>{{ \Carbon\Carbon::create(null, null, $day)->format('D d') }}</th>
        @endfor
    </tr>

    @php 
        $displayedNames = [];
        $daysInMonth = Carbon\Carbon::now()->daysInMonth;
    @endphp

    @foreach ($attendanceData as $attendance)
        @php 
            $employeeName = $attendance->employee_name;
            $status = $attendance->status;
            $day = Carbon\Carbon::parse($attendance->date)->format('d');
        @endphp

        @if (!in_array($employeeName, $displayedNames))
            <tr>
                <td>{{ $employeeName }}</td>
                @for ($currentDay = 1; $currentDay <= $daysInMonth; $currentDay++)
                    <td>
                        @php 
                            $hasStatus = false; 
                            $statusIcon = ''; 

                            // Find status for the current day
                            foreach ($attendanceData as $attData) {
                                if (Carbon\Carbon::parse($attData->date)->format('d') == $currentDay && $attData->employee_name == $employeeName) {
                                    switch ($attData->status) {
                                        case 'Absent':
                                            $statusIcon = '<strong class="text-warning"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16"><path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" /></svg></strong>';
                                            break;
                                        case 'Present':
                                            $statusIcon = '<strong class="text-primary"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16"><path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0" /></svg></strong>';
                                            break;
                                        case 'Half Day':
                                            $statusIcon = '<strong class="text-success"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-circle-half" viewBox="0 0 16 16"><path d="M8 15A7 7 0 1 0 8 1zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16" /></svg></strong>';
                                            break;
                                        default:
                                            $statusIcon = '-';
                                            break;
                                    }
                                    $hasStatus = true;
                                    break; // Exit the loop once status for the current day is found
                                }
                            }
                        @endphp

                        {!! $hasStatus ? $statusIcon : '-' !!}
                    </td>
                @endfor
            </tr>
            @php $displayedNames[] = $employeeName; @endphp
        @endif
    @endforeach
</table>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
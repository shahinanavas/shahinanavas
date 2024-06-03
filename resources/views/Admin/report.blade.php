@extends('admin.base')
@section('base')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 text-center">
            <h1>Task Schedule Report</h1>
        </div>
    </div>
</div>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <canvas id="taskScheduleChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
<script>
    var ctx = document.getElementById('taskScheduleChart').getContext('2d');
    var taskScheduleChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [
                @foreach($taskSchedules as $taskSchedule)
                    '{{ $taskSchedule->taskname }} - {{ $taskSchedule->employee_name }}', // Task name with employee name
                @endforeach
            ],
            datasets: [{
                label: 'Status',
                data: [
                    @foreach($taskSchedules as $taskSchedule)
                        '{{ $taskSchedule->status_percentage }}', // Status percentages
                    @endforeach
                ],
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Status (%)'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Task Name - Employee Name'
                    }
                }
            }
        }
    });
</script>


@endsection



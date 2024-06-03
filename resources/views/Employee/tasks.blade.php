@extends('employee.base')

@section('base')
<div class="container">
    <div class="row justify-content-center">
        @foreach($tasks as $task)
        <div class="col-md-6 mb-4">
            <div class="card shadow">
                <div class="card-header bg-dark text-white">
                    <h5 class="card-title mb-0">Task Details</h5>
                </div>
                <div class="card-body">
                    <p><strong>Project Name:</strong> {{ $task->name }}</p>
                    <p><strong>Task Name:</strong> {{ $task->taskname }}</p>
                    <p><strong>Assigned To:</strong> {{ $task->assigned_to_name }}</p>
                    <p><strong>Description:</strong> {{ $task->taskdescription }}</p>
                    <p><strong>Allocation Date:</strong> {{ $task->allocationdate }}</p>
                    <p><strong>Deadline Date:</strong> {{ $task->deadlinedate }}</p>
                    <div class="d-flex justify-content-between align-items-center"> <!-- Flex container for inline elements -->
                        <button class="btn btn-primary" onclick="showReminderDialog('{{ $task->deadlinedate }}')">Show Reminder</button>
                        <form method="POST" action="{{ url('/taskupdate/'.$task->id) }}">
                            @csrf
                            <select name="status" onchange="this.form.submit()" id="statusSelect{{ $task->id }}" class="btn btn-primary">
                                <option class="btn btn-danger" value="0" @if($task->status == 0) selected @endif>Pending</option>
                                <option class="btn btn-primary" value="1" @if($task->status == 1) selected @endif>In Progress</option>
                                <option class="btn btn-success" value="2" @if($task->status == 2) selected @endif>Completed</option>
                            </select>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Reminder Modal inside the loop -->
        <div class="modal fade" id="reminderModal{{ $task->id }}" tabindex="-1" role="dialog" aria-labelledby="reminderModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content" style="background-color: #add8e6;"> <!-- Light blue background color -->
                    <div class="modal-header">
                        <h5 class="modal-title" id="reminderModalLabel">Task Reminder</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Your task with deadline on <strong>{{ $task->deadlinedate }}</strong> is approaching!
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<script>
    function showReminderDialog(deadlineDate) {
        var currentDate = new Date();
        var deadline = new Date(deadlineDate);
        // Compare current date with deadline
        if (currentDate >= deadline) {
            // Extracting the task id from the element id
            var taskId = event.target.id.replace('statusSelect', '');
            // Show the reminder modal if the deadline has passed
            $('#reminderModal' + taskId).modal('show');
        } else {
            // Optional: Add custom logic if you want to handle reminders for future deadlines
            console.log("This task's deadline is in the future.");
        }
    }
</script>

@endsection

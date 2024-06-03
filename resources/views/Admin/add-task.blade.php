@extends('admin.base')

@section('base')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-dark text-white">
                    <h4 class="card-title mb-0 text-center">Add  Team Task</h4>
                </div>
                <div class="card-body">
                    <form action="/home/cmpstoretask" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="col-md-10">
                            <div class="mb-3">
                                <label class="form-label text-primary">Project Name</label>
                                <select id="projectname" name="name_project" class="form-control">
    <option value="">Select project name</option>
    @foreach($projects as $project)
        <option value="{{ $project->projectname }}">{{ $project->projectname }}</option>
    @endforeach
</select>

                            </div>
                            <div class="mb-3">
                                <label class="form-label text-primary">Team Name</label>
                                <select id="teamname" name="team_name" class="form-control">
                                    <option value="">Select team</option>
                                    @foreach($teams as $team)
                                        <option value="">{{ $team->teamname }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-primary">Task AssignTO</label>
                                <select name="assigned_to" id="taskassign" class="form-control">
                                    <option value="">Select AssignTO</option>
                                    @foreach($assigns as $assign)
                                        <option value="">{{ $assign->member }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-primary">Task Name</label>
                                <input type="text" class="form-control" placeholder="Enter your task name" name="task_name">
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-primary">Description</label>
                                <input type="text" class="form-control" placeholder="Enter your description" name="task_description">
                            </div>
                            <div class="mb-3">
                                <label class="text-primary form-label">Allocation Date</label>
                                <input type="date" name="allocation_date" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="text-primary form-label">Deadline Date</label>
                                <input type="date" name="deadline_date" class="form-control">
                            </div>
                            <div class="col-md-12 d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

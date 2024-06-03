@extends('admin.base')

@section('base')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-dark text-white">
                    <h4 class="card-title mb-0 text-center">Add  Individual Task</h4>
                </div>
                <div class="card-body">
                    <form action="/taskstore" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="col-md-10">
                            <div class="mb-3">
                                <label class="form-label text-primary">Project Name</label>
                                <select  name="name" class="form-control">
                                    <option value="">Select project name</option>
                                @foreach($projects as $project)
                                     <option value="{{ $project->projectname }}">{{ $project->projectname }}</option>
                                 @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
    <label class="form-label text-primary">Task AssignTO</label>
    <select name="assign_to" class="form-control">
        <option value="">Select AssignTO</option>
        @foreach($assigns as $assign)
            <option value="{{ $assign->id }}">{{ $assign->name }}</option>
        @endforeach
    </select>
</div>
                            <div class="mb-3">
                                <label class="form-label text-primary">Task Name</label>
                                <input type="text" class="form-control" placeholder="Enter your task name" name="taskname">
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-primary">Description</label>
                                <textarea class="form-control" placeholder="Enter your description" name="taskdescription" rows="3"></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="text-primary form-label">Allocation Date</label>
                                <input type="date" name="allocationdate" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="text-primary form-label">Deadline Date</label>
                                <input type="date" name="deadlinedate" class="form-control">
                            </div>
                            <div class="col-md-12 d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <button type="button" class="btn btn-secondary" onclick="window.history.back();">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

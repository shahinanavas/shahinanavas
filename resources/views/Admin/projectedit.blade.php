@extends('admin.base')

@section('base')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card my-4 custom-card">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-info shadow-info border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center">
                            <h6 class="text-white text-capitalize ps-3">Edit Project</h6>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="row p-4">
                            <form action="{{ url('/home/projectupdate/' . $project->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row justify-content-center">
                                    <div class="col-lg-8">
                                        <div class="mb-3">
                                            <label class="form-label">Project Name</label>
                                            <input type="text" class="form-control" name="projectname" value="{{ $project->projectname }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Project Description</label>
                                            <input type="text" class="form-control" name="project_description" value="{{ $project->project_description }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Start Date</label>
                                            <input type="date" class="form-control" name="start_date" value="{{ $project->start_date }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">End Date</label>
                                            <input type="date" class="form-control" name="end_date" value="{{ $project->end_date }}" required>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-info">Update</button>
                                            <a href="{{ url('/home/projectview') }}" class="btn btn-secondary">Cancel</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

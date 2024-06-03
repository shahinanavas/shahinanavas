@extends('admin.base')

@section('base')

<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
    </style>
</head>
<body>
<div class="card shadow">
    <div class="card-header bg-dark text-white">
        <h5 class="card-title mb-0 text-center">ADD PROJECT</h5>
    </div>
    <div class="card-body">
                    <div class="row p-4">
                        <form action="{{ url('/home/projectstore') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row justify-content-center">
                                
                            <div  class="col-md-10">
                                <div class="mb-3">
                                    <label class="form-label  text-primary">Project Name</label>
                                        <select name="projectname" class="form-select" required>
                                            <option value="">Select Project</option>
                                        @foreach($clients as $client)
                                            <option value="{{ $client->project_name }}">{{ $client->project_name }}</option>
                                        @endforeach
                                        </select>
                                </div>
                                </div>


                                <div  class="col-md-10">
                                    <div class="mb-3">
                                        <label class="form-label text-primary">Project Description</label>
                                        <input type="text" class="form-control" placeholder="Enter your Project Description" name="project_description" required>
                                    </div>
                                    </div>

                                    <div  class="col-md-10">
                                    <div class="mb-3">
                                        <label class="form-label text-primary">Start Date</label>
                                        <input type="date" class="form-control" name="start_date" required>
                                    </div>
                                    </div>

                                    <div  class="col-md-10">
                                    <div class="mb-3">
                                        <label class="form-label text-primary">End Date</label>
                                        <input type="date" class="form-control" name="end_date" required>
                                    </div>
                                    </div>
                         
                            <div class="text-center">
                                <button type="submit" class="btn btn-info">Submit</button>
                                <button type="button" class="btn btn-secondary" onclick="window.history.back();">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
@endsection

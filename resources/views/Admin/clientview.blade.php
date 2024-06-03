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
        <h5  style="font-weight: bold;"  class="card-title mb-0 text-center">CLIENT INFORMATION</h5>
        <div class="d-flex justify-content-end">
                        <a href="{{ url('/home/clientadd') }}" class="btn btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-plus" viewBox="0 0 16 16">
                                    <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
                                    <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5"/>
                                </svg> ADD
                            </a>
                    </div>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="row p-4">
                        <div class="table-responsive">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Address</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Project Name</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Project Type</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Type Detail</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Quotation</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">File</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Quotation Status</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total Amount</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Amount Paid</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Balance</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($clients as $client)
                                    <tr>
                                        <td>{{ $client->client_name }}</td>
                                        <td>{{ $client->client_address }}</td>
                                        <td>{{ $client->project_name }}</td>
                                        <td>{{ $client->project_type }}</td>
                                        <td>{{ $client->project_type_detail }}</td>
                                        <td>{{ $client->client_project_status }}</td>
                                        <td>{{ $client->quotation_sent }}</td>
                                        <td>
                                            @if($client->quotation_file)
                                                <a href="{{ asset('storage/'.$client->quotation_file) }}" target="_blank">View File</a>
                                            @else
                                                No File
                                            @endif
                                        </td>
                                        <td>{{ $client->quotation_status }}</td>
                                        <td>{{ $client->total_amount }}</td>
                                        <td>{{ $client->amount_paid }}</td>
                                        <td>{{ $client->balance }}</td>
                                        <td>
                                            <a href="{{ url('/home/clientedit/'.$client->id) }}" class="btn btn-success">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                            </svg> Edit
                                             </a>
                                        </td>
                                        <td>
    <form action="{{ route('client.delete', ['id' => $client->id]) }}" method="post">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0"/>
            </svg> Delete
        </button>
    </form>
</td>

                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

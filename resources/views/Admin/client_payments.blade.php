@extends('admin.base')

@section('base')
<main class="col px-0 py-0">
    <div class="container">
        <!-- Search Form -->
        <div class="row mt-3">
            <div class="col-md-6">
                <form  method="GET">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Search by Client Name or YY-MM-DD" value="{{ request()->query('search') }}">
                        <button class="btn btn-primary" type="submit">Search</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Payment Details Table -->
        <div class="card shadow mt-3">
            <div class="card-header bg-dark text-white">
                <h5 class="card-title mb-0 text-center">Payments</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                
                                <th>Client Name</th>
                                <th>Amount Paid</th>
                                <th>Date  Time</th>
                                <th>Payment Method</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($payments as $payment)
                                <tr>
                                    <td>{{ $payment->client_name }}</td>
                                    <td>{{ $payment->amount_paid }}</td>
                                    <td>{{ $payment->payment_date }}</td>
                                    <td>{{ $payment->payment_method }}</td>
                                    
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>




        <!-- Client Balance Table -->
        <div class="card shadow mt-3">
            <div class="card-header bg-dark text-white">
                <h5 class="card-title mb-0 text-center">Client Balances</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                            <th>Client Name</th>
                                <th>Total Amount</th>
                                <th>Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($clients as $client)
                                <tr>     
                                <td>{{ $client->client_name }}</td>                              
                                    <td>{{ $client->total_amount}}</td>
                                    <td>{{ $client->balance }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


    </div>
</main>
@endsection

@extends('Employee.base')
@section('base')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-dark text-white">
                    <h4 class="card-title mb-0 text-center">Leave Application Form</h4>
                </div>
                <div class="card-body">
                    <form class="custom-center-align col-12" action="/home/storeleave" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="leavetype" class="text-primary form-label">Type of Leave:</label>
                            <select id="leavetype" name="typeleave" class="form-select">
                                <option value="Vacation">Vacation</option>
                                <option value="Personal">Personal</option>
                                <option value="Illness">Illness</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="date-range">
                            <div class="mb-3 start-end-date">
                                <label class="text-primary form-label">Start Date</label>
                                <input type="date" name="startdate" class="form-control">
                            </div>
                            <div class="mb-3 start-end-date">
                                <label class="text-primary form-label">End Date</label>
                                <input type="date" name="enddate" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-primary">Total Days</label>
                                <input type="text" class="form-control" placeholder="Total days" name="totaldays">
                            </div>
                        </div>
                        <div class="mb-3 date" style="display: none;">
                            <label class="form-label text-primary">Date</label>
                            <input type="date" name="date" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-primary">Reason</label>
                            <input type="text" class="form-control" placeholder="Enter your reason" name="reason">
                        </div>
                        <div class="col-md-12 d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var leaveTypeSelect = document.getElementById('leavetype');
        var dateRangeFields = document.querySelector('.date-range');
        var dateField = document.querySelector('.date');

        leaveTypeSelect.addEventListener('change', function () {
            if (leaveTypeSelect.value === 'Vacation' || leaveTypeSelect.value === 'Illness') {
                dateField.style.display = 'none';
                dateRangeFields.style.display = 'block';
            } else {
                dateField.style.display = 'block';
                dateRangeFields.style.display = 'none';
            }
        });
    });
</script>

@endsection

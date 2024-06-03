<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\ClientPayment;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

                /// ADMIN MODULE ///
Route::middleware(['auth','useraccess:admin'])->group(function()
{

Route::get('/home/adminhome',[HomeController::class,'adminpage'])->name('admin.home');
   
Route::get('/home/employeeview', [HomeController::class, 'employeeview']);
Route::get('/home/employeeadd', [HomeController::class, 'employeeadd']);
Route::post('/home/employeestore', [HomeController::class, 'employeestore']);
Route::get('/home/employeeedit/{id}', [HomeController::class, 'employeeedit']); 
Route::put('/home/employeeupdate/{id}', [HomeController::class, 'employeeupdate']); 
Route::delete('/home/employeedelete/{id}', [HomeController::class, 'employeedelete']);

Route::get('/home/clientview', [HomeController::class, 'clientview']);
Route::get('/home/clientadd', [HomeController::class, 'clientadd']);
Route::post('/home/clientstore', [HomeController::class, 'clientstore']);
Route::get('/home/clientedit/{id}', [HomeController::class, 'clientedit']);
Route::put('/home/clientupdate/{id}', [HomeController::class, 'clientupdate']);
Route::delete('/home/clientdelete/{id}', [HomeController::class, 'clientdelete'])->name('client.delete');
Route::post('/home/clientpayment/store', [ClientPaymentController::class, 'store'])->name('client.payment.store');

Route::get('/home/projectview', [HomeController::class, 'projectview']);
Route::get('/home/projectadd', [HomeController::class, 'projectadd']);
Route::post('/home/projectstore', [HomeController::class, 'projectstore']);
Route::get('/home/projectedit/{id}', [HomeController::class, 'projectedit']);
Route::put('/home/projectupdate/{id}', [HomeController::class, 'projectupdate']);
Route::post('/home/projectdelete', [HomeController::class, 'projectdelete']);
   


Route::get('/show-form', [HomeController::class, 'showForm'])->name('show.form');
Route::post('/store-task', [HomeController::class, 'storeTask'])->name('store.task');
Route::get('/get-teams/{projectId}', 'HomeController@getTeams');

//induvidual task route

Route::get('/taskview', [HomeController::class, 'taskview']);
Route::get('/taskadd', [HomeController::class, 'taskadd']);
Route::post('/taskstore', [HomeController::class, 'taskstore']);
Route::get('/taskedit/{id}', [HomeController::class, 'taskedit']);
Route::put('/taskupdate/{id}', [HomeController::class, 'taskupdate']);
Route::post('/taskdelete', [HomeController::class, 'taskdelete']);


Route::get('/barchart/view', [ChartController::class, 'viewTaskScheduleReport']);
Route::get('/approved-clients/report', [ChartController::class, 'viewApprovedClientsReport']);
Route::get('/paymentreport', [ChartController::class, 'showAllPayments']);
Route::get('/home/showCurrentDateAttendance', [ChartController::class, 'showCurrentDateAttendance']);
Route::get('/home/showEmployeeSalaries', [ChartController::class, 'showEmployeeSalaries']);
Route::get('/home/showallmonth', [ChartController::class, 'showallmonth']);
Route::get('/home/EmployeeSalaries', [ChartController::class, 'checkSalaryDate']);
Route::post('/admin/mark-salary-paid', [ChartController::class, 'markSalaryAsPaid']);


Route::get('/adminleaveview/{id}', [HomeController::class, 'leaveview']);
Route::post('/leave/approve/{id}', [HomeController::class, 'approveLeave']);


});



/// EMPLOYEE MODULE ///
    Route::middleware(['auth', 'useraccess:employee'])->group(function ()
    {
        Route::get('/home/employeehome', [AttendanceController::class, 'employeepage'])->name('employee.home');
        Route::post('/attendance/checkin', [AttendanceController::class, 'checkin'])->name('employee.checkin');
        Route::post('/attendance/checkout', [AttendanceController::class, 'checkout'])->name('employee.checkout');
        Route::get('/tasksheduleview', [AttendanceController::class, 'taskscheduleview']);
        Route::post('/taskupdate/{id}', [AttendanceController::class, 'taskemupdate']);

        Route::get('/leave', [AttendanceController::class, 'leave']);
        Route::post('/home/storeleave', [AttendanceController::class, 'applyLeave']);
       
        

        Route::get('/work-report', [AttendanceController::class, 'showForm']);
        Route::post('/submit-report', [AttendanceController::class, 'submitReport']);
        Route::get('/workreport/view', [AttendanceController::class, 'viewReport']);
    });
   
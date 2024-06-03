<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    public function viewTaskScheduleReport()
    {
        // Fetch task schedule data along with employee name
        $taskSchedules = DB::table('task_shedule')
        ->join('employee', 'task_shedule.assign_to', '=', 'employee.id')
        ->select('employee.name as employee_name', 'task_shedule.taskname', 'task_shedule.status')
        ->get();

    // Map numerical statuses to their corresponding percentage values
    $statusMap = [
        0 => 25,
        1 => 50,
        2 => 100,
    ];

    // Modify the status in the task schedule data
    foreach ($taskSchedules as $taskSchedule) {
        $taskSchedule->status_percentage = $statusMap[$taskSchedule->status] ?? 0;
    }
    
        // Pass the data to the view
        return view('admin.report', compact('taskSchedules'));
    }


    public function viewApprovedClientsReport(Request $request)
{
    $query = DB::table('clients');

    // Check if filters are applied
    if ($request->filled('paymentMethod')) {
        $paymentMethod = $request->input('paymentMethod');
        $query->where('payment_method', $paymentMethod);
    }

    if ($request->filled('status')) {
        $status = $request->input('status');
        $query->where('client_project_status', $status);
    }

    // Get the filtered approved clients
    $approvedClients = $query->get();

    return view('admin.clientreport', compact('approvedClients'));
}
public function showAllPayments(Request $request)
{
    // Fetch all payments along with the corresponding client name and balance
    $payments = DB::table('payments')
        ->join('clients', 'payments.client_id', '=', 'clients.id')
        ->select(
            'payments.*',
            'clients.client_name',
            'clients.balance as client_balance',
            'clients.total_amount'
        );

    $clients = DB::table('clients'); // Query builder instance

    // If search query is present, filter payments by client name or date
    if ($request->has('search')) {
        $search = $request->input('search');
        $payments->where(function ($query) use ($search) {
            $query->where('clients.client_name', 'like', "%$search%")
                  ->orWhere('payments.payment_date', 'like', "%$search%");
        });
        $clients->where('clients.client_name', 'like', "%$search%");
    }

    // Get the filtered payments
    $payments = $payments->get();

    // Get the filtered clients
    $clients = $clients->get();

    // Pass the data to the view
    return view('admin.client_payments', compact('payments', 'clients'));
}


public function showCurrentDateAttendance()
    {
        // Get the current date
        $currentDate = now()->toDateString();

        $attendanceData = DB::table('attendance')
        ->join('employee', 'attendance.user_id', '=', 'employee.id')
        ->select('attendance.*', 'employee.name as employee_name')
        ->whereDate('attendance.date', $currentDate)
        ->get();

        // Pass the data to the view
        return view('admin.atten-perdate', compact('attendanceData'));
    }
    public function showallmonth(Request $request)
    {
        try {
            // Fetch all employees
            $employees = DB::table('employee')
                ->select('employee.id', 'employee.name', 'employee.emptype', 'employee.salary')
                ->get();
    
            // Initialize an array to store salary data for each employee
            $salaryData = [];
    
            // Loop through each employee
            foreach ($employees as $employee) {
                // Fetch remaining salary for each month of the current year
                $remainingSalaries = [];
    
                // Loop through each month
                for ($month = 1; $month <= 12; $month++) {
                    // Calculate salary date for the current month
                    $salaryDate = Carbon::create(now()->year, $month, 1)->format('Y-m-d');
    
                    // Calculate next salary date by adding one month to the current date
                    $nextSalaryDate = Carbon::create(now()->year, $month, 1)->addMonth()->format('Y-m-d');
    
                    // Fetch remaining salary for the current month
                    $remainingSalary = DB::table('attendance')
                        ->where('user_id', $employee->id)
                        ->whereMonth('date', $month)
                        ->whereYear('date', now()->year)
                        ->sum('remaining_salary');
    
                    // Fetch the status from the salary_payment table
                    $status = DB::table('salary_payment')
                        ->where('employee_id', $employee->id)
                        ->where('paid_month', $month)
                        ->whereYear('paid_date', now()->year)
                        ->value('status');
    
                    // Add remaining salary, next salary date, and status to the array
                    $remainingSalaries[$month] = [
                        'date' => $salaryDate,
                        'amount' => $remainingSalary,
                        'next_salary_date' => $nextSalaryDate,
                        'status' => $status // Set the status
                    ];
                }
    
                // Add employee's salary data to the salaryData array
                $employee->remainingSalaries = $remainingSalaries;
                $salaryData[] = $employee;
            }
    
            // Pass the data to the view
            return view('admin.allmonthsalary', compact('salaryData'));
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    

    public function markSalaryAsPaid(Request $request)
    {
        try {
            // Retrieve employee ID and month from the request
            $employeeId = $request->input('employee_id');
            $month = $request->input('month');
    
            // Fetch the remaining salary for the current month
            $remainingSalary = DB::table('attendance')
                ->where('user_id', $employeeId)
                ->whereMonth('date', $month)
                ->whereYear('date', now()->year)
                ->sum('remaining_salary');
    
            // Update the database to mark the salary as paid for the specific employee and month
            DB::table('salary_payment')
                ->updateOrInsert(
                    ['employee_id' => $employeeId, 'paid_month' => $month],
                    ['status' => 'paid', 'paid_date' => now(), 'amount_paid' => $remainingSalary]
                );
    
            // Redirect back with success message or handle success response
            return redirect()->back()->with('success', 'Salary marked as paid successfully');
        } catch (\Exception $e) {
            // Handle exception
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}    
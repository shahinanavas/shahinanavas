<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function employeepage()
    {
        try {
            $user_id = Auth::user()->employeeid;
    
            $attendance = DB::table('attendance')
                ->where('user_id', $user_id)
                ->whereDate('date', Carbon::today('Asia/Kolkata'))
                ->first();
    
            $currentMonth = Carbon::now('Asia/Kolkata')->month;
            $previousMonth = Carbon::now('Asia/Kolkata')->subMonth()->month;
    
            // Fetch remaining salary for the current month
            $currentMonthRemainingSalary = DB::table('attendance')
                ->where('user_id', $user_id)
                ->whereMonth('date', $currentMonth)
                ->whereYear('date', Carbon::now('Asia/Kolkata')->year)
                ->sum('remaining_salary');
    
            // Fetch remaining salary for the previous month
            $previousMonthRemainingSalary = DB::table('attendance')
                ->where('user_id', $user_id)
                ->whereMonth('date', $previousMonth)
                ->whereYear('date', Carbon::now('Asia/Kolkata')->year)
                ->sum('remaining_salary');
    
            return view('Employee.employeehome', compact('attendance', 'currentMonthRemainingSalary', 'previousMonthRemainingSalary'));
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function checkin(Request $request)
{
    $user_id = Auth::user()->employeeid;
    $employee = DB::table('employee')->where('id', $user_id)->first();

    if (!$employee) {
        return redirect()->route('employee.home')->with('error', 'Employee record not found.');
    }

    $today = Carbon::today('Asia/Kolkata');
    $attendance = DB::table('attendance')
        ->where('user_id', $user_id)
        ->whereDate('date', $today)
        ->first();

    // If no attendance record for today, insert a new one
    if (!$attendance) {
        $lastAttendance = DB::table('attendance')
            ->where('user_id', $user_id)
            ->orderBy('date', 'desc')
            ->first();

        // Check if it's a new month
        $lastMonth = $lastAttendance ? Carbon::parse($lastAttendance->date)->month : null;
        $currentMonth = $today->month;

        // Reset remaining salary and total salary at the start of a new month
        if ($lastMonth !== $currentMonth) {
            $remainingSalary = $employee->salary;
            $totalSalary = $employee->salary;
        } else {
            $remainingSalary = $lastAttendance ? $lastAttendance->remaining_salary : $employee->salary;
            $totalSalary = $lastAttendance ? $lastAttendance->total_salary : $employee->salary;
        }

        DB::table('attendance')->insert([
            'user_id' => $user_id,
            'checkin_time' => Carbon::now('Asia/Kolkata'),
            'checkout_time' => null,
            'status' => 'Present',
            'day_salary' => 0,
            'salary_reduction' => 0,
            'remaining_salary' => $remainingSalary,
            'total_salary' => $totalSalary,
            'date' => $today,
        ]);
    } else {
        DB::table('attendance')
            ->where('id', $attendance->id)
            ->update([
                'checkin_time' => Carbon::now('Asia/Kolkata'),
                'status' => 'Present'
            ]);
    }

    return redirect()->route('employee.home')->with('success', 'Checked in successfully!');
}

    
    
    public function checkout(Request $request)
    {
        $user_id = Auth::user()->employeeid;
        $employee = DB::table('employee')->where('id', $user_id)->first();
    
        if (!$employee) {
            return redirect()->route('employee.home')->with('error', 'Employee record not found.');
        }
    
        $today = Carbon::today('Asia/Kolkata');
        $attendance = DB::table('attendance')
            ->where('user_id', $user_id)
            ->whereDate('date', $today)
            ->first();
    
        if ($attendance) {
            // Calculate the work hours
            $checkoutTime = Carbon::now('Asia/Kolkata');
            $checkinTime = Carbon::parse($attendance->checkin_time, 'Asia/Kolkata');
            $workHours = $checkinTime->diffInHours($checkoutTime);
    
            // Determine the attendance status based on work hours
            if ($workHours >= 9) {
                $status = 'Present';
                $daySalary = $employee->salary / 30;
                $salaryDeduction = 0;
            } elseif ($workHours >= 5) {
                $status = 'Half Day';
                $daySalary = ($employee->salary / 2) / 30;
                $salaryDeduction = ($employee->salary / 2) / 30;
            } else {
                $status = 'Absent';
                $daySalary = 0;
                $salaryDeduction = $employee->salary / 30;
            }
    
            // Reset remaining salary at the start of a new month
            if ($today->day == 1) {
                $remainingSalary = $employee->salary - $salaryDeduction;
            } else {
                $remainingSalary = $attendance->remaining_salary - $salaryDeduction;
                if ($remainingSalary < 0) {
                    $remainingSalary = 0;
                }
            }
    
            // Update the attendance record
            DB::table('attendance')
                ->where('id', $attendance->id)
                ->update([
                    'checkout_time' => $checkoutTime,
                    'status' => $status,
                    'day_salary' => $daySalary,
                    'total_salary' => $employee->salary,
                    'salary_reduction' => $attendance->salary_reduction + $salaryDeduction,
                    'remaining_salary' => $remainingSalary,
                ]);
    
            return redirect()->route('employee.home')
                ->with('success', 'Checked out successfully!')
                ->with('day_salary', $daySalary)
                ->with('deduction', $salaryDeduction)
                ->with('remaining_salary', $remainingSalary);
        } else {
            // If no attendance record exists, mark the employee as absent
            $salaryDeduction = $employee->salary / 30;
    
            DB::table('attendance')->insert([
                'user_id' => $user_id,
                'checkout_time' => Carbon::now('Asia/Kolkata'),
                'status' => 'Absent',
                'day_salary' => 0,
                'total_salary' => $employee->salary,
                'salary_reduction' => $salaryDeduction,
                'remaining_salary' => $employee->salary - $salaryDeduction,
                'date' => $today,
            ]);
    
            return redirect()->route('employee.home')->with('error', 'No attendance record found for today. Marked as absent.');
        }
    }
     
 
    
    // // Scheduled task to mark absentees at the end of the day
    // public function markAbsentees()
    // {
    //     $today = Carbon::now('Asia/Kolkata')->startOfDay();
    //     $weekday = $today->isWeekday(); // Check if today is a weekday

    //     // Proceed only if today is a weekday (assuming working days are weekdays)
    //     if ($weekday) {
    //         // Get all users
    //         $users = DB::table('users')->get();

    //         foreach ($users as $user) {
    //             // Check if the user has checked in today
    //             $hasCheckedIn = DB::table('attendance')
    //                 ->where('user_id', $user->id)
    //                 ->whereDate('date', $today)
    //                 ->exists();

    //             // If the user hasn't checked in today, mark as absent
    //             if (!$hasCheckedIn) {
    //                 $employee = DB::table('employee')->where('id', $user->id)->first();
    //                 if ($employee) {
    //                     // Calculate salary reduction
    //                     $dailyReduction = $employee->salary / 30;

    //                     // Calculate remaining salary
    //                     $lastAttendance = DB::table('attendance')
    //                         ->where('user_id', $user->id)
    //                         ->orderBy('date', 'desc')
    //                         ->first();
    //                     $remainingSalary = $lastAttendance ? $lastAttendance->remaining_salary - $dailyReduction : $employee->salary - $dailyReduction;
    //                     if ($remainingSalary < 0) {
    //                         $remainingSalary = 0;
    //                     }

    //                     // Insert attendance record with salary reduction and remaining salary
    //                     DB::table('attendance')->insert([
    //                         'user_id' => $user->id,
    //                         'checkin_time' => null,
    //                         'checkout_time' => null,
    //                         'status' => 'Absent',
    //                         'day_salary' => 0, 
    //                         'salary_reduction' => $dailyReduction,
    //                         'remaining_salary' => $remainingSalary,
    //                         'date' => $today,
    //                     ]);
    //                 }
    //             }
    //         }
    //     }

    //     return response()->json(['message' => 'Absentees marked and salaries calculated successfully.']);
    // }
    public function taskscheduleview()
    {
        $user_id = Auth::user()->employeeid;
        $currentDate = now()->format('Y-m-d');
    
        $tasks = DB::table('task_shedule')
            ->join('employee', 'task_shedule.assign_to', '=', 'employee.id')
            ->where('employee.id', $user_id)
            ->whereDate('task_shedule.allocationdate', '<=', $currentDate)
            ->whereDate('task_shedule.deadlinedate', '>=', $currentDate)
            ->select('task_shedule.*', 'employee.name as assigned_to_name')
            ->get();
    
        foreach ($tasks as $task) {
            if ($task->deadlinedate == $currentDate) {
                $this->sendTaskReminder($task);
            }
        }
    
        return view('employee.tasks', compact('tasks'));
    }
    
 
    public function taskemupdate(Request $request, $id)
    {
        $validatedData = $request->validate([
            'status' => 'required|in:0,1,2', 
        ]);
        DB::table('task_shedule')->where('id', $id)->update(['status' => $validatedData['status']]);

        return redirect()->back()->with('success', 'Task status updated successfully.');
    }


   // Function to send a reminder for a task
   private function sendTaskReminder($task)
   {
       echo "<script>";
       echo "alert('Task reminder: Deadline for task \"{$task->taskname}\" is today!');";
       echo "</script>";
   }
  

    
    public function showForm()
    {
        $user_id = Auth::user()->employeeid;

        $attendance = DB::table('attendance')
            ->where('user_id', $user_id)
            ->whereDate('date', Carbon::today('Asia/Kolkata'))
            ->first();
        $current_date = Carbon::today('Asia/Kolkata')->format('Y-m-d');
        $checkin_time = $attendance ? Carbon::parse($attendance->checkin_time, 'Asia/Kolkata')->format('H:i') : null;
        $checkout_time = $attendance ? ($attendance->checkout_time ? Carbon::parse($attendance->checkout_time, 'Asia/Kolkata')->format('H:i') : null) : null;

        return view('employee.workreport', compact('current_date', 'checkin_time', 'checkout_time'));

    }

   
        public function submitReport(Request $request)
        {
           $user_id = Auth::user()->employeeid;

        // Insert work report into the database
        DB::table('work_reports')->insert([
            'user_id' => $user_id,
            'date' => $request->date,
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
            'work_report' => $request->work_report,
        ]);
            return redirect()->back()->with('success', 'Task status updated successfully.');
        }

        public function viewReport()
        {
            $user_id = Auth::user()->employeeid;
            $current_date = Carbon::today('Asia/Kolkata')->format('Y-m-d');
    
            // Fetch the work report for the current date
            $work_report = DB::table('work_reports')
                ->where('user_id', $user_id)
                ->whereDate('date', Carbon::today('Asia/Kolkata'))
                ->first();
    
            return view('employee.viewreport', compact('current_date', 'work_report'));
        }

        
        

        //leave apply

        public function leave(){
            return view('employee.leaveadd');
        }

        public function applyLeave(Request $request)
        {
   // Validate input
   $request->validate([
    'typeleave' => 'required',
    'reason' => 'required',
]);

// Calculate total days if start and end dates are provided
$totalDays = null;
if ($request->filled('startdate') && $request->filled('enddate')) {
    $totalDays = Carbon::parse($request->startdate)->diffInDays(Carbon::parse($request->enddate)) + 1;
} else {
    // Set a default value for totaldays if start and end dates are not provided
    $totalDays = 0;
}

// Store leave application
DB::table('leave')->insert([
    'user_id' => Auth::user()->employeeid,
    'typeleave' => $request->typeleave,
    'date' => $request->date,
    'startdate' => $request->startdate,
    'enddate' => $request->enddate,
    'totaldays' => $totalDays, // Use the calculated or default value
    'reason' => $request->reason,
    'status' => 'pending',
    'created_at' => now(),
    'updated_at' => now(),
]);

return redirect()->back()->with('success', 'Leave application submitted successfully.');
}
}
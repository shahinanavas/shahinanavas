<?php

namespace App\Http\Controllers;

use Auth;
use Carbon\Carbon; 
use App\Models\Client;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    public function adminpage()





    
    {$totalEmployees = DB::table('employee')->count();

        // Count total clients
        $totalClients = DB::table('clients')->count();
    
        // Count total projects
        $totalProjects = DB::table('projects')->count();
    
        // Count total tasks
        $totalTasks = DB::table('task_shedule')->count();


        $todayAbsentCount = DB::table('attendance')
        ->whereDate('date', Carbon::today())
        ->where('status', 'Absent')
        ->count();



        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        
        // Fetch attendance records for the current month including employee names
        $attendanceData = DB::table('attendance')
            ->select('attendance.*', 'employee.name as employee_name')
            ->join('employee', 'attendance.user_id', '=', 'employee.id')
            ->whereYear('attendance.date', $currentYear)
            ->whereMonth('attendance.date', $currentMonth)
            ->get();
        return view('Admin.adminhome',compact('totalEmployees', 'totalClients', 'totalProjects', 'totalTasks','todayAbsentCount','attendanceData'));
    }
   
    public function checkSalaryDate()
    {
        $today = now();
        $currentDay = $today->day;
        $currentMonth = $today->month;
    
        $employees = DB::table('employees')
            ->whereRaw('DAY(salary_date) = ?', [$currentDay])
            ->whereRaw('MONTH(salary_date) = ?', [$currentMonth])
            ->get();
    
        return view('admin.adminhome', compact('employees'));
    }

    
    
    

        // Display the list of employees
        public function employeeview()
        {
            $view = DB::table('employee')->get();
            return view('Admin.employeeview', compact('view'));
        }
    
        public function employeeadd()
        {
            return view('Admin.employeeadd');
        }
    public function employeestore(Request $request)
{
    // Validate the incoming request
    $request->validate([
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust the validation rules as needed
    ]);

    // Check if a file has been uploaded
    if ($request->hasFile('image')) {
        $file = $request->file('image');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('images', $filename, 'public');

        $empid = DB::table('employee')->insertGetId([
            'name' => $request->name,
            'employee_address' => $request->employee_address,
            'aadhar_no' => $request->aadhar_no,
            'dob' => $request->dob,
            'qualification' => $request->qualification,
            'phone_no' => $request->phone_no,
            'designation' => $request->designation,
            'emptype' => $request->emptype,
            'join_date' => $request->join_date,
            'salary' => $request->salary,
            'salary_date' => $request->salary_date,
            'image' => '/storage/' . $path, // Correctly set the image path
        ]);

        $data = $request->except('_token', 'employee_address', 'aadhar_no', 'dob', 'qualification', 'phone_no', 'designation', 'emptype', 'join_date', 'salary', 'salary_date', 'image');
        $data['type'] = 1;
        $data['password'] = Hash::make($data['password']);
        $data['employeeid'] = $empid;

        DB::table('users')->insertGetId($data);

        return redirect('/home/employeeview')->with('success', 'Employee added successfully!');
    } else {
        // Handle case when no file is uploaded
        return back()->with('error', 'No image uploaded');
    }
}

        
        public function employeeedit($id)
    {
        $view = DB::table('employee')->where('id', $id)->first();
        return view('Admin.employeeedit', compact('view'));
    }
  

    public function employeeupdate(Request $request, $id)
{
    
    // Validate the incoming request
    $request->validate([
        'name' => 'required|string|max:255',
        'employee_address' => 'required|string|max:255',
        'aadhar_no' => 'required|string|max:12',
        'dob' => 'required|date',
        'qualification' => 'required|string|max:255',
        'phone_no' => 'required|string|max:15',
        'designation' => 'required|string|max:255',
        'emptype' => 'required|string|max:255',
        'join_date' => 'required|date',
        'salary' => 'required|numeric',
        'salary_date' => 'required|date',
        // Exclude image validation as image update is not needed
    ]);

    // Find the existing employee record
    $employee = DB::table('employee')->where('id', $id)->first();

    // If employee not found, redirect back with an error
    if (!$employee) {
        return back()->with('error', 'Employee not found');
    }

    // Initialize the data to be updated
    $updateData = [
        'name' => $request->name,
        'employee_address' => $request->employee_address,
        'aadhar_no' => $request->aadhar_no,
        'dob' => $request->dob,
        'qualification' => $request->qualification,
        'phone_no' => $request->phone_no,
        'designation' => $request->designation,
        'emptype' => $request->emptype,
        'join_date' => $request->join_date,
        'salary' => $request->salary,
        'salary_date' => $request->salary_date,
        // Do not update the image field
    ];

    // Update the employee record
    DB::table('employee')->where('id', $id)->update($updateData);

    // Also exclude _method and _token fields
    $userData = $request->except(
        '_method', '_token', 'employee_address', 'aadhar_no', 'dob', 'qualification', 
        'phone_no', 'designation', 'emptype', 'join_date', 'salary', 'salary_date', 
        'email', 'password', 'image'
    );
    $userData['type'] = 1;

    // Update the user record
    DB::table('users')->where('employeeid', $id)->update($userData);

    return redirect('/home/employeeview')->with('success', 'Employee updated successfully!');
}

   
public function employeedelete($id)
{
    DB::table('users')->where('employeeid', $id)->delete();
    DB::table('employee')->where('id', $id)->delete();
    return redirect('/home/employeeview')->with('success', 'Employee deleted successfully!');
}





    //CLIENT PAGE IN ADMIN
    
        public function clientview()
    {
        $clients = DB::table('clients')->get();
        return view('Admin.clientview', compact('clients'));
    }

    public function clientadd()
    {
        return view('Admin.clientadd');
    }

    public function clientstore(Request $request)
    {
        // Validate the incoming request
        $data = $request->validate([
            'client_name' => 'required|string|max:255',
            'client_address' => 'required|string|max:255',
            'client_phone_no' => 'nullable|string|max:20',
            'project_name' => 'required|string|max:255',
            'project_type' => 'required|string|max:255',
            'project_type_detail' => 'nullable|string|max:255',
            'client_project_status' => 'required|string|max:255',
            'amount_paid' => 'required|numeric',
            'balance' => 'required|numeric',
            'quotation_sent' => 'nullable|string|max:3',
            'quotation_file' => 'nullable|file|mimes:pdf,doc,docx|max:2048', // Validate file type and size
            'quotation_status' => 'nullable|string|max:255',
            'payment_method' => 'nullable|string|max:255'
        ]);
    
        // Check if a file has been uploaded
        if ($request->hasFile('quotation_file')) {
            // Generate a unique filename
            $quotationFileName = time() . '_' . $request->file('quotation_file')->getClientOriginalName();
            // Store the file in the 'public/quotation_files' directory
            $path = $request->file('quotation_file')->storeAs('quotation_files', $quotationFileName, 'public');
            // Store the relative path to the file in the data array
            $data['quotation_file'] = $path;
        }
    
        // Calculate the total amount
        $data['total_amount'] = $data['amount_paid'] + $data['balance'];
    
        // Insert the data into the 'clients' table
        // DB::table('clients')->insert($data);
        // Insert the data into the 'clients' table
        $client = Client::create($data);

        // Create a new Payment record
        $payment = new Payment();
        $payment->client_id = $client->id; // Use the client ID from the created client
        $payment->amount_paid = $data['amount_paid'];
        // Check if payment_method is set, otherwise set it to null
        $payment->payment_method = isset($data['payment_method']) ? $data['payment_method'] : null;
        $payment->payment_date = now(); // Use Carbon's now() method to get the current date and time
        $payment->save();

        // Redirect to the client view with a success message
        return redirect('/home/clientview')->with('success', 'Client added successfully!');
    }
    

public function clientedit($id)
{
    $client = DB::table('clients')->where('id', $id)->first();
    return view('admin.clientedit', compact('client'));
}

public function clientupdate(Request $request, $id)
{
    try {
        // Validate the incoming request
        $data = $request->validate([
            'client_name' => 'required|string|max:255',
            'client_address' => 'required|string|max:255',
            'client_phone_no' => 'nullable|string|max:20',
            'project_name' => 'required|string|max:255',
            'project_type' => 'required|string|max:255',
            'project_type_detail' => 'nullable|string|max:255',
            'client_project_status' => 'required|string|max:255',
            'amount_paid' => 'required|numeric',
            'quotation_sent' => 'nullable|string|max:3',
            'quotation_file' => 'nullable|file|mimes:pdf,doc,docx|max:2048', // Ensure file validation
            'quotation_status' => 'nullable|string|max:255',
            'payment_method' => 'required|string|max:255' // Add validation for payment_method
        ]);

        // Calculate the new amount_paid and balance
        $client = DB::table('clients')->where('id', $id)->first();
        $newAmountPaid = $data['amount_paid'] + $client->amount_paid;
        $newBalance = $client->total_amount - $newAmountPaid;

        // Update the client record in the database
        $update = DB::table('clients')->where('id', $id)->update([
            'client_name' => $data['client_name'],
            'client_address' => $data['client_address'],
            'client_phone_no' => $data['client_phone_no'],
            'project_name' => $data['project_name'],
            'project_type' => $data['project_type'],
            'project_type_detail' => $data['project_type_detail'],
            'client_project_status' => $data['client_project_status'],
            'amount_paid' => $newAmountPaid,
            'balance' => $newBalance,
            'quotation_sent' => $data['quotation_sent'],
            'quotation_file' => $data['quotation_file'],
            'quotation_status' =>$data['quotation_status'],
            'payment_method' => $data['payment_method'],
            // Update other fields as needed...
        ]);

        // Create a new ClientPayment record for the updated payment
        $payment = new Payment();
        $payment->client_id = $id; // Use the provided client ID
        $payment->amount_paid = $data['amount_paid'];
        $payment->payment_date = Carbon::now(); // Set payment date
        $payment->payment_method = $data['payment_method']; // Set payment method
        $payment->save();

        // Check if the update was successful
        if ($update) {
            return redirect('/home/clientview')->with('success', 'Client updated successfully!');
        } else {
            return redirect('/home/clientview')->with('error', 'Failed to update client. No records updated.');
        }
    } catch (\Exception $e) {
        // Log the error for debugging
        Log::error('Client update failed: ' . $e->getMessage());
        return redirect('/home/clientview')->with('error', 'An error occurred while updating the client.');
    }
}



public function clientdelete(Request $request)
{
    DB::table('clients')->where('id', $request->input('id'))->delete();
    return redirect('/home/clientview')->with('success', 'Client deleted successfully!');
}





//PROJECT IN ADMIN

 public function projectview()
 {
    $projects = DB::table('projects')->get();
    return view('Admin.projectview', compact('projects'));
 }

 public function projectadd()
 {
     $clients = DB::table('clients')->get();
     return view('Admin.projectadd', compact('clients'));
 }

 public function projectstore(Request $request)
 {
     $data = $request->validate([
         'projectname' => 'required|string|max:255',
         'project_description' => 'required|string',
         'start_date' => 'required|date',
         'end_date' => 'required|date',
     ]);

     DB::table('projects')->insert($data);

     return redirect('/home/projectview')->with('success', 'Project added successfully!');
 }

 public function projectedit($id)
    {
        $project = DB::table('projects')->where('id', $id)->first();
        return view('admin.projectedit', compact('project'));
    }

    public function projectupdate(Request $request, $id)
    {
        $request->validate([
            'projectname' => 'required|string|max:255',
            'project_description' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);
        DB::table('projects')
            ->where('id', $id)
            ->update([
                'projectname' => $request->projectname,
                'project_description' => $request->project_description,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'updated_at' => now(),
            ]);
        return redirect('/home/projectview')->with('success', 'Project updated successfully');
    }
 
 public function projectdelete($id)
 {
     DB::table('projects')->where('id', $id)->delete();

     return redirect('/admin/projectview')->with('success', 'Project deleted successfully!');
 }



 //EMPLOYEE TEAM IN ADMIN
 public function employeeteamadd()
 {
     $projects = DB::table('projects')->get();
     $employees = DB::table('employee')->get();
     return view('Admin.employeeteamadd', compact('projects', 'employees'));
 }

 



 


 //TASK SHEDULE IN ADMIN PAGE
 public function showForm()
 {
     $projects = DB::table('projects')->select('projectname')->get();
     $teams = DB::table('teams')->select( 'teamname')->get();
     $assigns = DB::table('teams')->select('member')->get();
     return view('admin.add-task', compact('projects', 'teams', 'assigns'));
 }


 
 //INDIVIDEUAL TASK SHEDULE IN ADMIN
 public function taskview()
 {
     $tasks = DB::table('task_shedule')
         ->join('employee', 'task_shedule.assign_to', '=', 'employee.id')
         ->select('task_shedule.*', 'employee.name as assigned_to_name')
         ->get();
 
     return view('admin.taskview', compact('tasks'));
 }
 public function taskadd()
 {
     $projects = DB::table('projects')->get();
     $assigns = DB::table('employee')->get();
     return view('admin.taskadd', compact('projects', 'assigns'));
 }

 public function taskstore(Request $request)
 {
     $validatedData = $request->validate([
         'name' => 'required',
         'assign_to' => 'required',
         'taskname' => 'required',
         'taskdescription' => 'required',
         'allocationdate' => 'required|date',
         'deadlinedate' => 'required|date',
     ]);

     DB::table('task_shedule')->insert([
        'name' => $validatedData['name'],
        'assign_to' => $validatedData['assign_to'], // This should be the ID of the assignee
        'taskname' => $validatedData['taskname'],
        'taskdescription' => $validatedData['taskdescription'],
        'allocationdate' => $validatedData['allocationdate'],
        'deadlinedate' => $validatedData['deadlinedate'],
    ]);

     return redirect()->back()->with('success', 'Team created successfully.');
 }

 public function taskedit($id)
 {
     $task = DB::table('task_shedule')->where('id', $id)->first();
     $projects = DB::table('projects')->get();
     $assigns = DB::table('employee')->get();
 
     return view('admin.taskedit', compact('task', 'projects', 'assigns'));
 }
 

 public function taskupdate(Request $request, $id)
{
    $validatedData = $request->validate([
        'name' => 'required',
        'assign_to' => 'required|exists:employee,id',
        'taskname' => 'required',
        'taskdescription' => 'required',
        'allocationdate' => 'required|date',
        'deadlinedate' => 'required|date',
    ]);

    DB::table('task_shedule')->where('id', $id)->update([
        'name' => $validatedData['name'],
        'assign_to' => $validatedData['assign_to'],
        'taskname' => $validatedData['taskname'],
        'taskdescription' => $validatedData['taskdescription'],
        'allocationdate' => $validatedData['allocationdate'],
        'deadlinedate' => $validatedData['deadlinedate'],
        'updated_at' => now(),
    ]);


     return redirect('/taskview')->with('success', 'Task updated successfully.');
 }

 public function taskdelete(Request $request)
 {
     $id = $request->id;
     DB::table('task_schedule')->where('id', $id)->delete();

     return redirect('/taskview')->with('success', 'Task deleted successfully!');
 }

 public function leaveview($id) {
  
    $leaveApplications = DB::table('leave')
    ->join('employee', 'leave.user_id', '=', 'employee.id')
    ->select('leave.*', 'employee.name as employee_name')->get();
    
    return view('admin.leavestatus', compact('leaveApplications'));
}


// public function approveLeave($id) {
//     // Get the leave details
//     $leaveDetails = DB::table('leave')->where('id', $id)->first();
//     $status = request()->input('status');
//     // Update the status in the database
//     DB::table('leave')->where('id', $id)->update(['status' => $status]);

//     // If leave is accepted
//     if ($leaveDetails->status == 'Accepted') {
//         // Calculate salary deduction
//         $employee = DB::table('employee')->where('id', $leaveDetails->user_id)->first();
//         $dailySalary = $employee->salary / 30; // Daily salary
//         $totalLeaveDays = $leaveDetails->totaldays;

//         // Mark leave days as absent and reduce salary
//         if ($leaveDetails->startdate && $leaveDetails->enddate) {
//             // If leave spans multiple days
//             $startDate = Carbon::parse($leaveDetails->startdate);
//             $endDate = Carbon::parse($leaveDetails->enddate);

//             while ($startDate <= $endDate) {
//                 DB::table('attendance')->insert([
//                     'user_id' => $leaveDetails->user_id,
//                     'date' => $startDate->toDateString(),
//                     'status' => 'Absent',
//                     'salary_reduction' => $dailySalary, // Daily salary reduction for leave day
//                     'remaining_salary' => $employee->salary - $dailySalary, // Remaining salary after deduction
//                     'total_salary' => $employee->salary, // Total salary remains same
//                     'day_salary' => 0, // Assuming no salary for leave
//                     'total_day_salary' => 0 // Assuming no total salary for leave
//                 ]);
//                 $startDate->addDay();
//             }
//         } else {
//             // If leave is for a single day
//             DB::table('attendance')->insert([
//                 'user_id' => $leaveDetails->user_id,
//                 'date' => $leaveDetails->date,
//                 'status' => 'Absent',
//                 'salary_reduction' => $dailySalary, // Salary reduction for leave day
//                 'remaining_salary' => $employee->salary - $dailySalary, // Remaining salary after deduction
//                 'total_salary' => $employee->salary, // Total salary remains same
//                 'day_salary' => 0, // Assuming no salary for leave
//                 'total_day_salary' => 0 // Assuming no total salary for leave
//             ]);
//         }
//     }

//     return redirect()->back()->with('success', 'Leave status updated successfully.');
// }


//salary correct reduction with remaning 
// public function approveLeave($id) {
//     // Get the leave details
//     $leaveDetails = DB::table('leave')->where('id', $id)->first();
//     $status = request()->input('status');
//     // Update the status in the database
//     DB::table('leave')->where('id', $id)->update(['status' => $status]);

//     // If leave is accepted
//     if ($status == '1') {
//         // Calculate salary deduction
//         $employee = DB::table('employee')->where('id', $leaveDetails->user_id)->first();
//         $dailySalary = $employee->salary / 30; // Daily salary

//         // Check if salary deduction has occurred this month
//         $lastDeductionMonth = DB::table('attendance')
//             ->where('user_id', $leaveDetails->user_id)
//             ->whereMonth('date', '=', Carbon::now()->month)
//             ->latest()
//             ->first();

//         // Use remaining salary for deduction if deduction has occurred this month
//         $remainingSalary = ($lastDeductionMonth) ? $lastDeductionMonth->remaining_salary : $employee->salary;

//         // Mark leave days as absent and reduce salary
//         if ($leaveDetails->startdate && $leaveDetails->enddate) {
//             // If leave spans multiple days
//             $startDate = Carbon::parse($leaveDetails->startdate);
//             $endDate = Carbon::parse($leaveDetails->enddate);

//             while ($startDate <= $endDate) {
//                 DB::table('attendance')->insert([
//                     'user_id' => $leaveDetails->user_id,
//                     'date' => $startDate->toDateString(),
//                     'status' => 'Absent',
//                     'salary_reduction' => $dailySalary, // Daily salary reduction for leave day
//                     'remaining_salary' => $remainingSalary - $dailySalary, // Remaining salary after deduction
//                     'total_salary' => $employee->salary, // Total salary remains same
//                     'day_salary' => 0, // Assuming no salary for leave
//                     'total_day_salary' => 0 // Assuming no total salary for leave
//                 ]);
//                 $remainingSalary -= $dailySalary; // Update remaining salary for subsequent deductions
//                 $startDate->addDay();
//             }
//         } else {
//             // If leave is for a single day
//             DB::table('attendance')->insert([
//                 'user_id' => $leaveDetails->user_id,
//                 'date' => $leaveDetails->date,
//                 'status' => 'Absent',
//                 'salary_reduction' => $dailySalary, // Salary reduction for leave day
//                 'remaining_salary' => $remainingSalary - $dailySalary, // Remaining salary after deduction
//                 'total_salary' => $employee->salary, // Total salary remains same
//                 'day_salary' => 0, // Assuming no salary for leave
//                 'total_day_salary' => 0 // Assuming no total salary for leave
//             ]);
//         }
//     }

//     return redirect()->back()->with('success', 'Leave status updated successfully.');
// }

public function approveLeave($id) {
    // Get the leave details
    $leaveDetails = DB::table('leave')->where('id', $id)->first();
    $status = request()->input('status');
    // Update the status in the database
    DB::table('leave')->where('id', $id)->update(['status' => $status]);

    // Get the current month and year
    $currentMonth = Carbon::now()->month;
    $currentYear = Carbon::now()->year;

    // If leave is accepted
    if ($status == '1') {
        // Calculate salary deduction
        $employee = DB::table('employee')->where('id', $leaveDetails->user_id)->first();

        // Check if salary deduction has occurred this month
        $lastDeductionMonth = DB::table('attendance')
            ->where('user_id', $leaveDetails->user_id)
            ->whereYear('date', '=', $currentYear)
            ->whereMonth('date', '=', $currentMonth)
            ->latest()
            ->first();

        // Use remaining salary for deduction if deduction has occurred this month
        $remainingSalary = ($lastDeductionMonth) ? $lastDeductionMonth->remaining_salary : $employee->salary;

        // Calculate daily salary
        $dailySalary = $employee->salary / Carbon::now()->daysInMonth; // Daily salary

        // Mark leave days as absent and reduce salary
        if ($leaveDetails->startdate && $leaveDetails->enddate) {
            // If leave spans multiple days
            $startDate = Carbon::parse($leaveDetails->startdate);
            $endDate = Carbon::parse($leaveDetails->enddate);

            while ($startDate <= $endDate) {
                DB::table('attendance')->insert([
                    'user_id' => $leaveDetails->user_id,
                    'date' => $startDate->toDateString(),
                    'status' => 'Absent',
                    'salary_reduction' => $dailySalary, // Daily salary reduction for leave day
                    'remaining_salary' => $remainingSalary - $dailySalary, // Remaining salary after deduction
                    'total_salary' => $employee->salary, // Total salary remains same
                    'day_salary' => 0, // Assuming no salary for leave
                    'total_day_salary' => 0 // Assuming no total salary for leave
                ]);
                $remainingSalary -= $dailySalary; // Update remaining salary for subsequent deductions
                $startDate->addDay();
            }
        } else {
            // If leave is for a single day
            DB::table('attendance')->insert([
                'user_id' => $leaveDetails->user_id,
                'date' => $leaveDetails->date,
                'status' => 'Absent',
                'salary_reduction' => $dailySalary, // Salary reduction for leave day
                'remaining_salary' => $remainingSalary - $dailySalary, // Remaining salary after deduction
                'total_salary' => $employee->salary, // Total salary remains same
                'day_salary' => 0, // Assuming no salary for leave
                'total_day_salary' => 0 // Assuming no total salary for leave
            ]);
        }
    } elseif ($status == '0') { // If leave status changed to pending
        // Check if there are records to delete
        $recordsToDelete = DB::table('attendance')
                            ->where('user_id', $leaveDetails->user_id)
                            ->whereBetween('date', [$leaveDetails->startdate, $leaveDetails->enddate])
                            ->get();

        if ($recordsToDelete->isNotEmpty()) {
            // Delete records from attendance table for the leave
            $deleted = DB::table('attendance')
                       ->where('user_id', $leaveDetails->user_id)
                       ->whereBetween('date', [$leaveDetails->startdate, $leaveDetails->enddate])
                       ->delete();

            if ($deleted) {
                // Log a message or add a debug statement
                Log::info('Attendance records deleted successfully.');
            } else {
                // Log an error or add a debug statement
                Log::error('Failed to delete attendance records.');
            }
        } else {
            // Log a message or add a debug statement
            Log::info('No attendance records found for deletion.');
        }
    }

    return redirect()->back()->with('success', 'Leave status updated successfully.');
}


}
    //NEXT FOLDER
   


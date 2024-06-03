<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckSalaryDate
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $today = now();
        $currentDay = $today->day;
        $currentMonth = $today->month;

        // Fetch employees whose salary date matches the current day and month
        $employees = DB::table('employees')
            ->whereRaw('DAY(salary_date) = ?', [$currentDay])
            ->whereRaw('MONTH(salary_date) = ?', [$currentMonth])
            ->get();

        if ($employees->isNotEmpty()) {
            session()->flash('salaryNotification', $employees);
        }

        return $next($request);
    }
}

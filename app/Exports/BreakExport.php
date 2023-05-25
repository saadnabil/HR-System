<?php

namespace App\Exports;

use App\Models\Employee;
use App\Models\Loan;
use App\Models\PaySlip;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;

class BreakExport implements FromView
{
    protected $employee;

    function __construct($employee) {
        $this->employee = $employee;
    }

    public function view(): View
    {
        $employee = $this->employee;
        return view('new-theme.exports.employee.breaks', [
            'breaks' => $employee->employee_breaks()
            ->select("employee_breaks.*",DB::raw("TIMEDIFF(start_time, end_time) AS diff"))->get()
        ]);
    }
}

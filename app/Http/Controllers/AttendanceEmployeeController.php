<?php

namespace App\Http\Controllers;

use App\Models\AttendanceEmployee;
use App\Models\Branch;
use App\Models\Department;
use App\Models\Employee;
use App\Models\IpRestrict;
use App\Models\User;
use App\Models\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceEmployeeController extends Controller
{
    public function index(Request $request)
    {
        if(auth()->user()->can('Manage Attendance'))
        {
            $branch = Branch::get()->pluck('name', 'id');
            $branch->prepend('All', '');

            $department = Department::get()->pluck('name', 'id');
            $department->prepend('All', '');

            if(auth()->user()->type == 'employee')
            {

                $emp = !empty(auth()->user()->employee) ? auth()->user()->employee->id : 0;

                $attendanceEmployee = AttendanceEmployee::where('employee_id', $emp);

                if($request->type == 'monthly' && !empty($request->month))
                {
                    $month = date('m', strtotime($request->month));
                    $year  = date('Y', strtotime($request->month));

                    $start_date = date($year . '-' . $month . '-01');
                    $end_date   = date($year . '-' . $month . '-t');

                    $attendanceEmployee->whereBetween(
                        'date', [
                                  $start_date,
                                  $end_date,
                              ]
                    );
                }
                elseif($request->type == 'daily' && !empty($request->date))
                {
                    $attendanceEmployee->where('date', $request->date);
                }
                else
                {
                    $month      = date('m');
                    $year       = date('Y');
                    $start_date = date($year . '-' . $month . '-01');
                    $end_date   = date($year . '-' . $month . '-t');

                    $attendanceEmployee->whereBetween(
                        'date', [
                                  $start_date,
                                  $end_date,
                              ]
                    );
                }
                $attendanceEmployee = $attendanceEmployee->get();

            }
            else
            {
                $employee = Employee::select('id')->where('created_by', auth()->user()->creatorId());
                if(!empty($request->branch))
                {
                    $employee->where('branch_id', $request->branch);
                }

                if(!empty($request->department))
                {
                    $employee->where('department_id', $request->department);
                }

                $employee = $employee->get()->pluck('id');

                $attendanceEmployee = AttendanceEmployee::whereIn('employee_id', $employee);

                if($request->type == 'monthly' && !empty($request->month))
                {
                    $month = date('m', strtotime($request->month));
                    $year  = date('Y', strtotime($request->month));

                    $start_date = date($year . '-' . $month . '-01');
                    $end_date   = date($year . '-' . $month . '-t');

                    $attendanceEmployee->whereBetween(
                        'date', [
                                  $start_date,
                                  $end_date,
                              ]
                    );
                }
                elseif($request->type == 'daily' && !empty($request->date))
                {
                    $attendanceEmployee->where('date', $request->date);
                }
                else
                {
                    $month      = date('m');
                    $year       = date('Y');
                    $start_date = date($year . '-' . $month . '-01');
                    $end_date   = date($year . '-' . $month . '-t');

                    $attendanceEmployee->whereBetween(
                        'date', [
                                  $start_date,
                                  $end_date,
                              ]
                    );
                }


                $attendanceEmployee = $attendanceEmployee->get();

            }

            return view('attendance.index', compact('attendanceEmployee', 'branch', 'department'));
        }
        else
        {
            flash()->addError(__('Permission denied'));
            return redirect()->back();
        }
    }

    public function create()
    {
        if(auth()->user()->can('Create Attendance'))
        {
            $employees = User::where('type', '=', "employee")->get()->pluck('name', 'id');

            return view('attendance.create', compact('employees'));
        }
        else
        {
            flash()->addError(__('Permission denied'));
            return redirect()->back();
        }


    }

    public function store(Request $request)
    {
        if(auth()->user()->can('Create Attendance'))
        {
            $validator = \Validator::make(
                $request->all(), [
                                   'employee_id' => 'required',
                                   'date' => 'required',
                                   'clock_in' => 'required',
                                   'clock_out' => 'required',
                               ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $startTime  = Utility::getValByName('company_start_time');
            $endTime    = Utility::getValByName('company_end_time');
            $attendance = AttendanceEmployee::where('employee_id', '=', $request->employee_id)->where('date', '=', $request->date)->where('clock_out', '=', '00:00:00')->get()->toArray();
            if($attendance)
            {
                return redirect()->route('attendanceemployee.index')->with('error', __('Employee Attendance Already Created.'));
            }
            else
            {
                $date = date("Y-m-d");

                $totalLateSeconds = strtotime($request->clock_in) - strtotime($date . $startTime);

                $hours = floor($totalLateSeconds / 3600);
                $mins  = floor($totalLateSeconds / 60 % 60);
                $secs  = floor($totalLateSeconds % 60);
                $late  = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);

                //early Leaving
                $totalEarlyLeavingSeconds = strtotime($date . $endTime) - strtotime($request->clock_out);
                $hours                    = floor($totalEarlyLeavingSeconds / 3600);
                $mins                     = floor($totalEarlyLeavingSeconds / 60 % 60);
                $secs                     = floor($totalEarlyLeavingSeconds % 60);
                $earlyLeaving             = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);


                if(strtotime($request->clock_out) > strtotime($date . $endTime))
                {
                    //Overtime
                    $totalOvertimeSeconds = strtotime($request->clock_out) - strtotime($date . $endTime);
                    $hours                = floor($totalOvertimeSeconds / 3600);
                    $mins                 = floor($totalOvertimeSeconds / 60 % 60);
                    $secs                 = floor($totalOvertimeSeconds % 60);
                    $overtime             = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
                }
                else
                {
                    $overtime = '00:00:00';
                }

                $employeeAttendance                = new AttendanceEmployee();
                $employeeAttendance->employee_id   = $request->employee_id;
                $employeeAttendance->date          = $request->date;
                $employeeAttendance->status        = 'Present';
                $employeeAttendance->clock_in      = $request->clock_in . ':00';
                $employeeAttendance->clock_out     = $request->clock_out . ':00';
                $employeeAttendance->late          = $late;
                $employeeAttendance->early_leaving = $earlyLeaving;
                $employeeAttendance->overtime      = $overtime;
                $employeeAttendance->total_rest    = '00:00:00';
                $employeeAttendance->created_by    = auth()->user()->creatorId();
                $employeeAttendance->save();

                return redirect()->route('attendanceemployee.index')->with('success', __('Employee attendance successfully created.'));
            }
        }
        else
        {
            flash()->addError(__('Permission denied'));
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        if(auth()->user()->can('Edit Attendance'))
        {
            $attendanceEmployee = AttendanceEmployee::where('id', $id)->first();
            $employees          = Employee::get()->pluck('name', 'id');

            return view('attendance.edit', compact('attendanceEmployee', 'employees'));
        }
        else
        {
            flash()->addError(__('Permission denied'));
            return redirect()->back();
        }
    }

    public function update(Request $request, $id)
    {
        $employeeId      = !empty(auth()->user()->employee) ? auth()->user()->employee->id : 0;
        $todayAttendance = AttendanceEmployee::where('employee_id', '=', $employeeId)->where('date', date('Y-m-d'))->first();
        if(!empty($todayAttendance) && $todayAttendance->clock_out == '00:00:00')
        {
            $startTime = Utility::getValByName('company_start_time');
            $endTime   = Utility::getValByName('company_end_time');
            if(auth()->user()->type == 'employee')
            {

                $date = date("Y-m-d");
                $time = date("H:i:s");

                //early Leaving
                $totalEarlyLeavingSeconds = strtotime($date . $endTime) - time();
                $hours                    = floor($totalEarlyLeavingSeconds / 3600);
                $mins                     = floor($totalEarlyLeavingSeconds / 60 % 60);
                $secs                     = floor($totalEarlyLeavingSeconds % 60);
                $earlyLeaving             = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);

                if(time() > strtotime($date . $endTime))
                {
                    //Overtime
                    $totalOvertimeSeconds = time() - strtotime($date . $endTime);
                    $hours                = floor($totalOvertimeSeconds / 3600);
                    $mins                 = floor($totalOvertimeSeconds / 60 % 60);
                    $secs                 = floor($totalOvertimeSeconds % 60);
                    $overtime             = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
                }
                else
                {
                    $overtime = '00:00:00';
                }

                $attendanceEmployee                = AttendanceEmployee::find($id);
                $attendanceEmployee->clock_out     = $time;
                $attendanceEmployee->early_leaving = $earlyLeaving;
                $attendanceEmployee->overtime      = $overtime;
                $attendanceEmployee->save();

                return redirect()->route('home')->with('success', __('Employee successfully clock Out.'));
            }
            else
            {
                $date = date("Y-m-d");
                //late
                $totalLateSeconds = strtotime($request->clock_in) - strtotime($date . $startTime);

                $hours = floor($totalLateSeconds / 3600);
                $mins  = floor($totalLateSeconds / 60 % 60);
                $secs  = floor($totalLateSeconds % 60);
                $late  = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);

                //early Leaving
                $totalEarlyLeavingSeconds = strtotime($date . $endTime) - strtotime($request->clock_out);
                $hours                    = floor($totalEarlyLeavingSeconds / 3600);
                $mins                     = floor($totalEarlyLeavingSeconds / 60 % 60);
                $secs                     = floor($totalEarlyLeavingSeconds % 60);
                $earlyLeaving             = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);


                if(strtotime($request->clock_out) > strtotime($date . $endTime))
                {
                    //Overtime
                    $totalOvertimeSeconds = strtotime($request->clock_out) - strtotime($date . $endTime);
                    $hours                = floor($totalOvertimeSeconds / 3600);
                    $mins                 = floor($totalOvertimeSeconds / 60 % 60);
                    $secs                 = floor($totalOvertimeSeconds % 60);
                    $overtime             = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
                }
                else
                {
                    $overtime = '00:00:00';
                }

                $attendanceEmployee                = AttendanceEmployee::find($id);
                $attendanceEmployee->employee_id   = $request->employee_id;
                $attendanceEmployee->date          = $request->date;
                $attendanceEmployee->clock_in      = $request->clock_in;
                $attendanceEmployee->clock_out     = $request->clock_out;
                $attendanceEmployee->late          = $late;
                $attendanceEmployee->early_leaving = $earlyLeaving;
                $attendanceEmployee->overtime      = $overtime;
                $attendanceEmployee->total_rest    = '00:00:00';

                $attendanceEmployee->save();

                return redirect()->route('attendanceemployee.index')->with('success', __('Employee attendance successfully updated.'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Employee are not allow multiple time clock in & clock for every day.'));
        }
    }

    public function destroy($id)
    {
        if(auth()->user()->can('Delete Attendance'))
        {
            $attendance = AttendanceEmployee::where('id', $id)->first();

            $attendance->delete();

            return redirect()->route('attendanceemployee.index')->with('success', __('Attendance successfully deleted.'));
        }
        else
        {
            flash()->addError(__('Permission denied'));
            return redirect()->back();
        }
    }

    public function attendance(Request $request)
    {
        $settings = Utility::settings();

        if($settings['ip_restrict'] == 'on')
        {
            $userIp = request()->ip();
            $ip     = IpRestrict::whereIn('ip', [$userIp])->first();
            if(empty($ip))
            {
                return redirect()->back()->with('error', __('this ip is not allowed to clock in & clock out.'));
            }
        }

        $employeeId      = !empty(auth()->user()->employee) ? auth()->user()->employee->id : 0;
        $todayAttendance = AttendanceEmployee::where('employee_id', '=', $employeeId)->where('date', date('Y-m-d'))->first();
        if(empty($todayAttendance))
        {

            $startTime = Utility::getValByName('company_start_time');
            $endTime   = Utility::getValByName('company_end_time');

            $attendance = AttendanceEmployee::orderBy('id', 'desc')->where('employee_id', '=', $employeeId)->where('clock_out', '=', '00:00:00')->first();

            if($attendance != null)
            {
                $attendance            = AttendanceEmployee::find($attendance->id);
                $attendance->clock_out = $endTime;
                $attendance->save();
            }

            $date = date("Y-m-d");
            $time = date("H:i:s");

            //late
            $totalLateSeconds = time() - strtotime($date . $startTime);
            $hours            = floor($totalLateSeconds / 3600);
            $mins             = floor($totalLateSeconds / 60 % 60);
            $secs             = floor($totalLateSeconds % 60);
            $late             = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);

            $checkDb = AttendanceEmployee::where('employee_id', '=', auth()->user()->id)->get()->toArray();


            if(empty($checkDb))
            {
                $employeeAttendance                = new AttendanceEmployee();
                $employeeAttendance->employee_id   = $employeeId;
                $employeeAttendance->date          = $date;
                $employeeAttendance->status        = 'Present';
                $employeeAttendance->clock_in      = $time;
                $employeeAttendance->clock_out     = '00:00:00';
                $employeeAttendance->late          = $late;
                $employeeAttendance->early_leaving = '00:00:00';
                $employeeAttendance->overtime      = '00:00:00';
                $employeeAttendance->total_rest    = '00:00:00';
                $employeeAttendance->created_by    = auth()->user()->id;

                $employeeAttendance->save();

                return redirect()->route('home')->with('success', __('Employee Successfully Clock In.'));
            }
            foreach($checkDb as $check)
            {


                $employeeAttendance                = new AttendanceEmployee();
                $employeeAttendance->employee_id   = $employeeId;
                $employeeAttendance->date          = $date;
                $employeeAttendance->status        = 'Present';
                $employeeAttendance->clock_in      = $time;
                $employeeAttendance->clock_out     = '00:00:00';
                $employeeAttendance->late          = $late;
                $employeeAttendance->early_leaving = '00:00:00';
                $employeeAttendance->overtime      = '00:00:00';
                $employeeAttendance->total_rest    = '00:00:00';
                $employeeAttendance->created_by    = auth()->user()->id;

                $employeeAttendance->save();

                return redirect()->route('home')->with('success', __('Employee Successfully Clock In.'));

            }
        }
        else
        {
            return redirect()->back()->with('error', __('Employee are not allow multiple time clock in & clock for every day.'));
        }
    }

    public function bulkAttendance(Request $request)
    {
        if(auth()->user()->can('Create Attendance'))
        {
            $branch = Branch::get()->pluck('name', 'id');
            $branch->prepend('Select Branch', '');

            $department = Department::get()->pluck('name', 'id');
            $department->prepend('Select Department', '');

            $employees        = [];
            $empBranch        = $request->branch;
            $empDepartment    = $request->department;

            $employees     = Employee::where('created_by', auth()->user()->creatorId())
            ->when($empBranch, function ($query, $empBranch) {
                return $query->where('branch_id',$empBranch);
            })->when($empDepartment, function ($query, $empDepartment) {
                return $query->where('department_id',$empDepartment);
            })->get();

            return view('attendance.bulk', compact('employees', 'branch', 'department'));
        }
        else
        {
            flash()->addError(__('Permission denied'));
            return redirect()->back();
        }
    }

    public function add_note(Request $request ,$id)
    {
        $employee  = $id;
        $startTime = Utility::getValByName('company_start_time');
        $endTime   = Utility::getValByName('company_end_time');

        $in  = date("H:i:s", strtotime($request->in));
        $out = date("H:i:s", strtotime($request->out));

        $totalLateSeconds = strtotime($in) - strtotime($startTime);

        $hours = floor($totalLateSeconds / 3600);
        $mins  = floor($totalLateSeconds / 60 % 60);
        $secs  = floor($totalLateSeconds % 60);
        $late  = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);

        //early Leaving
        $totalEarlyLeavingSeconds = strtotime($endTime) - strtotime($out);
        $hours                    = floor($totalEarlyLeavingSeconds / 3600);
        $mins                     = floor($totalEarlyLeavingSeconds / 60 % 60);
        $secs                     = floor($totalEarlyLeavingSeconds % 60);
        $earlyLeaving             = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);


        if(strtotime($out) > strtotime($endTime))
        {
            //Overtime
            $totalOvertimeSeconds = strtotime($out) - strtotime($endTime);
            $hours                = floor($totalOvertimeSeconds / 3600);
            $mins                 = floor($totalOvertimeSeconds / 60 % 60);
            $secs                 = floor($totalOvertimeSeconds % 60);
            $overtime             = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
        }
        else
        {
            $overtime = '00:00:00';
        }

        $attendance = AttendanceEmployee::where('employee_id', '=', $employee)->where('date', '=', $request->date)->first();

        if(!empty($attendance))
        {
            $employeeAttendance = $attendance;
        }
        else
        {
            $employeeAttendance              = new AttendanceEmployee();
            $employeeAttendance->employee_id = $employee;
            $employeeAttendance->created_by  = auth()->user()->creatorId();
        }

        $employeeAttendance->date          = $request->date;
        $employeeAttendance->status        = 'Present';
        $employeeAttendance->note          = $request->note;
        $employeeAttendance->clock_in      = $in;
        $employeeAttendance->clock_out     = $out;
        $employeeAttendance->late          = $late;
        $employeeAttendance->early_leaving = ($earlyLeaving > 0) ? $earlyLeaving : '00:00:00';
        $employeeAttendance->overtime      = $overtime;
        $employeeAttendance->total_rest    = '00:00:00';
        $employeeAttendance->save();

        return redirect()->back()->with(['success' => __('Note added successfully')]);
    }

    public function bulkAttendanceData(Request $request)
    {
        if(auth()->user()->can('Create Attendance'))
        {
            $startTime = Utility::getValByName('company_start_time');
            $endTime   = Utility::getValByName('company_end_time');
            $date      = $request->date;

            $employees = $request->employee_id;
            $atte      = [];
            foreach($employees as $employee)
            {
                $present = 'present-' . $employee;
                $in      = 'in-' . $employee;
                $out     = 'out-' . $employee;
                $atte[]  = $present;
                if($request->$present == 'on')
                {
                    $in  = date("H:i:s", strtotime($request->$in));
                    $out = date("H:i:s", strtotime($request->$out));

                    $totalLateSeconds = strtotime($in) - strtotime($startTime);

                    $hours = floor($totalLateSeconds / 3600);
                    $mins  = floor($totalLateSeconds / 60 % 60);
                    $secs  = floor($totalLateSeconds % 60);
                    $late  = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);

                    //early Leaving
                    $totalEarlyLeavingSeconds = strtotime($endTime) - strtotime($out);
                    $hours                    = floor($totalEarlyLeavingSeconds / 3600);
                    $mins                     = floor($totalEarlyLeavingSeconds / 60 % 60);
                    $secs                     = floor($totalEarlyLeavingSeconds % 60);
                    $earlyLeaving             = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);


                    if(strtotime($out) > strtotime($endTime))
                    {
                        //Overtime
                        $totalOvertimeSeconds = strtotime($out) - strtotime($endTime);
                        $hours                = floor($totalOvertimeSeconds / 3600);
                        $mins                 = floor($totalOvertimeSeconds / 60 % 60);
                        $secs                 = floor($totalOvertimeSeconds % 60);
                        $overtime             = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
                    }
                    else
                    {
                        $overtime = '00:00:00';
                    }


                    $attendance = AttendanceEmployee::where('employee_id', '=', $employee)->where('date', '=', $request->date)->first();

                    if(!empty($attendance))
                    {
                        $employeeAttendance = $attendance;
                    }
                    else
                    {
                        $employeeAttendance              = new AttendanceEmployee();
                        $employeeAttendance->employee_id = $employee;
                        $employeeAttendance->created_by  = auth()->user()->creatorId();
                    }

                    $employeeAttendance->date          = $request->date;
                    $employeeAttendance->status        = 'Present';
                    $employeeAttendance->clock_in      = $in;
                    $employeeAttendance->clock_out     = $out;
                    $employeeAttendance->late          = $late;
                    $employeeAttendance->early_leaving = ($earlyLeaving > 0) ? $earlyLeaving : '00:00:00';
                    $employeeAttendance->overtime      = $overtime;
                    $employeeAttendance->total_rest    = '00:00:00';
                    $employeeAttendance->save();

                }
                else
                {
                    $attendance = AttendanceEmployee::where('employee_id', '=', $employee)->where('date', '=', $request->date)->first();

                    if(!empty($attendance))
                    {
                        $employeeAttendance = $attendance;
                    }
                    else
                    {
                        $employeeAttendance              = new AttendanceEmployee();
                        $employeeAttendance->employee_id = $employee;
                        $employeeAttendance->created_by  = auth()->user()->creatorId();
                    }

                    $employeeAttendance->status        = 'Leave';
                    $employeeAttendance->date          = $request->date;
                    $employeeAttendance->clock_in      = '00:00:00';
                    $employeeAttendance->clock_out     = '00:00:00';
                    $employeeAttendance->late          = '00:00:00';
                    $employeeAttendance->early_leaving = '00:00:00';
                    $employeeAttendance->overtime      = '00:00:00';
                    $employeeAttendance->total_rest    = '00:00:00';
                    $employeeAttendance->save();
                }
            }
            return redirect()->back()->with('success', __('Employee attendance successfully created.'));
        }
        else
        {
            flash()->addError(__('Permission denied'));
            return redirect()->back();
        }
    }

}

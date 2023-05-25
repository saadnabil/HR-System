<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Leave;
use App\Models\LeaveType;
use App\Mail\LeaveActionSend;
use App\Models\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Imports\EmployeesImport;
use App\Exports\LeaveExport;
use App\Http\Requests\ApproveLeave;
use App\Http\Requests\RejectLeave;
use App\Models\Absence;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class LeaveController extends Controller
{


    public function index()
    {
        if(auth()->user()->can('Manage Leave'))
        {
            $leaves = Leave::get();
            if(auth()->user()->type == 'employee')
            {
                $user     = auth()->user();
                $employee = Employee::where('user_id', '=', $user->id)->first();
                $leaves   = Leave::where('employee_id', '=', $employee->id)->get();
            }
            else
            {
                $leaves = Leave::get();
            }

            return view('leave.index', compact('leaves'));
        }
        else
        {
            flash()->addError(__('Permission denied'));
            return redirect()->back();
        }
    }

    public function create(Request $request)
    {
        if(auth()->user()->can('Create Leave'))
        {
            $employeeId = $request->employee_id;
            if(auth()->user()->type == 'employee')
            {
                $employees  = Employee::where('user_id', '=', auth()->user()->id)->get()->pluck('name', 'id');
            }
            else
            {
                $employees = Employee::get()->pluck('name', 'id');
            }
            $leavetypes      = LeaveType::get();
            $leavetypes_days = LeaveType::get();

           // dd(Employee::employeeTotalLeave(1));
            return view('leave.create', compact('employees', 'leavetypes', 'leavetypes_days','employeeId'));
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function store(Request $request)
    {

        if(auth()->user()->can('Create Leave'))
        {
            $validator = \Validator::make(
                $request->all(), [
                                   'leave_type_id' => 'required',
                                   'start_date' => 'required',
                                   'end_date' => 'required',
                                   'ticket' => 'required',
                                   'leave_reason' => 'required',
                                   'remark' => 'required',
                                   'leave_reason_ar' => 'required',
                                   'remark_ar' => 'required',
                               ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }


            $employee = Employee::where('user_id', '=', auth()->user()->id)->first();
            $leave    = new Leave();
            if(auth()->user()->type == "employee")
            {
                $leave->employee_id = $employee->id;
            }
            else
            {
                $leave->employee_id = $request->employee_id;
            }
            $leave->leave_type_id    = $request->leave_type_id;
            $leave->applied_on       = date('Y-m-d');
            $leave->start_date       = $request->start_date;
            $leave->end_date         = $request->end_date;
            $leave->ticket           = $request->ticket;
            $leave->total_leave_days = 0;
            $leave->leave_reason     = $request->leave_reason;
            $leave->remark           = $request->remark;
            $leave->leave_reason_ar  = $request->leave_reason_ar;
            $leave->remark_ar        = $request->remark_ar;
            $leave->status           = 'Pending';
            $leave->created_by       = auth()->user()->creatorId();
            $leave->save();
            return redirect()->back()->with('success', __('Leave  successfully created.'));
        }
        else
        {
            flash()->addError(__('Permission denied'));
            return redirect()->back();
        }
    }

    public function show(Leave $leave)
    {
        return redirect()->route('leave.index');
    }

    public function edit(Leave $leave)
    {
        if(auth()->user()->can('Edit Leave'))
        {
            if($leave->created_by == auth()->user()->creatorId())
            {
                $employees  = Employee::get()->pluck('name', 'id');
                $leavetypes = LeaveType::get()->pluck('title', 'id');

                return view('leave.edit', compact('leave', 'employees', 'leavetypes'));
            }
            else
            {
                return response()->json(['error' => __('Permission denied.')], 401);
            }
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function update(Request $request, $leave)
    {

        $leave = Leave::find($leave);
        if(auth()->user()->can('Edit Leave'))
        {
            if($leave->created_by == auth()->user()->creatorId())
            {
                $validator = \Validator::make(
                    $request->all(), [
                        'leave_type_id' => 'required',
                        'start_date' => 'required',
                        'end_date' => 'required',
                        'ticket' => 'required',
                        'leave_reason' => 'required',
                        'remark' => 'required',
                        'leave_reason_ar' => 'required',
                        'remark_ar' => 'required',
                    ]
                );
                if($validator->fails())
                {
                    $messages = $validator->getMessageBag();
                    return redirect()->back()->with('error', $messages->first());
                }

                $leave->employee_id      = $request->employee_id;
                $leave->leave_type_id    = $request->leave_type_id;
                $leave->start_date       = $request->start_date;
                $leave->end_date         = $request->end_date;
                $leave->ticket           = $request->ticket;
                $leave->total_leave_days = 0;
                $leave->leave_reason     = $request->leave_reason;
                $leave->remark           = $request->remark;
                $leave->leave_reason_ar  = $request->leave_reason_ar;
                $leave->remark_ar        = $request->remark_ar;

                $leave->save();

                return redirect()->back()->with('success', __('Leave successfully updated.'));
            }
            else
            {
                flash()->addError(__('Permission denied'));
            return redirect()->back();
            }
        }
        else
        {
            flash()->addError(__('Permission denied'));
            return redirect()->back();
        }
    }

    public function destroy(Leave $leave)
    {
        if(auth()->user()->can('Delete Leave'))
        {
            if($leave->created_by == auth()->user()->creatorId())
            {
                $leave->delete();

                return redirect()->back()->with('success', __('Leave successfully deleted.'));
            }
            else
            {
                flash()->addError(__('Permission denied'));
            return redirect()->back();
            }
        }
        else
        {
            flash()->addError(__('Permission denied'));
            return redirect()->back();
        }
    }

    public function export()
    {
        $name = 'leave_' . date('Y-m-d i:h:s');
        $data = Excel::download(new LeaveExport(), $name . '.xlsx'); if(ob_get_contents()) ob_end_clean();

        return $data;
    }

    public function action($id)
    {
        $leave     = Leave::find($id);
        $employee  = Employee::find($leave->employee_id);
        $leavetype = LeaveType::find($leave->leave_type_id);
        return view('leave.action', compact('employee', 'leavetype', 'leave'));
    }

    public function changeaction(Request $request)
    {

        $leave = Leave::find($request->leave_id);

        $leave->status = $request->status;
        if($leave->status == 'Approval')
        {
            $startDate               = new \DateTime($leave->start_date);
            $endDate                 = new \DateTime($leave->end_date);
            $total_leave_days        = $startDate->diff($endDate)->days;
            $leave->total_leave_days = $total_leave_days;
            $leave->status           = 'Approve';
        }

        $leave->save();

         // twilio
         $setting = Utility::settings(auth()->user()->creatorId());
         $emp = Employee::find($leave->employee_id);
         if (isset($setting['twilio_leave_approve_notification']) && $setting['twilio_leave_approve_notification'] == 1) {
           $msg = __("Your leave has been").' '.$leave->status.'.';


             Utility::send_twilio_msg($emp->phone,$msg);
         }

        $setings = Utility::settings();
        if($setings['leave_status'] == 1)
        {
            $employee     = Employee::where('id', $leave->employee_id)->first();
            $leave->name  = !empty($employee->name) ? $employee->name : '';
            $leave->email = !empty($employee->email) ? $employee->email : '';
            try
            {
                Mail::to($leave->email)->send(new LeaveActionSend($leave));
            }
            catch(\Exception $e)
            {
                $smtp_error = __('E-Mail has been not sent due to SMTP configuration');
            }

            return redirect()->route('leave.index')->with('success', __('Leave status successfully updated.') . (isset($smtp_error) ? $smtp_error : ''));

        }

        return redirect()->route('leave.index')->with('success', __('Leave status successfully updated.'));
    }

    public function jsoncount(Request $request)
    {
        //        $leave_counts = LeaveType::select(\DB::raw('COALESCE(SUM(leaves.total_leave_days),0) AS total_leave, leave_types.title, leave_types.days,leave_types.id'))->leftjoin(
        //            'leaves', function ($join) use ($request){
        //            $join->on('leaves.leave_type_id', '=', 'leave_types.id');
        //            $join->where('leaves.employee_id', '=', $request->employee_id);
        //        }
        //        )->groupBy('leaves.leave_type_id')->get();

        $leave_counts = LeaveType::select(\DB::raw('COALESCE(SUM(leaves.total_leave_days),0) AS total_leave, leave_types.title, leave_types.days,leave_types.id'))
                                 ->leftjoin('leaves', function ($join) use ($request){
            $join->on('leaves.leave_type_id', '=', 'leave_types.id');
            $join->where('leaves.employee_id', '=', $request->employee_id);
        }
        )->groupBy('leaves.leave_type_id')->get();

        return $leave_counts;

    }
}

<?php

namespace App\Http\Controllers;

use App\Exports\TimesheetExport;
use App\Imports\TimesheetImport;
use App\Models\Employee;
use App\Models\TimeSheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class TimeSheetController extends Controller
{
    public function index(Request $request)
    {
        if(auth()->user()->can('Manage TimeSheet'))
        {
            $employeesList = [];
            if(auth()->user()->type == 'employee')
            {
                $timeSheets = TimeSheet::where('employee_id', auth()->user()->id)->get();
            }
            else
            {
                $employeesList = Employee::get()->pluck('name', 'user_id');
                $employeesList->prepend('All', '');

                $timesheets = TimeSheet::where('created_by', auth()->user()->creatorId());

                if(!empty($request->start_date) && !empty($request->end_date))
                {
                    $timesheets->where('date', '>=', $request->start_date);
                    $timesheets->where('date', '<=', $request->end_date);
                }

                if(!empty($request->employee))
                {
                    $timesheets->where('employee_id', $request->employee);
                }
                $timeSheets = $timesheets->get();
            }

            return view('timeSheet.index', compact('timeSheets', 'employeesList'));
        }
        else
        {
            return redirect()->back()->with('error', 'Permission denied.');
        }
    }

    public function create()
    {

        if(auth()->user()->can('Create TimeSheet'))
        {
            $employees = Employee::get()->pluck('name', 'user_id');

            return view('timeSheet.create', compact('employees'));
        }
        else
        {
            return redirect()->back()->with('error', 'Permission denied.');
        }
    }

    public function store(Request $request)
    {
        if(auth()->user()->can('Create TimeSheet'))
        {
            $timeSheet = new Timesheet();
            if(auth()->user()->type == 'employee')
            {
                $timeSheet->employee_id = auth()->user()->id;
            }
            else
            {
                $timeSheet->employee_id = $request->employee_id;
            }

            $timeSheetCheck = TimeSheet::where('date', $request->date)->where('employee_id', $timeSheet->employee_id)->first();

            if(!empty($timeSheetCheck))
            {
                return redirect()->back()->with('error', __('Timesheet already created in this day.'));
            }

            $timeSheet->date       = $request->date;
            $timeSheet->hours      = $request->hours;
            $timeSheet->remark     = $request->remark;
            $timeSheet->remark_ar     = $request->remark_ar;
            $timeSheet->created_by = auth()->user()->creatorId();
            $timeSheet->save();

            return redirect()->route('timesheet.index')->with('success', __('Timesheet successfully created.'));
        }
        else
        {
            return redirect()->back()->with('error', 'Permission denied.');
        }

    }

    public function show(TimeSheet $timeSheet)
    {
        //
    }

    public function edit(TimeSheet $timeSheet, $id)
    {

        if(auth()->user()->can('Edit TimeSheet'))
        {
            $employees = Employee::get()->pluck('name', 'user_id');
            $timeSheet = Timesheet::find($id);

            return view('timeSheet.edit', compact('timeSheet', 'employees'));
        }
        else
        {
            return redirect()->back()->with('error', 'Permission denied.');
        }
    }

    public function update(Request $request, $id)
    {
        if(auth()->user()->can('Edit TimeSheet'))
        {

            $timeSheet = Timesheet::find($id);
            if(auth()->user()->type == 'employee')
            {
                $timeSheet->employee_id = auth()->user()->id;
            }
            else
            {
                $timeSheet->employee_id = $request->employee_id;
            }

            $timeSheetCheck = TimeSheet::where('date', $request->date)->where('employee_id', $timeSheet->employee_id)->first();

            if(!empty($timeSheetCheck) && $timeSheetCheck->id != $id)
            {
                return redirect()->back()->with('error', __('Timesheet already created in this day.'));
            }

            $timeSheet->date   = $request->date;
            $timeSheet->hours  = $request->hours;
            $timeSheet->remark = $request->remark;
            $timeSheet->remark_ar     = $request->remark_ar;
            $timeSheet->save();

            return redirect()->route('timesheet.index')->with('success', __('TimeSheet successfully updated.'));
        }
        else
        {
            return redirect()->back()->with('error', 'Permission denied.');
        }
    }

    public function destroy($id)
    {
        if(auth()->user()->can('Delete TimeSheet'))
        {
            $timeSheet = Timesheet::find($id);
            $timeSheet->delete();

            return redirect()->route('timesheet.index')->with('success', __('TimeSheet successfully deleted.'));
        }
        else
        {
            return redirect()->back()->with('error', 'Permission denied.');
        }
    }

    public function export(Request $request)
    {
        $name = 'Timesheet_' . date('Y-m-d i:h:s');
        $data = Excel::download(new TimesheetExport(), $name . '.xlsx'); if(ob_get_contents()) ob_end_clean();

        return $data;
    }

    public function importFile(Request $request)
    {
        return view('timeSheet.import');
    }

    public function import(Request $request)
    {
        $rules = [
            'file' => 'required|mimes:csv,xlsx,txt',
        ];

        $validator = \Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        }

        $timesheet = (new TimesheetImport())->toArray(request()->file('file'))[0];

        $totalTimesheet = count($timesheet) - 1;
        $errorArray    = [];

        for($i = 1; $i <= $totalTimesheet; $i++) {
            $timesheets = $timesheet[$i];
            //dd($timesheet[$i]);
            $timesheetData=TimeSheet::where('employee_id',$timesheets[1])->where('date',$timesheets[0])->first();

            if(!empty($timesheetData))
            {
                $errorArray[]=$timesheetData;
            }
            else
            {
                $time_sheet=new TimeSheet();
                $time_sheet->employee_id=$timesheets[1];
                $time_sheet->date=$timesheets[0];
                $time_sheet->hours=$timesheets[2];
                $time_sheet->remark=$timesheets[3];
                $time_sheet->created_by=auth()->user()->id;
                $time_sheet->save();
            }
        }


        if (empty($errorArray)) {
            $data['status'] = 'success';
            $data['msg']    = __('Record successfully imported');
        } else {

            $data['status'] = 'error';
            $data['msg']    = count($errorArray) . ' ' . __('Record imported fail out of' . ' ' . $totalTimesheet . ' ' . 'record');


            foreach ($errorArray as $errorData) {
                $errorRecord[] = implode(',', $errorData->toArray());
            }

            \Session::put('errorArray', $errorRecord);
        }

        return redirect()->back()->with($data['status'], $data['msg']);
    }
}

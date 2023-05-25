<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\Employee;
use App\Mail\ComplaintsSend;
use App\Models\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ComplaintController extends Controller
{
    public function index()
    {
        if(auth()->user()->can('Manage Complaint'))
        {
            if(auth()->user()->type == 'employee')
            {
                $emp        = Employee::where('user_id', '=', auth()->user()->id)->first();
                $complaints = Complaint::where('complaint_from', '=', $emp->id)->get();
            }
            else
            {
                $complaints = Complaint::get();
            }

            return view('complaint.index', compact('complaints'));
        }
        else
        {
            flash()->addError(__('Permission denied'));
            return redirect()->back();
        }
    }

    public function create()
    {
        if(auth()->user()->can('Create Complaint'))
        {
            if(auth()->user()->type == 'employee')
            {
                $user             = auth()->user();
                $current_employee = Employee::where('user_id', $user->id)->get()->pluck('name', 'id');
                $employees        = Employee::where('user_id', '!=', $user->id)->get()->pluck('name', 'id');

            }
            else
            {
                $user             = auth()->user();
                $current_employee = Employee::where('user_id', $user->id)->get()->pluck('name', 'id');
                $employees = Employee::get()->pluck('name', 'id');
            }


            return view('complaint.create', compact('employees', 'current_employee'));
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function store(Request $request)
    {
        if(auth()->user()->can('Create Complaint'))
        {
            if(auth()->user()->type != 'employee')
            {
                $validator = \Validator::make(
                    $request->all(), [
                                       'complaint_from' => 'required',
                                   ]
                );
            }

            $validator = \Validator::make(
                $request->all(), [
                                   'complaint_against' => 'required',
                                   'title' => 'required',
                                   'title_ar' => 'required',
                                   'complaint_date' => 'required',
                               ]
            );

            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }
            $complaint = new Complaint();
            if(auth()->user()->type == 'employee')
            {
                $emp                       = Employee::where('user_id', '=', auth()->user()->id)->first();
                $complaint->complaint_from = $emp->id;
            }
            else
            {
                $complaint->complaint_from = $request->complaint_from;
            }
            $complaint->complaint_against = $request->complaint_against;
            $complaint->title             = $request->title;
            $complaint->title_ar          = $request->title_ar;
            $complaint->complaint_date    = $request->complaint_date;
            $complaint->description       = $request->description;
            $complaint->description_ar    = $request->description_ar;
            $complaint->created_by        = auth()->user()->creatorId();
            $complaint->save();

            $setings = Utility::settings();
            if($setings['employee_complaints'] == 1)
            {
                $employee         = Employee::find($complaint->complaint_against);
                $complaint->name  = $employee->name;
                $complaint->email = $employee->email;

                try
                {
                    Mail::to($complaint->email)->send(new ComplaintsSend($complaint));
                }
                catch(\Exception $e)
                {
                    $smtp_error = __('E-Mail has been not sent due to SMTP configuration');
                }

                return redirect()->route('complaint.index')->with('success', __('Complaint  successfully created.') .(isset($smtp_error) ? $smtp_error : ''));
            }

            return redirect()->route('complaint.index')->with('success', __('Complaint  successfully created.'));
        }
        else
        {
            flash()->addError(__('Permission denied'));
            return redirect()->back();
        }
    }

    public function show(Complaint $complaint)
    {
        return redirect()->route('complaint.index');
    }

    public function edit($complaint)
    {
        $complaint = Complaint::find($complaint);
        if(auth()->user()->can('Edit Complaint'))
        {
            if(auth()->user()->type == 'employee')
            {
                $user             = auth()->user();
                $current_employee = Employee::where('user_id', $user->id)->get()->pluck('name', 'id');
                $employees        = Employee::where('user_id', '!=', $user->id)->get()->pluck('name', 'id');
            }
            else
            {
                $user             = auth()->user();
                $current_employee = Employee::where('user_id', $user->id)->get()->pluck('name', 'id');
                $employees = Employee::get()->pluck('name', 'id');
            }
            if($complaint->created_by == auth()->user()->creatorId())
            {
                return view('complaint.edit', compact('complaint', 'employees', 'current_employee'));
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

    public function update(Request $request, Complaint $complaint)
    {
        if(auth()->user()->can('Edit Complaint'))
        {
            if($complaint->created_by == auth()->user()->creatorId())
            {
                if(auth()->user()->type != 'employee')
                {
                    $validator = \Validator::make(
                        $request->all(), [
                                           'complaint_from' => 'required',
                                       ]
                    );
                }

                $validator = \Validator::make(
                    $request->all(), [

                                       'complaint_against' => 'required',
                                       'title' => 'required',
                                       'title_ar' => 'required',
                                       'complaint_date' => 'required',
                                   ]
                );

                if($validator->fails())
                {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }

                if(auth()->user()->type == 'employee')
                {
                    $emp                       = Employee::where('user_id', '=', auth()->user()->id)->first();
                    $complaint->complaint_from = $emp->id;
                }
                else
                {
                    $complaint->complaint_from = $request->complaint_from;
                }
                $complaint->complaint_against = $request->complaint_against;
                $complaint->title             = $request->title;
                $complaint->title_ar          = $request->title_ar;
                $complaint->complaint_date    = $request->complaint_date;
                $complaint->description       = $request->description;
                $complaint->description_ar    = $request->description_ar;
                $complaint->save();

                return redirect()->route('complaint.index')->with('success', __('Complaint successfully updated.'));
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

    public function destroy(Complaint $complaint)
    {
        if(auth()->user()->can('Delete Complaint'))
        {
            if($complaint->created_by == auth()->user()->creatorId())
            {
                $complaint->delete();

                return redirect()->route('complaint.index')->with('success', __('Complaint successfully deleted.'));
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
}

<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Mail\TerminationSend;
use App\Models\Termination;
use App\Models\TerminationType;
use App\Models\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class TerminationController extends Controller
{
    public function index()
    {
        if(auth()->user()->can('Manage Termination'))
        {
            if(auth()->user()->type == 'employee')
            {
                $emp          = Employee::where('user_id', '=', auth()->user()->id)->first();
                $terminations = Termination::where('employee_id', '=', $emp->id)->get();
            }
            else
            {
                $terminations = Termination::get();
            }
            return view('termination.index', compact('terminations'));
        }
        else
        {
            flash()->addError(__('Permission denied'));
            return redirect()->back();
        }
    }

    public function create()
    {
        if(auth()->user()->can('Create Termination'))
        {
            $employees        = Employee::get()->pluck('name', 'id');
            $terminationtypes = TerminationType::get()->pluck('name', 'id');

            return view('termination.create', compact('employees', 'terminationtypes'));
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function store(Request $request)
    {
        if(auth()->user()->can('Create Termination'))
        {

            $validator = \Validator::make(
                $request->all(), [
                                   'employee_id' => 'required',
                                   'termination_type' => 'required',
                                   'notice_date' => 'required',
                                   'termination_date' => 'required',
                               ]
            );

            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $termination                   = new Termination();
            $termination->employee_id      = $request->employee_id;
            $termination->termination_type = $request->termination_type;
            $termination->notice_date      = $request->notice_date;
            $termination->termination_date = $request->termination_date;
            $termination->description      = $request->description;
            $termination->description_ar      = $request->description_ar;
            $termination->created_by       = auth()->user()->creatorId();
            $termination->save();

            $setings = Utility::settings();
            if($setings['employee_termination'] == 1)
            {
                $employee           = Employee::find($termination->employee_id);
                $termination->name  = $employee->name;
                $termination->email = $employee->email;
                $termination->type  = TerminationType::find($termination->termination_type);

                try
                {
                    Mail::to($termination->email)->send(new TerminationSend($termination));
                }
                catch(\Exception $e)
                {
                    $smtp_error = __('E-Mail has been not sent due to SMTP configuration');
                }

                return redirect()->route('termination.index')->with('success', __('Termination  successfully created.') . (isset($smtp_error) ? $smtp_error : ''));

            }

            return redirect()->route('termination.index')->with('success', __('Termination  successfully created.'));
        }
        else
        {
            flash()->addError(__('Permission denied'));
            return redirect()->back();
        }
    }

    public function show(Termination $termination)
    {
        return redirect()->route('termination.index');
    }

    public function edit(Termination $termination)
    {
        if(auth()->user()->can('Edit Termination'))
        {
            $employees        = Employee::get()->pluck('name', 'id');
            $terminationtypes = TerminationType::get()->pluck('name', 'id');
            if($termination->created_by == auth()->user()->creatorId())
            {

                return view('termination.edit', compact('termination', 'employees', 'terminationtypes'));
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

    public function update(Request $request, Termination $termination)
    {
        if(auth()->user()->can('Edit Termination'))
        {
            if($termination->created_by == auth()->user()->creatorId())
            {
                $validator = \Validator::make(
                    $request->all(), [
                                       'employee_id' => 'required',
                                       'termination_type' => 'required',
                                       'notice_date' => 'required',
                                       'termination_date' => 'required',
                                   ]
                );

                if($validator->fails())
                {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }


                $termination->employee_id      = $request->employee_id;
                $termination->termination_type = $request->termination_type;
                $termination->notice_date      = $request->notice_date;
                $termination->termination_date = $request->termination_date;
                $termination->description      = $request->description;
                $termination->description_ar      = $request->description_ar;
                $termination->save();

                return redirect()->route('termination.index')->with('success', __('Termination successfully updated.'));
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

    public function destroy(Termination $termination)
    {
        if(auth()->user()->can('Delete Termination'))
        {
            if($termination->created_by == auth()->user()->creatorId())
            {
                $termination->delete();

                return redirect()->route('termination.index')->with('success', __('Termination successfully deleted.'));
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

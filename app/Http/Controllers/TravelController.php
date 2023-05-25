<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Mail\TripSend;
use App\Models\Travel;
use App\Models\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;


class TravelController extends Controller
{
    public function index()
    {
        if (auth()->user()->can('Manage Travel')) {
            if (auth()->user()->type == 'employee') {
                $emp     = Employee::where('user_id', '=', auth()->user()->id)->first();
                $travels = Travel::where('employee_id', '=', $emp->id)->get();
            } else {
                $travels = Travel::get();
            }

            return view('travel.index', compact('travels'));
        } else {
            flash()->addError(__('Permission denied'));
            return redirect()->back();
        }
    }

    public function create()
    {
        if (auth()->user()->can('Create Travel')) {
            $employees = Employee::get()->pluck('name', 'id');

            return view('travel.create', compact('employees'));
        } else {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function store(Request $request)
    {
        if (auth()->user()->can('Create Travel')) {
            $validator = \Validator::make(
                $request->all(),
                [
                    'employee_id' => 'required',
                    'start_date' => 'required',
                    'end_date' => 'required',
                    'purpose_of_visit' => 'required',
                    'place_of_visit' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }
            $travel                   = new Travel();
            $travel->employee_id      = $request->employee_id;
            $travel->start_date       = $request->start_date;
            $travel->end_date         = $request->end_date;
            $travel->purpose_of_visit = $request->purpose_of_visit;
            $travel->place_of_visit   = $request->place_of_visit;
            $travel->description      = $request->description;
            $travel->purpose_of_visit_ar = $request->purpose_of_visit_ar;
            $travel->place_of_visit_ar   = $request->place_of_visit_ar;
            $travel->description_ar      = $request->description_ar;
            $travel->created_by       = auth()->user()->creatorId();
            $travel->save();


            // twilio
            $setting = Utility::settings(auth()->user()->creatorId());
            $emp = Employee::find($request->employee_id);
            if (isset($setting['twilio_trip_notification']) && $setting['twilio_trip_notification'] == 1) {
                $msg = $request->purpose_of_visit . ' ' . __("is created to visit") . ' ' . $request->place_of_visit . ' ' . __("for") . ' ' . $emp->name . ' ' . __("from") . ' ' . $request->start_date . ' ' . __("to") . ' ' . $request->end_date . '.';
                Utility::send_twilio_msg($emp->phone, $msg);
            }

            $setings = Utility::settings();
            if ($setings['employee_trip'] == 1) {
                $employee      = Employee::find($travel->employee_id);
                $travel->name  = $employee->name;
                $travel->email = $employee->email;

                try {
                    Mail::to($travel->email)->send(new TripSend($travel));
                } catch (\Exception $e) {
                    $smtp_error = __('E-Mail has been not sent due to SMTP configuration');
                }

                return redirect()->route('travel.index')->with('success', __('Travel  successfully created.') . (isset($smtp_error) ? $smtp_error : ''));
            }

            return redirect()->route('travel.index')->with('success', __('Travel  successfully created.'));
        } else {
            flash()->addError(__('Permission denied'));
            return redirect()->back();
        }
    }

    public function show(Travel $travel)
    {
        return redirect()->route('travel.index');
    }

    public function edit(Travel $travel)
    {

        if (auth()->user()->can('Edit Travel')) {
            $employees = Employee::get()->pluck('name', 'id');
            if ($travel->created_by == auth()->user()->creatorId()) {
                return view('travel.edit', compact('travel', 'employees'));
            } else {
                return response()->json(['error' => __('Permission denied.')], 401);
            }
        } else {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function update(Request $request, Travel $travel)
    {
        if (auth()->user()->can('Edit Travel')) {
            if ($travel->created_by == auth()->user()->creatorId()) {

                $validator = \Validator::make(
                    $request->all(),
                    [
                        'employee_id' => 'required',
                        'start_date' => 'required',
                        'end_date' => 'required',
                        'purpose_of_visit' => 'required',
                        'place_of_visit' => 'required',
                    ]
                );
                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }

                $travel->employee_id      = $request->employee_id;
                $travel->start_date       = $request->start_date;
                $travel->end_date         = $request->end_date;
                $travel->purpose_of_visit = $request->purpose_of_visit;
                $travel->place_of_visit   = $request->place_of_visit;
                $travel->description      = $request->description;
                $travel->purpose_of_visit_ar = $request->purpose_of_visit_ar;
                $travel->place_of_visit_ar   = $request->place_of_visit_ar;
                $travel->description_ar      = $request->description_ar;
                $travel->save();

                return redirect()->route('travel.index')->with('success', __('Travel successfully updated.'));
            } else {
                flash()->addError(__('Permission denied'));
            return redirect()->back();
            }
        } else {
            flash()->addError(__('Permission denied'));
            return redirect()->back();
        }
    }

    public function destroy(Travel $travel)
    {
        if (auth()->user()->can('Delete Travel')) {
            if ($travel->created_by == auth()->user()->creatorId()) {
                $travel->delete();

                return redirect()->route('travel.index')->with('success', __('Travel successfully deleted.'));
            } else {
                flash()->addError(__('Permission denied'));
            return redirect()->back();
            }
        } else {
            flash()->addError(__('Permission denied'));
            return redirect()->back();
        }
    }
}

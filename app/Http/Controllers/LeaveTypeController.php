<?php

namespace App\Http\Controllers;

use App\Models\LeaveType;
use Illuminate\Http\Request;

class LeaveTypeController extends Controller
{
    public function index()
    {
        if(auth()->user()->can('Manage Leave Type'))
        {
            $leavetypes = LeaveType::get();

            return view('leavetype.index', compact('leavetypes'));
        }
        else
        {
            flash()->addError(__('Permission denied'));
            return redirect()->back();
        }
    }

    public function create()
    {

        if(auth()->user()->can('Create Leave Type'))
        {
            return view('leavetype.create');
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function store(Request $request)
    {
        $parent=LeaveType::where(['parent'=>null,'type'=>'leave'])->firstorfail();
        $data = $request->validateWithBag('store',[
            'title'=>['required','string'],
            'title_ar'=>['required','string'],
            'maxDays'=>['required','numeric','min:0'],
            'maxDaysPerMonth'=>['required','string','numeric','min:0'],
            'afterMaxHour'=>['required','string','numeric','min:0'],
            'daysBeforeApply'=>['required','string','numeric','min:0'],
            'deduction'=>['required','string','numeric','min:0'],
        ]);
        $data['created_by'] = auth()->user()->creatorId();
        $data['parent'] = $parent->id;
        LeaveType::create($data);
        flash()->addSuccess(__('Added successfully'));
        return response()->json();
    }

    public function update(Request $request, LeaveType $leavetype)
    {
        $data = $request->validate([
            'title'=>['required','string'],
            'title_ar'=>['required','string'],
            'maxDays'=>['required','numeric','min:0'],
            'maxDaysPerMonth'=>['required','string','numeric','min:0'],
            'afterMaxHour'=>['required','string','numeric','min:0'],
            'daysBeforeApply'=>['required','string','numeric','min:0'],
            'deduction'=>['required','string','numeric','min:0'],
        ]);
        $leavetype->update($data);
        flash()->addSuccess(__('Updated successfully'));
        return response()->json();

    }

    public function destroy(LeaveType $leavetype)
    {
        $leavetype->delete();
        flash()->addSuccess(__('Deleted successfully'));
        return redirect()->back();
    }
}

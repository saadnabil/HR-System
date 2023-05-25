<?php

namespace App\Http\Controllers;

use App\Models\AllowanceOption;
use Illuminate\Http\Request;

class AllowanceOptionController extends Controller
{
    public function index()
    {

        $allowanceoptions = AllowanceOption::query();

        if (request()->ajax()){
            $allowanceoptions->where(function ($query) {
                $query->where('name', 'like', '%' . request('search') . '%')
                    ->orWhere('name_ar', 'like', '%' . request('search') . '%');
            });
            $search = view('new-theme.settings.salary.paginations.allowanceoption_pagination', [
                'allowanceoptions' => $allowanceoptions->get(),
            ]);
            return response()->json(['search' => $search->render()]);
        }

        $allowanceoptions = $allowanceoptions->get();

        return view('new-theme.settings.salary.allowanceoptions', compact('allowanceoptions'));

    }

    public function create()
    {
        if(auth()->user()->can('Create Allowance Option'))
        {
            $allowanceoptionCountWithPayrollDisplay = AllowanceOption::WhereNotNull('payroll_dispaly')->count();
            return view('allowanceoption.create',compact('allowanceoptionCountWithPayrollDisplay'));
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function store(Request $request)
    {

            $validator = \Validator::make(
                $request->all(), [
                                   'name' => 'required|max:200',
                                   'name_ar' => 'required|max:200',
                               ]);

            if($validator->fails())
            {
                $messages = $validator->getMessageBag();
                $key = array_keys($messages->getMessages())[0] ?? "";
                return redirect()->back()->with('error',$key ." ". $messages->first());
            }

            $allowanceoptionCountWithPayrollDisplay = AllowanceOption::WhereNotNull('payroll_dispaly')->count();
            if($request->payroll_dispaly == 1 && $allowanceoptionCountWithPayrollDisplay >= 2)
            {
                return redirect()->back()->with('error', __('It is not possible to add more than 2 in Payroll Log'));
            }

            $allowanceoption                    = new AllowanceOption();
            $allowanceoption->name              = $request->name;
            $allowanceoption->name_ar           = $request->name_ar;
            $allowanceoption->insurance_active  = $request->insurance_active ?? 0;
            $allowanceoption->payroll_dispaly   = $request->payroll_dispaly;
            $allowanceoption->created_by        = auth()->user()->creatorId();
            $allowanceoption->save();

            return redirect()->route('allowanceoption.index')->with('success', __('AllowanceOption  successfully created.'));

    }

    public function show(AllowanceOption $allowanceoption)
    {
        return redirect()->route('allowanceoption.index');
    }

    public function edit(AllowanceOption $allowanceoption)
    {
        if(auth()->user()->can('Edit Allowance Option'))
        {

                return view('allowanceoption.edit', compact('allowanceoption'));

        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function update(Request $request, AllowanceOption $allowanceoption)
    {

            $validator = \Validator::make(
                $request->all(), [
                           'name' => 'required|max:200',
                           'name_ar' => 'required|max:200',
                       ]
            );

            if($validator->fails())
            {
                $messages = $validator->getMessageBag();
                $key = array_keys($messages->getMessages())[0] ?? "";
                return redirect()->back()->with('error',$key ." ". $messages->first());
            }

            $allowanceoptionCountWithPayrollDisplay = AllowanceOption::WhereNotNull('payroll_dispaly')->count();
            if($request->payroll_dispaly == 1 && $allowanceoptionCountWithPayrollDisplay >= 2)
            {
                return redirect()->back()->with('error', __('It is not possible to add more than 2 in Payroll Log'));
            }


            $allowanceoption->name = $request->name;
            $allowanceoption->name_ar = $request->name_ar;
            $allowanceoption->insurance_active       = $request->insurance_active ?? 0;
            $allowanceoption->payroll_dispaly   = $request->payroll_dispaly;
            $allowanceoption->save();

            return redirect()->route('allowanceoption.index')->with('success', __('AllowanceOption successfully updated.'));
    }

    public function destroy(AllowanceOption $allowanceoption)
    {

        flash()->addError(__('Permission denied'));
        return redirect()->back();
    }

}

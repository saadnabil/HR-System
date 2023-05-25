<?php

namespace App\Http\Controllers;

use App\Models\DeductionOption;
use Illuminate\Http\Request;

class DeductionOptionController extends Controller
{
    public function index()
    {
        $deductionoptions = DeductionOption::query();

        if (request()->ajax()) {
            $deductionoptions->where(function ($query) {
                $query->where('name', 'like', '%' . request('search') . '%')
                    ->orWhere('name_ar', 'like', '%' . request('search') . '%');
            });
            $search = view('new-theme.settings.salary.paginations.deductionoption_pagination', [
                'deductionoptions' => $deductionoptions->get(),
            ]);
            return response()->json(['search' => $search->render()]);
        }


        $deductionoptions = $deductionoptions->get();

        return view('new-theme.settings.salary.deductionoptions', compact('deductionoptions'));


    }

    public function create()
    {
        if (auth()->user()->can('Create Deduction Option')) {
            return view('deductionoption.create');
        } else {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function store(Request $request)
    {

        $validator = \Validator::make(
            $request->all(), [
                'name' => 'required',
                'name_ar' => 'required',
            ]
        );
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            $key = array_keys($messages->getMessages())[0] ?? "";
            return redirect()->back()->with('error', $key . " " . $messages->first());
        }

        $deductionoption = new DeductionOption();
        $deductionoption->name = $request->name;
        $deductionoption->name_ar = $request->name_ar;
        $deductionoption->created_by = auth()->user()->creatorId();
        $deductionoption->save();

        return redirect()->route('deductionoption.index')->with('success', __('DeductionOption  successfully created.'));

    }

    public function show(DeductionOption $deductionoption)
    {
        return redirect()->route('deductionoption.index');
    }

    public function edit($deductionoption)
    {
        $deductionoption = DeductionOption::find($deductionoption);
        if (auth()->user()->can('Edit Deduction Option')) {

                return view('deductionoption.edit', compact('deductionoption'));

        } else {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function update(Request $request, DeductionOption $deductionoption)
    {

        $validator = \Validator::make(
            $request->all(), [
                'name' => 'required',
                'name_ar' => 'required',
            ]
        );

        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            $key = array_keys($messages->getMessages())[0] ?? "";
            return redirect()->back()->with('error', $key . " " . $messages->first());
        }
        $deductionoption->name = $request->name;
        $deductionoption->name_ar = $request->name_ar;
        $deductionoption->save();

        return redirect()->route('deductionoption.index')->with('success', __('DeductionOption successfully updated.'));


    }

    public function destroy(DeductionOption $deductionoption)
    {
        $deductionoption->delete();
        return redirect()->route('deductionoption.index')->with('success', __('DeductionOption successfully deleted.'));


    }
}

<?php

namespace App\Http\Controllers;

use App\Models\PayslipType;
use Illuminate\Http\Request;

class PayslipTypeController extends Controller
{
    public function index()
    {
        $paysliptypes = PayslipType::query();

        if (request()->ajax()) {
            $paysliptypes->where(function ($query) {
                $query->where('name', 'like', '%' . request('search') . '%')
                    ->orWhere('name_ar', 'like', '%' . request('search') . '%');
            });
            $search = view('new-theme.settings.salary.paginations.paysliptype_pagination', [
                'paysliptypes' => $paysliptypes->get(),
            ]);
            return response()->json(['search' => $search->render()]);
        }

        $paysliptypes = $paysliptypes->get();
        return view('new-theme.settings.salary.paysliptype', compact('paysliptypes'));
    }

    public function create()
    {
        if (auth()->user()->can('Create Payslip Type')) {
            return view('paysliptype.create');
        } else {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function store(Request $request)
    {


        $validator = \Validator::make(
            $request->all(), [
            'name' => 'required|max:20',
            'name_ar' => 'required|max:20',
        ]);
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            $key = array_keys($messages->getMessages())[0] ?? "";
            return redirect()->back()->with('error', $key . " " . $messages->first());
        }
        $paysliptype = new PayslipType();
        $paysliptype->name = $request->name;
        $paysliptype->name_ar = $request->name_ar;
        $paysliptype->created_by = auth()->user()->creatorId();
        $paysliptype->save();

        return redirect()->route('paysliptype.index')->with('success', __('PayslipType successfully created.'));

    }

    public function show(PayslipType $paysliptype)
    {
        return redirect()->route('paysliptype.index');
    }

    public function edit(PayslipType $paysliptype)
    {
        if (auth()->user()->can('Edit Payslip Type')) {

            return view('paysliptype.edit', compact('paysliptype'));

        } else {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function update(Request $request, PayslipType $paysliptype)
    {

        $validator = \Validator::make(
            $request->all(), [
            'name' => 'required|max:20',
            'name_ar' => 'required|max:20',
        ]);

        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            $key = array_keys($messages->getMessages())[0] ?? "";
            return redirect()->back()->with('error', $key . " " . $messages->first());
        }

        $paysliptype->name = $request->name;
        $paysliptype->name_ar = $request->name_ar;
        $paysliptype->save();

        return redirect()->route('paysliptype.index')->with('success', __('PayslipType successfully updated.'));
    }

    public function destroy(PayslipType $paysliptype)
    {
        $paysliptype->delete();

        return redirect()->route('paysliptype.index')->with('success', __('PayslipType successfully deleted.'));

    }


}

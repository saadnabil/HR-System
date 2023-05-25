<?php

namespace App\Http\Controllers;

use App\Models\LoanOption;
use Illuminate\Http\Request;

class LoanOptionController extends Controller
{
    public function index()
    {
        $loanoptions = LoanOption::query();

        if (request()->ajax()) {
            $loanoptions->where(function ($query) {
                $query->where('name', 'like', '%' . request('search') . '%')
                    ->orWhere('name_ar', 'like', '%' . request('search') . '%');
            });
            $search = view('new-theme.settings.salary.paginations.loanoption_pagination', [
                'loanoptions' => $loanoptions->get(),
            ]);
            return response()->json(['search' => $search->render()]);
        }

        $loanoptions = $loanoptions->get();

        return view('new-theme.settings.salary.loanoptions', compact('loanoptions'));
    }

    public function create()
    {
        if(auth()->user()->can('Create Loan Option'))
        {
            return view('loanoption.create');
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
                                   'name' => 'required|max:20',
                                   'name_ar' => 'required|max:20',
                               ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();
                $key = array_keys($messages->getMessages())[0] ?? "";
                return redirect()->back()->with('error',$key ." ". $messages->first());
            }
            $loanoption             = new LoanOption();
            $loanoption->name       = $request->name;
            $loanoption->name_ar       = $request->name_ar;
            $loanoption->created_by = auth()->user()->creatorId();
            $loanoption->save();

            return redirect()->route('loanoption.index')->with('success', __('LoanOption  successfully created.'));

    }

    public function show(LoanOption $loanoption)
    {
        return redirect()->route('loanoption.index');
    }

    public function edit(LoanOption $loanoption)
    {
        if(auth()->user()->can('Edit Loan Option'))
        {

                return view('loanoption.edit', compact('loanoption'));

        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function update(Request $request, LoanOption $loanoption)
    {


                $validator = \Validator::make(
                    $request->all(), [
                                       'name' => 'required|max:20',
                                       'name_ar' => 'required|max:20',
                                   ]
                );
                if($validator->fails())
                {
                    $messages = $validator->getMessageBag();
                    $key = array_keys($messages->getMessages())[0] ?? "";
                    return redirect()->back()->with('error',$key ." ". $messages->first());
                }
                $loanoption->name = $request->name;
                $loanoption->name_ar = $request->name_ar;
                $loanoption->save();

                return redirect()->route('loanoption.index')->with('success', __('LoanOption successfully updated.'));



    }

    public function destroy(LoanOption $loanoption)
    {


        $loanoption->delete();

        return redirect()->route('loanoption.index')->with('success', __('LoanOption successfully deleted.'));

    }

}

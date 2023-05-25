<?php

namespace App\Http\Controllers;

use App\Models\AwardType;
use Illuminate\Http\Request;

class AwardTypeController extends Controller
{
    public function index()
    {
        $awardtypes = AwardType::query();

        if (request()->ajax()){
            $awardtypes->where(function ($query) {
                $query->where('name', 'like', '%' . request('search') . '%')
                    ->orWhere('name_ar', 'like', '%' . request('search') . '%');
            });
            $search = view('new-theme.settings.salary.paginations.awardtype_pagination', [
                'awardtypes' => $awardtypes->get(),
            ]);
            return response()->json(['search' => $search->render()]);
        }
         $awardtypes = $awardtypes->get();

        return view('new-theme.settings.salary.awardtypes', compact('awardtypes'));
    }

    public function create()
    {
        if(auth()->user()->can('Create Award Type'))
        {
            return view('awardtype.create');
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

            $awardtype             = new AwardType();
            $awardtype->name       = $request->name;
            $awardtype->name_ar       = $request->name_ar;
            $awardtype->created_by = auth()->user()->creatorId();
            $awardtype->save();

        return redirect()->route('awardtype.index')->with('success', __('AwardType successfully created.'));

    }

    public function show(AwardType $awardtype)
    {
        return redirect()->route('awardtype.index');
    }

    public function edit(AwardType $awardtype)
    {
        if(auth()->user()->can('Edit Award Type'))
        {
            if($awardtype->created_by == auth()->user()->creatorId())
            {

                return view('awardtype.edit', compact('awardtype'));
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

    public function update(Request $request, AwardType $awardtype)
    {

            if($awardtype->created_by != auth()->user()->creatorId())
            {
                return redirect()->back()->with("error",__('Permission denied'));
            }

            $validator = \Validator::make(
                $request->all(), [
                       'name' => 'required|max:20',
                       'name_ar' => 'required|max:20',
                   ]);
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();
                $key = array_keys($messages->getMessages())[0] ?? "";
                return redirect()->back()->with('error',$key ." ". $messages->first());
            }

            $awardtype->name = $request->name;
            $awardtype->name_ar = $request->name_ar;
            $awardtype->save();

            return redirect()->route('awardtype.index')->with('success', __('AwardType successfully updated.'));


    }

    public function destroy(AwardType $awardtype)
    {

        if($awardtype->created_by != auth()->user()->creatorId())
        {
            return redirect()->back()->with("error",__('Permission denied'));
        }
        $awardtype->delete();

        return redirect()->route('awardtype.index')->with('success', __('AwardType successfully deleted.'));
    }
}

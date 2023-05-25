<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewTheme\PerformancePeriodRequest;
use App\Models\PerformanceFactor;
use App\Models\PerformancePeriod;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PerformancePeriodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $performancePeriods = PerformancePeriod::query()
        ->when($request->filled('search'), function ($q) {
            $q->where('name', 'like', "%" . request('search') . "%")->orWhere('name_ar', 'like', "%" . request('search') . "%");
        })->paginate();


    if ($request->ajax()) {
        $search   = view('new-theme.settings.performance-s.performanceperiods', compact('performancePeriods'));
        $paginate = view('new-theme.settings.performance-s.components.paginateperiod', compact('performancePeriods'));
        return response()->json(['search' => $search->render(), 'paginate' => $paginate->render()]);
    }
        return view('new-theme.settings.performance-s.performanceperiod', compact('performancePeriods'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PerformancePeriodRequest $request)
    {
        $data = $request->validated();
        PerformancePeriod::create($data);
        flash()->addSuccess(__('Added successfully'));
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PerformancePeriodRequest $request, $id)
    {
        $row  = PerformancePeriod::findorfail($id);
        $data = $request->validated();
        $row->update($data);
        flash()->addSuccess(__('Updated successfully'));
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $row = PerformancePeriod::findorfail($id);
        $factor =PerformanceFactor::where('performance_period_id',$id)->first();
        if ($factor) {
            return back()->with(['error' => 'something went wrong'], 400);
        };
    
        $row->delete();
        flash()->addSuccess(__('Deleted successfully'));

        return back();
    }
}

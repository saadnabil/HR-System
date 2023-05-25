<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ValidateBreak;
use App\Http\Requests\Api\ValidateStartBreak;
use App\Http\Resources\BreakResource;
use App\Models\CompanyBreak;
use App\Models\EmployeeBreak;
use App\Services\Api\BreakService;
use App\Traits\ApiResponser;
use Carbon\Carbon;

class CompanyBreaks extends Controller
{
    use ApiResponser;
    protected $breakService;
    public function __construct(BreakService $breakService)
    {
        $this->breakService = $breakService;
    }
    public function index()
    {
        $breaks = CompanyBreak::where('created_by' , auth()->user()->creatorId())->get();
        return $this->success( BreakResource::collection($breaks) ,'breaks' );
    }

    public function check_status(){
        $employee_break = EmployeeBreak::where(['employee_id' =>  auth()->user()->employee->id])->whereNull('end_time')->whereDate('created_at', Carbon::today())->first();
        if($employee_break != null){
            return $this->success(new BreakResource($employee_break));
        }
        return $this->success([]);
    }

    public function start_break(ValidateBreak $request){

        $data              = $request->validated();
        $employee = auth()->user()->employee;
        $break             = CompanyBreak::findorfail($data['break_id']);
        $time_now          = Carbon::parse(Carbon::now()->format('Y/m/d h:i a'));
        $start_break_time  = Carbon::createFromFormat('h:i a' , $break->start_time);
        $end_break_time    = Carbon::createFromFormat('h:i a' , $break->end_time);
        $employee_break    = EmployeeBreak::where(['employee_id' =>  auth()->user()->employee->id, 'break_id'  => $data['break_id'] ])->whereDate('created_at', Carbon::today())->first();
        $companySetting    = company_setting()->toArray(request());
        $router_status = 0;
        $location_status = 1;

        if($router_status == 1){

            $val = $this->breakService->check_router($request->header('ip'));
            if($val !== true){
                return $val;
            }
        }
        if($location_status == 1){
            $val = $this->breakService->check_location($employee , $request->lat , $request->lon);
            if($val !== true){
                return $val;
            }
        }
        if($time_now->gte($start_break_time) && $time_now->lt( $end_break_time) && $employee_break == null){
            //break_trarted successfully
            EmployeeBreak::create([
                'employee_id' => auth()->user()->employee->id,
                'break_id' => $data['break_id'],
                'start_time' => Carbon::now()->format('h:i a'),
                'created_by' => auth()->user()->creatorId(),
            ]);
            return $this->success([] , __('Break started'));
        }
        return $this->error(__('You cant start your break time now !') , 422);
    }
    public function end_break(ValidateBreak $request){
        $data = $request->validated();
        $employee = auth()->user()->employee;
        $break = CompanyBreak::findorfail($data['break_id']);
        // $time_now = Carbon::parse(Carbon::now()->format('Y/m/d h:i a'));
        // $start_break_time = Carbon::createFromFormat('h:i a' , $break->start_time);
        // $end_break_time = Carbon::createFromFormat('h:i a' , $break->end_time);
        // $companySetting    = company_setting()->toArray(request());
        $router_status = 0;
        $location_status = 1;
        if($router_status == 1){
            $val = $this->breakService->check_router($request->header('ip'));
            if($val !== true){
                return $val;
            }
        }
        if($location_status == 1){
            $val = $this->breakService->check_location($employee , $request->lat , $request->lon);
            if($val !== true){
                return $val;
            }
        }
        $employee_break = EmployeeBreak::where(['employee_id' =>  auth()->user()->employee->id, 'break_id'  => $data['break_id'] ])->whereNull('end_time')->whereDate('created_at', Carbon::today())->first();
        if(!$employee_break){
            return $this->error(__('You cant end your break time now !') , 422);
        }
        $employee_break->update([
            'end_time' => Carbon::now()->format('h:i a'),
        ]);
        return $this->success([] , __('Break ended'));

    }
}

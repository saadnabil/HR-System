<?php

namespace App\Services\Api;

use App\Http\Controllers\API\V1\HomeController;
use App\Models\AttendanceEmployee;
use App\Models\AttendanceMovement;
use App\Models\Leave;
use App\Models\LeaveType;
use App\Models\Loan;
use App\Models\LoanPending;
use App\Models\Mission;
use App\Models\Utility;
use App\Models\WorkFromHomeRequest;
use Carbon\Carbon;
use App\Traits\ApiResponser;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class BreakService
{
    use  ApiResponser;

    public function check_location($employee ,$lat , $lon){
        $locations = $employee -> finger_print_locations;
        $companySetting = company_setting()->toArray(request());
        if( $employee -> fingerprint_out_campany == 1 && count($locations) > 0){
            $bool = false;
            foreach($locations as $location){
                $distance = get_distance_between_two_points($location -> lat , $location -> long ,  $lat , $lon);
                if($distance < 1){
                   $bool = true;
                   break;
                }
            }
            if( $bool == true){
               return true;
            }
            return $this->error(__('You are not in the valid locations'), 200);
        }
        $distance = get_distance_between_two_points($lat , $lon, $companySetting['lat'] , $companySetting['lon']);
        if($distance >  1){
            return $this->error(__('You are not in the company'), 200);
        }
        return true;
    }

    public function check_router($request_ip){

        $companySetting = company_setting()->toArray(request());
        //Router settting
        $ipaddess     = $companySetting['ip_address'] ? json_decode($companySetting['ip_address']) : [];
        $ipaddess_new = [];
        foreach ($ipaddess as $ip) {
            array_push($ipaddess_new, substr($ip->value, 0, -3));
        }
        $bssid    = substr($request_ip, 0, -3);
        if ($ipaddess && !in_array($bssid, $ipaddess_new)) {
            return $this->error(__('messages.connectwithcompanyrouter'), 200);
        }
        return true;
    }

    public function check_mission_work_from_home($employee,$request,$type){
        $work_from_home_request = WorkFromHomeRequest::where([
            'employee_id'=>$employee -> id ,
            'date'=>Carbon::now()->format('Y-m-d')
        ])->first();
        $mission = Mission::where([
            'employee_id'=>$employee -> id ,
            'date'=>Carbon::now()->format('Y-m-d')
        ])->first();
        if(!$mission && !$work_from_home_request){
            return false;
        }
        if($type == 'checkin'){
            return $this->store_attendance($employee,$request);
        }elseif($type == 'checkout'){
            return $this->checkout($employee,$request);
        }

    }

    public function store_attendance($employee ,$request){
        $company_grace_period   = Utility::getValByName('company_grace_period');
        $startTime              = \Carbon\Carbon::parse(Utility::getValByName('company_start_time'))->addMinutes($company_grace_period);
        $in                     = date("H:i:s", strtotime(date('H:i:s')));
        if (strtotime($in) > strtotime($startTime)) {
            $totalLateSeconds = strtotime($in) - strtotime($startTime);
            $hours  = floor($totalLateSeconds / 3600);
            $mins   = floor($totalLateSeconds / 60 % 60);
            $secs   = floor($totalLateSeconds % 60);
            $late1  = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
        } else {
            $late1 = "00:00:00";
        }
        $newattandance = AttendanceEmployee::create([
            'employee_id'      => $employee->id,
            'status'           => 'Present',
            'date'             => date('Y-m-d'),
            'clock_in'         => date('H:i:s'),
            'lat'              => $request['lat'],
            'lon'              => $request['lon'],
            'in_company_range' => 1,
            'late'             => $late1,
            'total_rest'       => '00:00:00',
            'delay_reason'     => $request->delay_reason ?? null,
            'created_by'       => auth()->user()->creatorId(),
            'image_clock_in'   => null,
        ]);
        $data  = app(HomeController::class)->index($request);
        $data->message =  __('messages.startWork');
        return $data;
    }

    public function checkout($employee , $request){
        $out               = date("H:i:s", strtotime(date('H:i:s')));
        $attendance=$employee->haveAttendanceToday();
        $endTime           = \Carbon\Carbon::parse(Utility::getValByName('company_end_time'));
        if (strtotime($out) < strtotime('8:00')) {
            $totalOvertimeSeconds = strtotime('8:00') - strtotime($out);

            $hours                = floor($totalOvertimeSeconds / 3600 );
            $mins                 = floor($totalOvertimeSeconds / 60 % 60 );
            $secs                 = floor($totalOvertimeSeconds % 60);
            $late2                = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
        } else {
            $late2 = "00:00:00";
        }

        $late1 = $attendance ? strtotime($attendance->late) : strtotime("00:00:00");
        $late2 = strtotime($late2);
        $late  = \Carbon\Carbon::parse(($late1 + $late2))->format("H:i:s");

        //early Leaving
        $totalEarlyLeavingSeconds = strtotime($endTime) - strtotime($out);
        $hours                    = floor($totalEarlyLeavingSeconds / 3600);
        $mins                     = floor($totalEarlyLeavingSeconds / 60 % 60);
        $secs                     = floor($totalEarlyLeavingSeconds % 60);
        $earlyLeaving             = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);

        if ($out > strtotime('8:00')) {
            //Overtime
            $totalOvertimeSeconds = strtotime($out) - strtotime('8:00');
            $hours                = floor($totalOvertimeSeconds / 3600);
            $mins                 = floor($totalOvertimeSeconds / 60 % 60);
            $secs                 = floor($totalOvertimeSeconds % 60);
            $overtime             = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
        } else {
            $overtime = '00:00:00';
        }

        if ($attendance) {
            $attendance->update([
                'clock_out'             => $out,
                'late'                  => $late,
                'early_leaving'         => ($earlyLeaving > 0) ? $earlyLeaving : '00:00:00',
                'overtime'              => $overtime,
                'urgent_end_reason'     => $request->urgent_end_reason ?? null ,
                'image_clock_out'       => null,
            ]);
        } else {
            $newattandance = AttendanceEmployee::create([
                'employee_id'       => $employee->id,
                'status'            => 'Present',
                'date'              => date('Y-m-d'),
                'clock_in'          => null,
                'clock_out'         => $out,
                'lat'               => $request['lat'],
                'lon'               => $request['lon'],
                'in_company_range'  => 1,
                'late'              => $late1,
                'total_rest'        => '00:00:00',
                'delay_reason'      => $request->delay_reason,
                'early_leaving'     => ($earlyLeaving > 0) ? $earlyLeaving : '00:00:00',
                'overtime'          => $overtime,
                'urgent_end_reason' => $request->urgent_end_reason ?? null ,
                'created_by'        => auth()->user()->creatorId(),
                'image_clock_out' => null,
            ]);
        }
        $data  = app(HomeController::class)->index($request);
        $data->message =  __('messages.startWork');
        return $data;
    }
}

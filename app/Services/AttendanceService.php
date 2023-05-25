<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Builder;

class AttendanceService
{

    public function filter(Builder $attendances){
        if(request('search')){
             $attendances->where(function($q){

                $q->where('date' , 'like' , '%'.request('search').'%')
                    ->orwhere('clock_in'  , 'like' , '%'.request('search').'%')
                    ->orwhere('clock_out'  , 'like' , '%'.request('search').'%')

                    ->orwhereHas('employee' , function($q){
                        $q->where('name' , 'like' , '%' . request('search') . '%' )
                            ->orwhere('name_ar' , 'like' , '%' . request('search') . '%');
                    })

                    ->orwhereHas('employee.jobtitle' , function($q){
                        $q->where('name' , 'like' , '%' . request('search') . '%' )
                            ->orwhere('name_ar' , 'like' , '%' . request('search') . '%');

                    });
            });
        }
         $attendances->when(request('start_date'), function ($q){
            $q->where('date','>=',request('start_date'));
        })->when(request('end_date'), function ($q){
            $q->where('date','<=',request('end_date'));
        });

        return $attendances;
    }
}

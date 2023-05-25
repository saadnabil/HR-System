<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Builder;

class OverTimeService
{
    public function filter(Builder $overtimerequests){
        if(request('search')){
            $overtimerequests = $overtimerequests->where(function($q){
                $q->where('reason' , 'like' , '%'.request('search').'%')
                    ->orwhere('date'  , 'like' , '%'.request('search').'%')
                    ->orwhere('start'  , 'like' , '%'.request('search').'%')
                    ->orwhere('end'  , 'like' , '%'.request('search').'%')
                    ->orwhereHas('employee' , function($q){
                        $q->where('name' , 'like' , '%' . request('search') . '%' )
                            ->orwhere('name_ar' , 'like' , '%' . request('search') . '%');
                    });
            });
        }
    }
}

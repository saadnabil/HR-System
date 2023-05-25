<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $guarded = [];

    public function manager(){
        return $this->belongsTo(Employee::class , 'employee_id');
    }

    public function branch(){
        return $this->hasOne('App\Models\Branch','id','branch_id');
    }

    public function employees()
    {
        return $this->hasOne('App\Models\Employee', 'id', 'employee_id');
    }

    public function employeess()
    {
        return $this->hasMany('App\Models\Employee');
    }
}

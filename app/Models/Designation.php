<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    protected $fillable = [
        'department_id','name','name_ar','created_by'
    ];
    public function departmant(){
        return $this->belongsTo(Department::class , 'department_id');
    }
}

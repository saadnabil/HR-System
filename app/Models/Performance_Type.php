<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Performance_Type extends Model
{
    // use HasFactory;

    protected $fillable = [
        'name',
         'name_ar',
        // 'type',
        'created_by',
    ];

    public function types()
    {
        return $this->hasMany('App\Models\Competencies', 'type', 'id');
    }

    public function getTranslatedNameAttribute()
    {
        return app()->getLocale() == 'ar' ? $this->name_ar  : $this->name;
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trainer extends Model
{
    protected $fillable = [
        'branch',
        'firstname',
        'lastname',
        'firstname_ar',
        'lastname_ar',
        'contact',
        'email',
        'address',
        'expertise',
        'created_by',
    ];

    public function branches()
    {
        return $this->hasOne('App\Models\Branch', 'id', 'branch');
    }
}

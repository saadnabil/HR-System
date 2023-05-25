<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Landplan extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function features(){
        return $this->hasMany(Landfeature::class);
    }
}

<?php
namespace App\Models;



use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class TaskActivityLog extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function employee():BelongsTo
    {
        return $this->belongsTo(Employee::class)->withDefault();
    }

}

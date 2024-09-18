<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Leave extends Model
{
    use SoftDeletes;

    protected $table = 'leaves';

    protected $fillable = [
        'employee_id',
        'username',
        'application_id',
        'total_leave',
        'start_date',
        'end_date',
        'start_half',
        'end_half',
        'on_date',
        'on_time',
        'leave_type',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'on_date' => 'date',
        'on_time' => 'datetime',
    ];

    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

}
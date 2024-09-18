<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeaveApplication extends Model
{
    use SoftDeletes;

    protected $table = 'leave_applications';

    protected $fillable = [
        'employee_id',
        'name',
        'username',
        'leave_type',
        'start_date',
        'end_date',
        'start_half',
        'end_half',
        'number_of_days',
        'rejection_reason',
        'reason',
        'total_leave',
        'status',
        'on_date',
        'on_time',
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
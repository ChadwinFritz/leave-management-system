<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeaveType extends Model
{
    use SoftDeletes;

    protected $table = 'leave_types';

    protected $fillable = [
        'code',
        'name',
        'has_limit',
        'limit',
    ];

    protected $casts = [
        'has_limit' => 'boolean',
    ];

}
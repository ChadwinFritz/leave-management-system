<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveType extends Model
{
    // Specify the table name
    protected $table = 'tblleavetype';

    // Specify fillable fields for mass assignment
    protected $fillable = ['LeaveType', 'Description'];

    // Disable timestamps if not used in the table
    public $timestamps = false;

    // Define the relationship: A leave type has many leaves
    public function leaves()
    {
        return $this->hasMany(Leave::class, 'LeaveType', 'LeaveType');
    }
}

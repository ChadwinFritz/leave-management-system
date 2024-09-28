<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    // Specify the table name
    protected $table = 'tblleaves';

    // Specify fillable fields for mass assignment
    protected $fillable = [
        'LeaveType', 'ToDate', 'FromDate', 'Description', 'PostingDate', 
        'AdminRemark', 'AdminRemarkDate', 'Status', 'IsRead', 'empid'
    ];

    // Disable timestamps if not used in the table
    public $timestamps = false;

    // Define the relationship: A leave belongs to an employee
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'empid', 'id');
    }

    // Define the relationship: A leave belongs to a leave type
    public function leaveType()
    {
        return $this->belongsTo(LeaveType::class, 'LeaveType', 'LeaveType');
    }
}

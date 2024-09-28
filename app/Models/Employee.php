<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    // Specify the table name
    protected $table = 'tblemployees';

    // Specify fillable fields for mass assignment
    protected $fillable = [
        'EmpId', 'FirstName', 'LastName', 'EmailId', 'Password', 'Gender', 
        'Dob', 'Department', 'Address', 'City', 'Country', 'Phonenumber', 'Status'
    ];

    // Disable timestamps if not used in the table
    public $timestamps = false;

    // Define the relationship: An employee belongs to a department
    public function department()
    {
        return $this->belongsTo(Department::class, 'Department', 'DepartmentName');
    }

    // Define the relationship: An employee has many leaves
    public function leaves()
    {
        return $this->hasMany(Leave::class, 'empid', 'id');
    }
}

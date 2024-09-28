<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    // Specify the table name
    protected $table = 'tbldepartments';

    // Specify fillable fields for mass assignment
    protected $fillable = ['DepartmentName', 'DepartmentShortName', 'DepartmentCode'];

    // Disable timestamps if not used in the table
    public $timestamps = false;

    // Define the relationship: A department has many employees
    public function employees()
    {
        return $this->hasMany(Employee::class, 'Department', 'DepartmentName');
    }
}

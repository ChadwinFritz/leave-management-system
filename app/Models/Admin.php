<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    // Specify the table name
    protected $table = 'admin';

    // Specify fillable fields for mass assignment
    protected $fillable = ['Username', 'Password', 'Fullname', 'Email'];

    // Disable timestamps if not used in the table
    public $timestamps = false;
}

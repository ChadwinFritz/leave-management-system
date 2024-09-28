<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblEmployeesTable extends Migration
{
    public function up()
    {
        Schema::create('tblemployees', function (Blueprint $table) {
            $table->increments('id');  // Primary key
            $table->string('EmpId', 10)->unique();  // Employee ID
            $table->string('FirstName', 100);
            $table->string('LastName', 100);
            $table->string('EmailId', 100)->unique();
            $table->string('Password', 255);
            $table->string('Gender', 10);
            $table->date('Dob');  // Date of Birth
            $table->string('Department', 100);  // Foreign key for Department
            $table->string('Address', 255)->nullable();
            $table->string('City', 100);
            $table->string('Country', 100);
            $table->string('Phonenumber', 15)->nullable();
            $table->string('Status', 20)->default('Active');

            // Foreign key constraint
            $table->foreign('Department')->references('DepartmentName')->on('tbldepartments');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tblemployees');
    }
}

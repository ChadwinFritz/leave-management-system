<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblDepartmentsTable extends Migration
{
    public function up()
    {
        Schema::create('tbldepartments', function (Blueprint $table) {
            $table->increments('id');  // Primary key
            $table->string('DepartmentName', 100)->unique();
            $table->string('DepartmentShortName', 50)->nullable();
            $table->string('DepartmentCode', 10)->unique();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tbldepartments');
    }
}

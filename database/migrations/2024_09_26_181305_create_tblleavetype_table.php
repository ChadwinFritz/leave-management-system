<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblLeaveTypeTable extends Migration
{
    public function up()
    {
        Schema::create('tblleavetype', function (Blueprint $table) {
            $table->increments('id');  // Primary key
            $table->string('LeaveType', 100)->unique();
            $table->text('Description')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tblleavetype');
    }
}

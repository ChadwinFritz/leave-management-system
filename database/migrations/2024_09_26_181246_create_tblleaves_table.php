<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblLeavesTable extends Migration
{
    public function up()
    {
        Schema::create('tblleaves', function (Blueprint $table) {
            $table->increments('id');  // Primary key
            $table->unsignedInteger('LeaveType');  // Foreign key to leave types
            $table->unsignedInteger('empid');  // Foreign key to employees
            $table->date('FromDate');
            $table->date('ToDate');
            $table->text('Description')->nullable();
            $table->timestamp('PostingDate')->useCurrent();
            $table->string('AdminRemark')->nullable();
            $table->timestamp('AdminRemarkDate')->nullable();
            $table->string('Status', 20)->default('Pending');
            $table->boolean('IsRead')->default(false);

            // Foreign key constraints
            $table->foreign('LeaveType')->references('id')->on('tblleavetype');
            $table->foreign('empid')->references('id')->on('tblemployees');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tblleaves');
    }
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leaves', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('employee_id'); // Foreign key to the employees table
            $table->string('username'); // Username of the employee applying for leave
            $table->string('application_id')->unique(); // Unique identifier for the leave application
            $table->unsignedInteger('total_leave')->nullable(); // Total number of leave days
            $table->date('start_date'); // Start date of the leave
            $table->date('end_date'); // End date of the leave
            $table->string('start_half')->nullable(); // Half-day status for the start of leave
            $table->string('end_half')->nullable(); // Half-day status for the end of leave
            $table->date('on_date')->nullable(); // Specific date, if applicable
            $table->time('on_time')->nullable(); // Specific time, if applicable
            $table->string('leave_type'); // Type of leave being requested
            $table->timestamps(); // Created and updated timestamps
            $table->softDeletes(); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leaves');
    }
}

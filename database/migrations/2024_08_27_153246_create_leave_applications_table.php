<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeaveApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leave_applications', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('employee_id'); // Foreign key to the employees table
            $table->string('name')->nullable(); // Name of the employee applying for leave
            $table->string('username')->nullable(); // Username of the employee
            $table->string('leave_type'); // Type of leave
            $table->date('start_date'); // Start date of the leave
            $table->date('end_date'); // End date of the leave
            $table->string('start_half')->nullable(); // Half-day status for the start of leave
            $table->string('end_half')->nullable(); // Half-day status for the end of leave
            $table->integer('number_of_days'); // Number of leave days
            $table->string('rejection_reason')->nullable(); // Reason for rejection, if applicable
            $table->string('reason'); // Reason for the leave request
            $table->unsignedInteger('total_leave')->nullable(); // Total number of leave days
            $table->string('status'); // Status of the leave application (e.g., pending, approved, rejected)
            $table->date('on_date')->nullable(); // Specific date, if applicable
            $table->time('on_time')->nullable(); // Specific time, if applicable
            $table->timestamps(); // Created and updated timestamps
            $table->timestamp('deleted_at')->nullable()->after('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leave_applications');
    }
}

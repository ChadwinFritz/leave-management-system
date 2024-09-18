<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeaveTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leave_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique(); // Unique code for the leave type
            $table->string('name')->nullable(); // Name of the leave type
            $table->boolean('has_limit')->default(false); // Indicates if there is a limit
            $table->integer('limit')->nullable(); // The limit for this leave type, if applicable
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
        Schema::dropIfExists('leave_types');
    }
}

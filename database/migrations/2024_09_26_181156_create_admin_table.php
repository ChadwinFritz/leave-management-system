<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminTable extends Migration
{
    public function up()
    {
        // Create the admin table
        Schema::create('admins', function (Blueprint $table) { 
            $table->increments('id'); 
            $table->string('username', 100); 
            $table->string('password', 255); 
            $table->string('fullname', 255); 
            $table->string('email', 100)->unique(); 
            $table->timestamps(); 
        });

        // Create the sessions table
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->unique(); 
            $table->unsignedInteger('admin_id')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('admins'); 
    }
}

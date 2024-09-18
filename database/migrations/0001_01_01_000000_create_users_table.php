<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable(); // Full name of the user
            $table->string('designation')->nullable(); // Job title or designation
            $table->string('duty')->nullable(); // Specific duty or role of the user
            $table->string('email')->unique(); // Email address of the user
            $table->text('note')->nullable(); // Additional notes or comments
            $table->string('image')->nullable(); // Path to the user's profile image
            $table->string('level')->default('0'); // User level or rank
            $table->string('username')->unique(); // Unique username
            $table->string('password'); // User password
            $table->string('role')->default('admin'); // Role of the user
            $table->rememberToken(); // Token for "remember me" functionality
            $table->timestamps(); // Created and updated timestamps
            $table->softDeletes(); // Adds the deleted_at column for soft deletes
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            $table->string('phone', 20)->nullable();
            $table->string('address')->nullable();
            $table->string('national_id')->unique()->nullable();

            $table->enum('gender', ['male', 'female'])->nullable();

            $table->enum('role', ['admin', 'student', 'teacher']);

            $table->enum('status', ['active', 'inactive', 'pending', 'approved', 'rejected'])
                ->default('active');

            $table->rememberToken();
            $table->timestamps();
        });
    }
};

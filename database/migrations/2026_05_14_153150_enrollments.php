<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('enrollments', function (Blueprint $table) {
            $table->uuid()->primary();

            $table->foreignUuid('student_id')->constrained('students')->cascadeOnDelete();
            $table->foreignUuid('class_id')->constrained('school_classes')->cascadeOnDelete();

            $table->string('academic_year')->nullable();
            $table->string('semester')->nullable();

            $table->date('enrollment_date')->nullable();

            $table->enum('status', [
                'active',
                'suspended',
                'cancelled',
                'completed',
            ])->default('active');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};
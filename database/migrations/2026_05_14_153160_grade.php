<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('grades', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('student_id')->constrained('students')->cascadeOnDelete();
            $table->foreignUuid('subject_id')->constrained('subjects')->cascadeOnDelete();
            $table->foreignUuid('class_id')->constrained('school_classes')->cascadeOnDelete();

            $table->decimal('quarterly_exam', 5, 2)->nullable();
            $table->decimal('semester_exam', 5, 2)->nullable();
            $table->decimal('final_exam', 5, 2)->nullable();

            $table->decimal('final_average', 5, 2)->nullable();
            $table->enum('status', ['passed', 'failed', 'appeal'])->nullable();

            $table->timestamps();

            $table->unique(['student_id', 'subject_id', 'class_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};

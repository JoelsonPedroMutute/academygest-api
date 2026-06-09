<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('school_classes', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('course_id')
                ->constrained('courses')
                ->cascadeOnDelete();

            $table->string('name')->index();
            $table->string('academic_year')->nullable();
            $table->string('semester')->nullable();
            $table->unsignedSmallInteger('capacity')->nullable();

            $table->enum('shift', ['morning', 'afternoon', 'evening'])->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('school_classes');
    }
};

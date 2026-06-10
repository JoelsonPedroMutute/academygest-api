<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subjects', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('course_id')
                ->constrained('courses')
                ->cascadeOnDelete();

            $table->string('name')->index();
            $table->text('description')->nullable();
            $table->unsignedInteger('workload')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};

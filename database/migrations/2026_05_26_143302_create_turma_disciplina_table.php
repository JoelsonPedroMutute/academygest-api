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
        Schema::create('turma_disciplina', function (Blueprint $table) {
            $table->foreignId('turma_id')->constrained()->cascadeOnDelete();
            $table->foreignId('disciplina_id')->constrained()->cascadeOnDelete();
            $table->primary(['turma_id', 'disciplina_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('turma_disciplina');
    }
};

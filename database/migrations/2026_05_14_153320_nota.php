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
        Schema::create('notas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('aluno_id')->constrained()->onDelete('cascade');
            $table->foreignId('disciplina_id')->constrained()->onDelete('cascade');
            $table->foreignId('turma_id')->constrained()->onDelete('cascade');



            $table->decimal('prova_trimestral', 5, 2)->nullable();
            $table->decimal('prova_semestral', 5, 2)->nullable();
            $table->decimal('exame_final', 5, 2)->nullable();

            $table->decimal('media_final', 5, 2)->nullable();
            $table->enum('situacao', ['aprovado', 'reprovado', 'recurso'])->nullable();

            $table->timestamps();

            $table->unique(['aluno_id', 'disciplina_id', 'turma_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notas');
    }
};

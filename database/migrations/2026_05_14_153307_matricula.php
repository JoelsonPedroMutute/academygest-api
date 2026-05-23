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
        Schema::create('matriculas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('aluno_id')->constrained()->onDelete('cascade');
            $table->foreignId('turma_id')->constrained()->onDelete('cascade');


            $table->string('ano_letivo')->nullable();
            $table->string('semestre')->nullable();

            $table->date('data_matricula')->nullable();

            $table->enum('status', [
                'ativa',
                'suspensa',
                'cancelada',
                'concluida'
            ])->default('ativa');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matriculas');
    }
};

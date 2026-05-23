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
        Schema::create('turmas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('curso_id')->constrained()->cascadeOnDelete();

            $table->string('nome')->index();
            $table->string('ano_letivo')->nullable();
            $table->string('semestre')->nullable();
            $table->unsignedSmallInteger('capacidade')->nullable();

            $table->enum('turno', [
                'diurno',
                'vespertino',
                'noturno'
            ])->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('turmas');
    }
};

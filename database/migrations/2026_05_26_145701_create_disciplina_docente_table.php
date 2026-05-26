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
        Schema::create('disciplina_docente', function (Blueprint $table) {
            $table->foreignId('disciplina_id')->constrained()->cascadeOnDelete();
            $table->foreignId('docente_id')->constrained()->cascadeOnDelete();
            $table->primary(['disciplina_id', 'docente_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('disciplina_docente');
    }
};

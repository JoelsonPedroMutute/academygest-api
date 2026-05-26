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
        Schema::table('alunos', function (Blueprint $table) {
            $table->string('numero_estudante', 20)->unique()->nullable()->after('user_id');
            $table->foreignId('turma_id')->nullable()->constrained()->after('numero_estudante');
        });
    }

    public function down(): void
    {
        Schema::table('alunos', function (Blueprint $table) {
            $table->dropForeign(['turma_id']);
            $table->dropColumn(['numero_estudante', 'turma_id']);
        });
    }
};

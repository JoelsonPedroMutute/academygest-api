<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\AlunoController;
use App\Http\Controllers\DocenteController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\TurmaController;
use App\Http\Controllers\SalaController;
use App\Http\Controllers\DisciplinaController;
use App\Http\Controllers\AulaController;
use App\Http\Controllers\NotaController;
use App\Http\Controllers\MatriculaController;
use App\Http\Controllers\FrequenciaController;
use App\Http\Controllers\TurmaDisciplinaController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use Illuminate\Support\Facades\Route;

// ─── Rotas públicas ──────────────────────────────────────────────────
Route::post('/login', [AuthController::class, , 'login']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

// ─── Rotas protegidas ────────────────────────────────────────────────
Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    // ─── Admin ───────────────────────────────────────────────────────
    Route::middleware('admin')
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {
            Route::get('/dashboard', [AdminDashboard::class, 'index']);
            Route::apiResource('alunos', AlunoController::class);
            Route::apiResource('docentes', DocenteController::class);
            Route::apiResource('cursos', CursoController::class);
            Route::apiResource('turmas', TurmaController::class);
            Route::apiResource('salas', SalaController::class);
            Route::apiResource('disciplinas', DisciplinaController::class);
            Route::apiResource('aulas', AulaController::class);
            Route::apiResource('notas', NotaController::class);
            Route::apiResource('matriculas', MatriculaController::class);
            Route::apiResource('frequencias', FrequenciaController::class);
            Route::apiResource('turmas-disciplinas', TurmaDisciplinaController::class);
        });

    // ─── Docente ─────────────────────────────────────────────────────
    Route::middleware('docente')
        ->prefix('docente')
        ->name('docente.')
        ->group(function () {
            Route::get('/dashboard', [AdminDashboard::class, 'docenteDashboard']);
            Route::apiResource('aulas', AulaController::class);
            Route::get('notas', [NotaController::class, 'index']);
            Route::post('notas', [NotaController::class, 'store']);
            Route::get('turmas', [TurmaController::class, 'index']);
            Route::get('turmas/{turma}', [TurmaController::class, 'show']);
            Route::get('cursos', [CursoController::class, 'index']);
            Route::get('disciplinas', [DisciplinaController::class, 'index']);
            Route::get('perfil', [DocenteController::class, 'meuPerfil']);
            Route::put('perfil', [DocenteController::class, 'atualizarMeuPerfil']);
        });

    // ─── Aluno ───────────────────────────────────────────────────────
    Route::middleware('aluno')
        ->prefix('aluno')
        ->name('aluno.')
        ->group(function () {
            Route::get('/dashboard', [AdminDashboard::class, 'alunoDashboard']);
            Route::get('perfil', [AlunoController::class, 'meuPerfil']);
            Route::put('perfil', [AlunoController::class, 'atualizarMeuPerfil']);
            Route::get('notas', [NotaController::class, 'minhasNotas']);
            Route::get('turmas/{turma}', [TurmaController::class, 'show']);
            Route::get('cursos', [CursoController::class, 'index']);
            Route::get('disciplinas', [DisciplinaController::class, 'index']);
        });
});
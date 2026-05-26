<?php

use App\Http\Controllers\Api\V1\AlunoController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\V1\CursosController;
use App\Http\Controllers\Api\V1\DisciplinasController;
use App\Http\Controllers\Api\V1\DocentesController;
use App\Http\Controllers\Api\V1\MatriculasController;
use App\Http\Controllers\Api\V1\NotasController;
use App\Http\Controllers\Api\V1\TurmasController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


//  ROTAS PÚBLICAS

Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

// ✔SELF-SERVICE REGISTO
Route::post('/register/aluno', [AuthController::class, 'registerAluno']);
Route::post('/register/docente', [AuthController::class, 'registerDocente']);


//  ROTAS PROTEGIDAS

Route::middleware(['auth:sanctum', 'active'])->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    // TESTE TEMPORÁRIO — remove depois de confirmar que funciona
    Route::get('/ping', function (Request $request) {
        return response()->json([
            'user'     => $request->user(),
            'token_id' => $request->user()->currentAccessToken()->id
        ]);
    });


    //  ADMIN

    Route::middleware('role:admin')
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {

            Route::get('/dashboard', [AdminDashboard::class, 'admin']);

            Route::get('docentes/pending', [DocentesController::class, 'pending']);
            Route::post('docentes/{docente}/approve', [DocentesController::class, 'approve']);
            Route::post('docentes/{docente}/reject', [DocentesController::class, 'reject']);
            Route::apiResource('alunos', AlunoController::class);
            Route::apiResource('docentes', DocentesController::class);
            Route::apiResource('cursos', CursosController::class);
            Route::apiResource('turmas', TurmasController::class);
            Route::apiResource('disciplinas', DisciplinasController::class);
            Route::apiResource('notas', NotasController::class);
            Route::apiResource('matriculas', MatriculasController::class);
        });


    //  DOCENTE

    Route::middleware('role:docente')
        ->prefix('docente')
        ->name('docente.')
        ->group(function () {

            Route::get('/dashboard', [AdminDashboard::class, 'docente']);

            // Rotas que docente pode usar
            Route::get('notas', [NotasController::class, 'index']);      // Listar todas notas
            Route::post('notas', [NotasController::class, 'store']);     // Criar nota
            Route::get('notas/{nota}', [NotasController::class, 'show']); // Ver nota específica


            Route::get('turmas', [TurmasController::class, 'index']);
            Route::get('turmas/{turma}', [TurmasController::class, 'show']);


            Route::get('cursos', [CursosController::class, 'index']);
            Route::get('disciplinas', [DisciplinasController::class, 'index']);

            Route::get('perfil', [DocentesController::class, 'meuPerfil']);
            Route::patch('perfil', [DocentesController::class, 'actualizarMeuPerfil']);
        });


    // 🎓 ALUNO

    Route::middleware('role:aluno')
        ->prefix('aluno')
        ->name('aluno.')
        ->group(function () {

            Route::get('/dashboard', [AdminDashboard::class, 'aluno']);

            Route::get('perfil', [AlunoController::class, 'meuPerfil']);
            Route::patch('perfil', [AlunoController::class, 'atualizarMeuPerfil']);

            Route::get('notas', [NotasController::class, 'minhasNotas']);

            Route::get('turmas/{turma}', [TurmasController::class, 'show']);

            Route::get('cursos', [CursosController::class, 'index']);
            Route::get('disciplinas', [DisciplinasController::class, 'index']);
        });
});

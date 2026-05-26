<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\V1\BaseController;
use App\Http\Requests\StoreDocenteRequest;
use App\Http\Requests\StoreAlunoRequest;
use App\Services\AuthService;
use App\Services\AlunoService;
use App\Services\DocenteService;
use Illuminate\Http\Request;

class AuthController extends BaseController
{
    public function __construct(
        private AuthService $authService,
        private DocenteService $docenteService,
        private AlunoService $alunoService
    ) {}

    public function login(Request $request)
    {
        $data = $this->authService->login(
            $request->only('email', 'password')
        );

        if (!$data['success']) {
            return $this->error($data['message'], 401);
        }

        return $this->success($data, 'Login realizado com sucesso.');
    }

    public function logout(Request $request)
    {
        $this->authService->logout($request->user());

        return $this->success(null, 'Logout realizado com sucesso.');
    }

    public function registerDocente(StoreDocenteRequest $request)
    {
        $docente = $this->docenteService->criar(
            $request->validated(),
            'public'
        );

        return $this->success($docente, 'Registo enviado. Aguarda aprovação.', 201);
    }

    public function registerAluno(StoreAlunoRequest $request) // ✅ StoreAlunoRequest
    {
        $aluno = $this->alunoService->criar(
            $request->validated(),
            'public'
        );

        return $this->success($aluno, 'Aluno registado com sucesso.', 201);
    }
}

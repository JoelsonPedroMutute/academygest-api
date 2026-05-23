<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\V1\BaseController;
use App\Services\AdminDashboardService;

class DashboardController extends BaseController
{
    public function __construct(
        protected AdminDashboardService $service
    ) {}

    public function admin()
    {
        $data = $this->service->getData();

        return $this->success(
            'Dashboard carregado com sucesso.',
            $data
        );
    }

    public function docente()
    {
        return $this->success(
            'Dashboard do docente carregado com sucesso.',
            $this->service->getData('docente')
        );
    }

    public function aluno()
    {
        return $this->success(
            'Dashboard do aluno carregado com sucesso.',
            $this->service->getData('aluno')
        );
    }
}

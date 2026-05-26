<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Api\V1\BaseController;
use App\Services\AdminDashboardService;

class DashboardController extends BaseController
{
    public function __construct(
        protected AdminDashboardService $service
    ) {}

    public function admin()
    {
        $data = $this->service->getData('admin');

        return $this->success($data, 'Dashboard admin carregado');
    }

    public function docente()
    {
        $data = $this->service->getData('docente');

        return $this->success($data, 'Dashboard docente carregado');
    }

    public function aluno()
    {
        $data = $this->service->getData('aluno');

        return $this->success($data, 'Dashboard aluno carregado');
    }
}

<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\JsonResponse;

class BaseController extends Controller
{
    protected function success(
        mixed $data = null,
        string $message = 'Operação realizada com sucesso.',
        int $code = 200
    ): JsonResponse {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    protected function error(
        string $message = 'Erro na operação.',
        int $code = 400,
        mixed $errors = null
    ): JsonResponse {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors,
        ], $code);
    }
}

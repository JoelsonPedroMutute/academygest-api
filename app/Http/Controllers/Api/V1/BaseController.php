<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\JsonResponse;

class BaseController extends Controller
{
    protected function success(
        string $message,
        mixed $data = null,
        int $code = 200
    ): JsonResponse {
        return response()->json([
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    protected function error(
        string $message,
        int $code = 400
    ): JsonResponse {
        return response()->json([
            'message' => $message,
        ], $code);
    }
}

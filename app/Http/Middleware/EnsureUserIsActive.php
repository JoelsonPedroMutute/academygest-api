<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserIsActive
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'Não autenticado.'], 401);
        }

        if (!in_array($user->status, ['active', 'approved'])) {
            return response()->json([
                'message' => 'A sua conta não tem permissão para aceder ao sistema.',
                'status'  => $user->status
            ], 403);
        }

        return $next($request);
    }
}

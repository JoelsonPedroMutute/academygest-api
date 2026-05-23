<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // ===============================
    // FORM LOGIN
    // ===============================
    public function showLoginForm()
    {
        if (Auth::check()) {
            return $this->redirectByRole();
        }

        return view('auth.login');
    }

    // ===============================
    // LOGIN
    // ===============================
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credenciais = $request->only('email', 'password');

        if (!Auth::attempt($credenciais, $request->filled('remember'))) {
            return back()
                ->withErrors([
                    'email' => 'Credenciais inválidas.',
                ])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        return $this->redirectByRole()
            ->with('success', 'Login realizado com sucesso.');
    }

    // ===============================
    // LOGOUT
    // ===============================
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('auth.login')
            ->with('success', 'Logout realizado com sucesso.');
    }

    // ===============================
    // REDIRECT POR ROLE
    // ===============================
    private function redirectByRole()
    {
        return match (Auth::user()->role) {

            'admin' => redirect()->route('admin.dashboard'),

            'docente' => redirect()->route('docente.dashboard'),

            'aluno' => redirect()->route('aluno.dashboard'),

            default => redirect()
                ->route('auth.login')
                ->withErrors([
                    'email' => 'Tipo de usuário inválido.',
                ]),
        };
    }
}

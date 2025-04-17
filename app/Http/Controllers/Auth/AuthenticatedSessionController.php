<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    /**
     * Exibe o formulário de login.
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Processa a autenticação do usuário.
     */
    public function store(Request $request)
    {
        $credentials = $request->validate([
            'role' => ['required', 'in:admin,vendedor,cliente'],
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Tenta autenticar com email, senha e role
        if (Auth::attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password'],
            'role' => $credentials['role'],
        ], $request->filled('remember'))) {

            $request->session()->regenerate();

            // Redireciona para o painel de acordo com o papel
            $role = Auth::user()->role;

            return redirect()->route($role . '.dashboard');
        }

        throw ValidationException::withMessages([
            'email' => __('As credenciais informadas estão incorretas.'),
        ]);
    }

    /**
     * Realiza logout e redireciona para a página de login.
     */
    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}

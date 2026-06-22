<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // 1. Mostra a tela de login do Admin
    public function mostrarLogin()
    {
        // Se o admin já estiver logado, redireciona para o dashboard
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        
        return view('admin.auth.login'); // Vamos criar essa view no próximo passo
    }

    // 2. Processa o login do Admin
    public function login(Request $request)
    {
        $credenciais = $request->validate([
            'email_usuario' => ['required', 'email'],
            'senha_usuario' => ['required'],
        ]);

        // ATENÇÃO AQUI: Como a sua tabela usa 'senha_usuario' em vez de 'password', 
        // e o nível de acesso está na mesma tabela, a validação é um pouco diferente.
        
        // Tenta buscar o usuário no banco
        $usuario = \App\Models\Usuario::where('email_usuario', $request->email_usuario)
                                      ->where('nivel_acesso_usuario', 'ADMIN')
                                      ->where('status_usuario', 'ATIVO')
                                      ->first();

        // Se encontrou o usuário e a senha criptografada bate...
        if ($usuario && \Illuminate\Support\Facades\Hash::check($request->senha_usuario, $usuario->senha_usuario)) {
            // ... faz o login usando o "guard" de admin (que configuraremos depois)
            Auth::guard('admin')->login($usuario);
            $request->session()->regenerate();

            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'email_usuario' => 'As credenciais fornecidas não correspondem aos nossos registros ou você não tem acesso de Administrador.',
        ])->onlyInput('email_usuario');
    }

    // 3. Processa o Logout
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
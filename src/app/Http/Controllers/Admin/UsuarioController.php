<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Cliente;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    // Lista os usuários (o que já tínhamos feito)
    public function index(Request $request)
    {
        $tipo = $request->get('tipo', 'admins');

        if ($tipo === 'clientes') {
            $lista = Cliente::orderBy('created_at', 'desc')->get();
        } else {
            $lista = Usuario::orderBy('created_at', 'desc')->get();
        }

        return view('admin.usuarios.index', compact('lista', 'tipo'));
    }

    // 🌟 NOVO: Mostra a tela com o formulário de cadastro
    public function create()
    {
        return view('admin.usuarios.create');
    }

    // 🌟 NOVO: Processa o formulário e salva na tbl_usuario
    public function store(Request $request)
    {
        $request->validate([
            'nome_usuario'  => 'required|string|max:255',
            'email_usuario' => 'required|string|email|max:255|unique:tbl_usuario,email_usuario',
            'senha_usuario' => 'required|string|min:6',
            'nivel_acesso_usuario' => 'required|string'
        ], [
            'email_usuario.unique' => 'Este e-mail já está cadastrado no sistema!'
        ]);

        // Cria o usuário com a senha criptografada corretamente
        Usuario::create([
            'nome_usuario' => $request->nome_usuario,
            'email_usuario' => $request->email_usuario,
            'senha_usuario' => Hash::make($request->senha_usuario),
            'nivel_acesso_usuario' => $request->nivel_acesso_usuario,
            'status_usuario' => 'ATIVO' // Todo usuário novo entra como ativo
        ]);

        return redirect()->route('admin.usuarios.index')->with('success', 'Novo usuário administrativo cadastrado com sucesso!');
    }
}
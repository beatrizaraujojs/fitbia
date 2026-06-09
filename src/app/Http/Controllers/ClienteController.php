<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClienteController extends Controller
{
    public function index()
    {
        // 🔒 Segurança: Se a pessoa tentar acessar digitando a URL mas não estiver logada, manda de volta pra Home
        if (!Auth::guard('cliente')->check()) {
            return redirect()->route('home');
        }

        // Se estiver logada, abre a página do painel do cliente
        return view('admin.cliente.index');
    }
}
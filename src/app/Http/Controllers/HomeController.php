<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // 1. Busca APENAS as categorias ATIVAS no banco de dados, em ordem alfabética
        $categorias = Categoria::where('ativa_categoria', 'ATIVO')
            ->orderBy('nome_categoria')
            ->get();

        // 2. Abre a página home.blade.php passando as categorias para ela
        return view('site.home.home', compact('categorias'));
    }
}
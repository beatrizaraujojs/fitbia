<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // 1. Busca todas as categorias no banco de dados
        $categorias = Categoria::all();

        // 2. Abre a página home.blade.php passando as categorias para ela
        return view('site.home.home', compact('categorias'));
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CardapioController extends Controller
{
    public function index()
    {
        // Puxa categorias ativas e filtra APENAS os produtos ativos junto com seus adicionais
        $categorias = Categoria::with(['produtos' => function ($query) {
            $query->where('status_produto', 'ATIVO')
                  ->with('gruposAdicionais.adicionais'); // Mantém o carregamento dos adicionais
        }])
        ->where('ativa_categoria', 'ATIVO')
        ->get();

        // Envia os dados para a sua página do cardápio
        return view('site.cardapio.cardapio', compact('categorias'));
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CardapioController extends Controller
{
    public function index()
    {
        // Puxa as categorias ativas, trazendo junto os produtos e os adicionais de cada produto
        $categorias = Categoria::with('produtos.gruposAdicionais.adicionais')
            ->where('ativa_categoria', 'ATIVO')
            ->get();

        // Envia os dados para a sua página do cardápio
        return view('site.cardapio.cardapio', compact('categorias'));
    }
}
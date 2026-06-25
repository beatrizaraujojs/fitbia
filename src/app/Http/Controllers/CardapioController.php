<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CardapioController extends Controller
{
    public function index(Request $request)
    {
        // Pega os filtros da URL
        $busca = $request->input('busca');
        $ordem = $request->input('ordem'); // NOVO: Captura a ordenação escolhida

        $categorias = Categoria::with(['produtos' => function ($query) use ($busca, $ordem) {
            
            // Só produtos ativos com adicionais
            $query->where('status_produto', 'ATIVO')
                  ->with('gruposAdicionais.adicionais');

            // Filtro de Busca (Texto)
            if (!empty($busca)) {
                $query->where(function ($q) use ($busca) {
                    $q->where('nome_produto', 'like', '%' . $busca . '%')
                      ->orWhere('descricao_produto', 'like', '%' . $busca . '%'); 
                });
            }

            // 🌟 NOVO: Lógica de Ordenação
            if ($ordem === 'menor_preco') {
                $query->orderBy('preco_base_produto', 'asc');
            } elseif ($ordem === 'maior_preco') {
                $query->orderBy('preco_base_produto', 'desc');
            } elseif ($ordem === 'az') {
                $query->orderBy('nome_produto', 'asc');
            }
            
        }])
        ->where('ativa_categoria', 'ATIVO')
        ->get();

        // Oculta categorias vazias
        if (!empty($busca) || !empty($ordem)) {
            $categorias = $categorias->filter(function ($categoria) {
                return $categoria->produtos->count() > 0;
            });
        }

        return view('site.cardapio.cardapio', compact('categorias'));
    }
}
<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Produto;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        // Traz também os grupos adicionais e os adicionais de cada grupo
        $query = Produto::with(['categoria', 'gruposAdicionais.adicionais'])
            ->where('status_produto', 'ATIVO')
            ->whereHas('categoria', function ($q) {
                $q->where('ativa_categoria', 'ATIVO');
            });

        $categoriaId = $request->input('categoria_id') ?? $request->input('cat');
        
        if ($categoriaId && $categoriaId !== 'Todos') {
            $query->where('id_categoria_fk', $categoriaId);
        }

        $produtos = $query->orderBy('nome_produto')->get();

        return response()->json([
            'success' => true,
            'data' => $produtos
        ]);
    }

    public function show(string $id): JsonResponse
    {
        // Permite buscar por ID ou slug se preferires, trazido com os grupos e adicionais
        $produto = Produto::with(['categoria', 'gruposAdicionais.adicionais'])
            ->where('status_produto', 'ATIVO')
            ->whereHas('categoria', function ($query) {
                $query->where('ativa_categoria', 'ATIVO');
            })
            ->where(function($q) use ($id) {
                $q->where('id_produto', $id)->orWhere('slug_produto', $id);
            })
            ->firstOrFail();

        return response()->json([
            'success' => true,
            'data' => $produto
        ]);
    }
}
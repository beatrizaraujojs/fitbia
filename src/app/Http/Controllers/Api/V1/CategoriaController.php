<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Produto;
use Illuminate\Http\JsonResponse;

class CategoriaController extends Controller
{
    public function index(): JsonResponse
    {
        $categorias = Categoria::where('ativa_categoria', 'ATIVO')
            ->orderBy('nome_categoria')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $categorias
        ]);
    }

    public function produtos(int $id): JsonResponse
    {
        $categoria = Categoria::where('id_categoria', $id)
            ->where('ativa_categoria', 'ATIVO')
            ->firstOrFail();

        $produtos = Produto::where('id_categoria_fk', $id)
            ->where('status_produto', 'ATIVO')
            ->orderBy('nome_produto')
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'categoria' => $categoria,
                'produtos' => $produtos
            ]
        ]);
    }
}
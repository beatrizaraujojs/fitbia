<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Produto;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    // Listar todos os produtos ativos com categorias e adicionais
    public function index()
    {
        try {
            $produtos = Produto::with([
                'categoria',
                'gruposAdicionais.adicionais'
            ])
            ->whereIn('status_produto', ['ATIVO', 'Ativo', 'ativo'])
            ->get();

            return response()->json([
                'success' => true,
                'data' => $produtos
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao carregar produtos',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Buscar um produto específico com seus adicionais
    public function show($slug)
    {
        try {
            $produto = Produto::with([
                'categoria',
                'gruposAdicionais.adicionais'
            ])
            ->where('slug_produto', $slug)
            ->first();

            if (!$produto) {
                return response()->json([
                    'success' => false,
                    'message' => 'Produto não encontrado'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $produto
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao carregar produto',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

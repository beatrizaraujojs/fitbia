<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Produto;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    public function index()
    {
        try {
            // Busca os produtos aceitando variações de status ativo
            $produtos = Produto::with(['categoria', 'gruposAdicionais'])
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

    public function show($slug)
    {
        $produto = Produto::with(['categoria', 'gruposAdicionais'])
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
    }
}
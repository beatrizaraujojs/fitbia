<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Produto;
use Illuminate\Http\JsonResponse;
<<<<<<< HEAD
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
=======

class ProdutoController extends Controller
{
    public function index(): JsonResponse
    {
        $produtos = Produto::with('categoria')
            ->where('status_produto', 'ATIVO')
            ->whereHas('categoria', function ($query) {
                $query->where('ativa_categoria', 'ATIVO');
            })
            ->orderBy('nome_produto')
            ->get();
>>>>>>> a757d20 (feat: atualizacoes na home e controller)

        return response()->json([
            'success' => true,
            'data' => $produtos
        ]);
    }

<<<<<<< HEAD
    public function show(string $id): JsonResponse
    {
        // Permite buscar por ID ou slug se preferires, trazido com os grupos e adicionais
        $produto = Produto::with(['categoria', 'gruposAdicionais.adicionais'])
=======
    public function show(string $slug): JsonResponse
    {
        $produto = Produto::with('categoria')
            ->where('slug_produto', $slug)
>>>>>>> a757d20 (feat: atualizacoes na home e controller)
            ->where('status_produto', 'ATIVO')
            ->whereHas('categoria', function ($query) {
                $query->where('ativa_categoria', 'ATIVO');
            })
<<<<<<< HEAD
            ->where(function($q) use ($id) {
                $q->where('id_produto', $id)->orWhere('slug_produto', $id);
            })
=======
>>>>>>> a757d20 (feat: atualizacoes na home e controller)
            ->firstOrFail();

        return response()->json([
            'success' => true,
            'data' => $produto
        ]);
    }
}
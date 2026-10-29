<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Favorito;
use Illuminate\Http\Request;

class FavoritoController extends Controller
{
    // Listar os favoritos do cliente logado
    public function index(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([], 401);
        }

        $clienteId = $user->id_cliente ?? $user->id;

        // Carrega o produto e o relacionamento da categoria
        $favoritos = Favorito::where('id_cliente_fk', $clienteId)
            ->with(['produto.categoria'])
            ->get();

        $resultado = $favoritos->map(function ($fav) {
            $prod = $fav->produto;

            if (!$prod) {
                return null;
            }

            return [
                'id' => $prod->id_produto,
                'titulo' => $prod->nome_produto ?? '',
                'descricao' => $prod->descricao_produto ?? '',
                // Adicionado o preço base do produto que vem da tabela tbl_produto
                'preco_base_produto' => $prod->preco_base_produto ?? 0, 
                'id_categoria' => $prod->id_categoria_fk ?? $prod->id_categoria ?? $prod->categoria?->id_categoria,
                'categoria' => $prod->categoria->nome_categoria ?? '',
                'imagem' => $prod->foto_produto ? "http://localhost:8081/fitbia/images/produto/" . $prod->foto_produto : null,
            ];
        })->filter()->values();

        return response()->json($resultado);
    }

    // Alternar favorito
    public function toggle(Request $request)
    {
        try {
            $request->validate([
                'id_produto_fk' => 'required|integer',
            ]);

            $user = $request->user();

            if (!$user) {
                return response()->json(['error' => 'Utilizador não autenticado'], 401);
            }

            $clienteId = $user->id_cliente ?? $user->id ?? null;
            $produtoId = $request->id_produto_fk;

            $favorito = Favorito::where('id_cliente_fk', $clienteId)
                ->where('id_produto_fk', $produtoId)
                ->first();

            if ($favorito) {
                $favorito->delete();
                return response()->json(['status' => 'removido', 'favorito' => false]);
            } else {
                Favorito::create([
                    'id_cliente_fk' => $clienteId,
                    'id_produto_fk' => $produtoId,
                ]);
                return response()->json(['status' => 'adicionado', 'favorito' => true]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage(), 'line' => $e->getLine()], 500);
        }
    }
}
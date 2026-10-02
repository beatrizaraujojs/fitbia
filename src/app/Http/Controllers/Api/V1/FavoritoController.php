<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Favorito;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FavoritoController extends Controller
{
    /**
     * Lista todos os favoritos de um cliente específico.
    
     * Lista todos os favoritos de um cliente específico.
     */
    public function index(int $cliente_id): JsonResponse
    {
        $favoritos = Favorito::where('id_cliente_fk', $cliente_id)->get();

        return response()->json([
            'success' => true,
            'data' => $favoritos
        ]);
    }


    /**
     * Adiciona ou remove um produto dos favoritos (Toggle).
     */
    public function toggle(Request $request): JsonResponse
{
    $request->validate([
        'id_cliente_fk' => 'required|integer',
        'id_produto_fk' => 'required|integer',
    ]);

    $favorito = Favorito::where('id_cliente_fk', $request->id_cliente_fk)
        ->where('id_produto_fk', $request->id_produto_fk)
        ->first();

    if ($favorito) {
        $favorito->delete();
        return response()->json([
            'success' => true,
            'message' => 'Produto removido dos favoritos.',
            'favorito' => false
        ]);
    }

    $novoFavorito = Favorito::create([
        'id_cliente_fk' => $request->id_cliente_fk,
        'id_produto_fk' => $request->id_produto_fk,
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Produto adicionado aos favoritos.',
        'favorito' => true,
        'data' => $novoFavorito
    ], 201);
}
}
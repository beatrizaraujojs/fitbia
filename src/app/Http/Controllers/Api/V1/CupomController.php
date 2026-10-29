<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cupom;

class CupomController extends Controller
{
    public function validarCupom(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string'
        ]);

        // Procura pelo código ignorando maiúsculas/minúsculas e verifica se está ATIVO
        $cupom = Cupom::where('codigo_cupom', trim($request->codigo))
                      ->where('status_cupom', 'ATIVO')
                      ->first();

        if (!$cupom) {
            return response()->json([
                'success' => false,
                'message' => 'Cupom inválido ou expirado.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Cupom aplicado com sucesso!',
            'data' => [
                'codigo' => $cupom->codigo_cupom,
                'desconto' => $cupom->porcentagem_desconto // ex: 5.00 (%)
            ]
        ], 200);
    }
}
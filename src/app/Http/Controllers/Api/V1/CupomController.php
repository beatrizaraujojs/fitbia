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

        // Limpa e padroniza para minúsculas para comparar com segurança no banco
        $codigoInput = strtolower(trim($request->codigo));

        // Procura ignorando diferenças de maiúsculas/minúsculas e valida se está ATIVO
        $cupom = Cupom::whereRaw('LOWER(codigo_cupom) = ?', [$codigoInput])
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
                'desconto' => floatval($cupom->porcentagem_desconto)
            ]
        ], 200);
    }
}
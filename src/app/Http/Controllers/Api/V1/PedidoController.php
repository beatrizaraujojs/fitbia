<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Pedido;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    public function index(int $cliente_id): JsonResponse
    {
        $pedidos = Pedido::where('id_cliente_fk', $cliente_id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $pedidos
        ]);
    }

    public function show(int $id): JsonResponse
    {
        $pedido = Pedido::with('itens')->findOrFail($id); // Assume relação com os itens do pedido

        return response()->json([
            'success' => true,
            'data' => $pedido
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'id_cliente_fk' => 'required|integer',
            'id_endereco_fk' => 'required|integer',
            'forma_pagamento_pedido' => 'required|in:DINHEIRO,PIX,CARTAO_DEBITO,CARTAO_CREDITO,VALE_REFEICAO',
            'valor_total_pedido' => 'required|numeric'
        ]);

        $pedido = Pedido::create([
            'id_cliente_fk' => $request->id_cliente_fk,
            'id_endereco_fk' => $request->id_endereco_fk,
            'id_cupom_fk' => $request->id_cupom_fk ?? null,
            'forma_pagamento_pedido' => $request->forma_pagamento_pedido,
            'status_pedido' => 'PENDENTE',
            'valor_total_pedido' => $request->valor_total_pedido,
            'troco_para_pedido' => $request->troco_para_pedido ?? 0.00,
            'observacoes_pedido' => $request->observacoes_pedido ?? null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pedido criado com sucesso!',
            'data' => $pedido
        ], 201);
    }
}
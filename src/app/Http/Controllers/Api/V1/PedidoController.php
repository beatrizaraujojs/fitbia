<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\ItemPedido;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{
    public function index(Request $request)
    {
        $cliente = $request->user();

        // Busca os pedidos do cliente autenticado carregando os respetivos itens
        $pedidos = Pedido::where('id_cliente', $cliente->id_cliente)
            ->with('itens.produto') // Ajusta o nome do relacionamento conforme o teu model
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $pedidos
        ]);
    }

    public function store(Request $request)
    {
        $cliente = $request->user();

        // Validação correspondente ao payload enviado pelo app
        $request->validate([
            'metodo_pagamento' => 'required|string',
            'total' => 'required|numeric',
            'endereco_id' => 'nullable|exists:tbl_endereco,id_endereco', // Ajusta o nome da tabela/coluna se necessário
            'itens' => 'required|array|min:1',
            'itens.*.id_produto' => 'required|exists:tbl_produto,id_produto',
            'itens.*.quantidade' => 'required|integer|min:1',
            'itens.*.preco_unitario' => 'required|numeric',
            'itens.*.valor_total' => 'required|numeric',
        ]);

        try {
            DB::beginTransaction();

            // Criação do pedido principal
            $pedido = Pedido::create([
                'id_cliente' => $cliente->id_cliente,
                'id_endereco' => $request->endereco_id,
                'metodo_pagamento' => $request->metodo_pagamento,
                'cpf_nota' => $request->cpf_nota,
                'cupom' => $request->cupom,
                'valor_desconto' => $request->valor_desconto ?? 0,
                'valor_total' => $request->total ?? $request->valor_total,
                'status_pedido' => 'Aguardando',
            ]);

            // Registo dos itens do pedido
            foreach ($request->itens as $item) {
                ItemPedido::create([
                    'id_pedido' => $pedido->id_pedido ?? $pedido->id,
                    'id_produto' => $item['id_produto'],
                    'quantidade' => $item['quantidade'],
                    'preco_unitario' => $item['preco_unitario'],
                    'valor_total' => $item['valor_total'],
                    'observacao' => $item['observacao'] ?? '',
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pedido criado com sucesso.',
                'data' => $pedido->load('itens')
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Erro ao criar pedido: ' . $e->getMessage()
            ], 500);
        }
    }
}
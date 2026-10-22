<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pedido; // ou a tabela correspondente

class PedidoController extends Controller
{
    public function store(Request $request)
    {
        $cliente = $request->user(); // Pega o cliente autenticado via Sanctum

        $dados = $request->validate([
            'endereco_id' => 'required|exists:tbl_enderecos_cliente,id',
            'itens' => 'required|array',
            'cupom' => 'nullable|string',
            'total' => 'required|numeric',
        ]);

        // Aqui crias o pedido associando o id_cliente
        // Exemplo:
        /*
        $pedido = Pedido::create([
            'user_id' => $cliente->id_cliente,
            'endereco_id' => $dados['endereco_id'],
            'total_pedido' => $dados['total'],
            'cupom_pedido' => $dados['cupom'],
            'status_pedido' => 'PENDENTE'
        ]);
        */

        return response()->json([
            'success' => true,
            'message' => 'Pedido realizado com sucesso!',
            'data' => []
        ], 201);
    }
}
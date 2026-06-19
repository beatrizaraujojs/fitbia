<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pedido;

class PedidoController extends Controller
{
    // =========================================================
    // LISTAR TODOS OS PEDIDOS
    // =========================================================
    public function index()
    {
        // Puxa os pedidos com os dados do cliente, do mais novo para o mais antigo
        // O paginate(15) cria páginas automaticamente se passarem de 15 pedidos!
        $pedidos = Pedido::with('cliente')->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.dash.pedidos.index', compact('pedidos'));
    }

    // =========================================================
    // ATUALIZAR STATUS DO PEDIDO (Ex: Pendente -> Entregue)
    // =========================================================
    public function atualizarStatus(Request $request, $id)
    {
        $pedido = Pedido::findOrFail($id);
        $pedido->status_pedido = $request->status;
        $pedido->save();

        return redirect()->back()->with('success', 'Status do pedido atualizado com sucesso!');
    }

    // =========================================================
    // VER DETALHES DO PEDIDO
    // =========================================================
    public function detalhes($id)
    {
        $pedido = Pedido::with('cliente')->findOrFail($id);

        // Busca o endereço daquele pedido específico
        $endereco = \App\Models\Endereco::where('id_endereco', $pedido->id_endereco_fk)->first();

        // Busca os itens (marmitas) e os adicionais escolhidos de forma segura
        $itens = \App\Models\ItemPedido::where('id_pedido_fk', $id)->get();
        foreach($itens as $item) {
            $item->produto = \App\Models\Produto::find($item->id_produto_fk);
            
            // Busca adicionais deste item
            $item->adicionais = \App\Models\ItemPedidoAdicional::where('id_item_pedido_fk', $item->id_item_pedido)->get();
            foreach($item->adicionais as $add) {
                 $add->detalhe = \App\Models\Adicional::find($add->id_adicional_fk);
            }
        }

        return view('admin.dash.pedidos.detalhes', compact('pedido', 'itens', 'endereco'));
    }
    
}
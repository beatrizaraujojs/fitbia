<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Importação de todos os modelos que vamos usar neste arquivo
use App\Models\Pedido;
use App\Models\Cliente;
use App\Models\Produto;
use App\Models\ItemPedido;
use App\Models\Endereco;
use App\Models\ItemPedidoAdicional;
use App\Models\Adicional;

class PedidoController extends Controller
{
    // =========================================================
    // 1. LISTAR TODOS OS PEDIDOS (COM FILTROS INTELIGENTES)
    // =========================================================
    public function index(Request $request)
    {
        // Começa a montar a busca, trazendo também os dados do cliente
        $query = Pedido::query()->with('cliente');

        // FILTRO A: Período Rápido (Hoje, Semana, Mês)
        if ($request->filled('periodo')) {
            if ($request->periodo === 'hoje') {
                $query->whereDate('created_at', now()->today());
            } elseif ($request->periodo === 'semana') {
                $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
            } elseif ($request->periodo === 'mes') {
                $query->whereMonth('created_at', now()->month)
                      ->whereYear('created_at', now()->year);
            }
        }

        // FILTRO B: Data Específica de Início
        if ($request->filled('data_inicio')) {
            $query->whereDate('created_at', '>=', $request->data_inicio); 
        }
        
        // FILTRO C: Data Específica de Fim
        if ($request->filled('data_fim')) {
            $query->whereDate('created_at', '<=', $request->data_fim);
        }

        // Finaliza a busca organizando do mais novo para o mais velho (15 por página)
        $pedidos = $query->orderBy('created_at', 'desc')->paginate(15);

        // Caminho exato da sua pasta no VS Code
        return view('admin.dash.pedidos.index', compact('pedidos'));
    }

    // =========================================================
    // 2. ABRIR A TELA DE NOVO PEDIDO MANUAL
    // =========================================================
    public function create()
    {
        // Traz todos os clientes e produtos ativos para alimentar os campos do formulário
        $clientes = Cliente::orderBy('nome_cliente')->get();
        $produtos = Produto::where('status_produto', 'ATIVO')->orderBy('nome_produto')->get();

        // Caminho exato da tela de criação que fizemos
        return view('admin.dash.pedidos.create', compact('clientes', 'produtos'));
    }

    // =========================================================
    // 3. SALVAR O PEDIDO MANUAL NO BANCO DE DADOS
    // =========================================================
   // =========================================================
    // 3. SALVAR O PEDIDO MANUAL NO BANCO DE DADOS
    // =========================================================
    public function store(Request $request)
    {
        $request->validate([
            'id_cliente_fk' => 'required',
            'forma_pagamento' => 'required',
            'produtos' => 'required|array',
            'quantidades' => 'required|array',
        ]);

        try {
            // 1. Percorre os produtos selecionados para calcular o valor total
            $valorTotal = 0;
            foreach ($request->produtos as $index => $idProduto) {
                $produto = Produto::find($idProduto);
                $quantidade = $request->quantidades[$index];
                if ($produto && $quantidade > 0) {
                    $valorTotal += ($produto->preco_base_produto * $quantidade);
                }
            }

            // 🌟 A MÁGICA ACONTECE AQUI: Resolvemos a obrigatoriedade do endereço
            // Procura o primeiro endereço do cliente. Se não existir, cria um endereço de "Retirada"
            $endereco = Endereco::firstOrCreate(
                ['id_cliente_fk' => $request->id_cliente_fk],
                [
                    'cep_endereco' => '00000-000',
                    'rua_endereco' => 'Retirada / Pedido Manual',
                    'numero_endereco' => 'S/N',
                    'complemento_endereco' => '-',
                    'bairro_endereco' => 'Loja',
                    'cidade_endereco' => 'Local'
                ]
            );

            // 2. Cria o registo do Pedido principal
            $pedido = new Pedido();
            $pedido->id_cliente_fk = $request->id_cliente_fk;
            $pedido->forma_pagamento_pedido = $request->forma_pagamento;
            $pedido->observacoes_pedido = $request->observacao ?? 'Pedido lançado manualmente pelo Admin.';
            $pedido->status_pedido = $request->status_pedido;
            $pedido->valor_total_pedido = $valorTotal;
            $pedido->id_endereco_fk = $endereco->id_endereco; // Agora envia o ID garantido!
            $pedido->save();

            // 3. Salva os produtos vinculados a esse pedido
            foreach ($request->produtos as $index => $idProduto) {
                $produto = Produto::find($idProduto);
                $quantidade = $request->quantidades[$index];
                
                if ($produto && $quantidade > 0) {
                    $item = new ItemPedido();
                    $item->id_pedido_fk = $pedido->id_pedido;
                    $item->id_produto_fk = $produto->id_produto;
                    $item->quantidade_item = $quantidade;
                    $item->preco_unitario_item = $produto->preco_base_produto;
                    $item->save();
                }
            }

            return redirect()->route('admin.pedidos')->with('success', 'Pedido manual registado com sucesso!');

        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao salvar o pedido: ' . $e->getMessage())->withInput();
        }
    }

    // =========================================================
    // 4. ATUALIZAR STATUS DO PEDIDO (Ex: Pendente -> Entregue)
    // =========================================================
    public function atualizarStatus(Request $request, $id)
    {
        $pedido = Pedido::findOrFail($id);
        $pedido->status_pedido = $request->status;
        $pedido->save();

        return redirect()->back()->with('success', 'Status do pedido atualizado com sucesso!');
    }

    // =========================================================
    // 5. VER DETALHES DO PEDIDO
    // =========================================================
    public function detalhes($id)
    {
        $pedido = Pedido::with('cliente')->findOrFail($id);

        // Busca o endereço daquele pedido específico
        $endereco = Endereco::where('id_endereco', $pedido->id_endereco_fk)->first();

        // Busca os itens (marmitas) e os adicionais escolhidos de forma segura
        $itens = ItemPedido::where('id_pedido_fk', $id)->get();
        foreach($itens as $item) {
            $item->produto = Produto::find($item->id_produto_fk);
            
            // Busca adicionais deste item
            $item->adicionais = ItemPedidoAdicional::where('id_item_pedido_fk', $item->id_item_pedido)->get();
            foreach($item->adicionais as $add) {
                 $add->detalhe = Adicional::find($add->id_adicional_fk);
            }
        }

        // Caminho exato da sua pasta no VS Code
        return view('admin.dash.pedidos.detalhes', compact('pedido', 'itens', 'endereco'));
    }
}
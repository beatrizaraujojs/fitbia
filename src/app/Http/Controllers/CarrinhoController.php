<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;
use App\Models\Adicional;
use App\Models\Endereco;
use App\Models\Pedido;
use App\Models\ItemPedido;
use App\Models\ItemPedidoAdicional;

class CarrinhoController extends Controller
{
    // =========================================================
    // 1. MOSTRAR A TELA DO CARRINHO
    // =========================================================
    public function index()
    {
        $carrinho = session()->get('carrinho', []);

        $subtotal = 0;
        foreach ($carrinho as $item) {
            $subtotal += $item['preco'] * $item['quantidade'];
        }

        $relacionados = Produto::where('status_produto', 'ATIVO')
                            ->inRandomOrder()
                            ->take(3)
                            ->get();

        if ($relacionados->count() < 3) {
            $idsJaSelecionados = $relacionados->pluck('id_produto')->toArray();
            $quantosFaltam = 3 - $relacionados->count();

            $repescagem = Produto::whereNotIn('id_produto', $idsJaSelecionados)
                                ->inRandomOrder()
                                ->take($quantosFaltam)
                                ->get();

            $relacionados = $relacionados->merge($repescagem);
        }

        return view('site.checkout.checkout', compact('carrinho', 'subtotal', 'relacionados'));
    }

    // =========================================================
    // 2. ADICIONAR ITEM AO CARRINHO
    // =========================================================
    public function adicionar(Request $request)
    {
        $produto = Produto::findOrFail($request->id_produto);
        $carrinho = session()->get('carrinho', []);

        $adicionaisEscolhidos = [];
        $precoTotalAdicionais = 0;

        if ($request->has('adicionais')) {
            foreach ($request->adicionais as $idAdicional => $quantidade) {
                if ($quantidade > 0) {
                    $adicionalObj = Adicional::find($idAdicional);
                    if ($adicionalObj) {
                        $adicionaisEscolhidos[] = [
                            'id_adicional' => $adicionalObj->id_adicional,
                            'nome'         => $adicionalObj->nome_adicional,
                            'preco'        => $adicionalObj->preco_adicional,
                            'quantidade'   => $quantidade
                        ];
                        $precoTotalAdicionais += ($adicionalObj->preco_adicional * $quantidade);
                    }
                }
            }
        }

        $cartKey = $produto->id_produto . '_' . md5(json_encode($adicionaisEscolhidos) . $request->observacao);

        if (isset($carrinho[$cartKey])) {
            $carrinho[$cartKey]['quantidade']++;
        } else {
            $carrinho[$cartKey] = [
                'id_produto' => $produto->id_produto,
                'nome'       => $produto->nome_produto,
                'descricao'  => $produto->descricao_produto,
                'preco'      => $produto->preco_base_produto + $precoTotalAdicionais,
                'preco_base' => $produto->preco_base_produto,
                'quantidade' => 1,
                'observacao' => $request->observacao,
                'foto'       => $produto->foto_produto,
                'adicionais' => $adicionaisEscolhidos 
            ];
        }

        session()->put('carrinho', $carrinho);

        return redirect()->route('site.carrinho')->with('success', 'Produto adicionado ao carrinho!');
    }

    // =========================================================
    // 3. ATUALIZAR QUANTIDADE
    // =========================================================
    public function atualizar(Request $request, $id)
    {
        $carrinho = session()->get('carrinho');

        if (isset($carrinho[$id])) {
            if ($request->acao == 'aumentar') {
                $carrinho[$id]['quantidade']++;
            } elseif ($request->acao == 'diminuir' && $carrinho[$id]['quantidade'] > 1) {
                $carrinho[$id]['quantidade']--;
            }
            session()->put('carrinho', $carrinho);
        }

        return redirect()->back(); 
    }

    // =========================================================
    // 4. REMOVER ITEM
    // =========================================================
    public function remover($id)
    {
        $carrinho = session()->get('carrinho');

        if (isset($carrinho[$id])) {
            unset($carrinho[$id]);
            session()->put('carrinho', $carrinho);
        }

        return redirect()->back()->with('success', 'Produto removido com sucesso!');
    }

    // =========================================================
    // 5. FINALIZAR PEDIDO (Direto para o WhatsApp)
    // =========================================================
   public function finalizarPedido(Request $request)
{
    // 1. Verifica se o carrinho existe e não está vazio
    $carrinho = session()->get('carrinho', []);
    if (empty($carrinho)) {
        return redirect()->back()->with('error', 'Seu carrinho está vazio!');
    }

    // 2. Se o cliente precisar estar logado para finalizar
    if (!auth()->check()) {
        return redirect()->back()->with('error', 'Você precisa estar logado para finalizar o pedido.');
    }

    try {
        // 3. Criar o registro do Pedido principal
        $pedido = new Pedido();
        
        // Ajuste os nomes dessas colunas de acordo com sua migration/banco:
        $pedido->id_cliente_fk = auth()->user()->id_cliente; 
        $pedido->id_endereco_fk = $request->input('id_endereco'); // name do <select> ou <input> no HTML
        $pedido->forma_pagamento_pedido = $request->input('forma_pagamento'); // name do radio/select no HTML
        $pedido->observacoes_pedido = $request->input('observacao');
        $pedido->status_pedido = 'PENDENTE';
        
        // Calcula o valor total direto do carrinho salvo na sessão
        $totalPedido = 0;
        foreach ($carrinho as $item) {
            $subtotalItem = $item['preco'] * $item['quantidade'];
            if (isset($item['adicionais'])) {
                foreach ($item['adicionais'] as $add) {
                    $subtotalItem += $add['preco'] * $item['quantidade'];
                }
            }
            $totalPedido += $subtotalItem;
        }
        $pedido->valor_total_pedido = $totalPedido;
        
        // Salva o pedido principal para gerar o id_pedido
        $pedido->save();

        // 4. Salvar os itens vinculados a esse pedido
        foreach ($carrinho as $idProduto => $item) {
            $itemPedido = new ItemPedido();
            $itemPedido->id_pedido_fk = $pedido->id_pedido; // Pega o ID gerado acima
            $itemPedido->id_produto_fk = $idProduto;
            $itemPedido->quantidade_item = $item['quantidade'];
            $itemPedido->preco_unitario_item = $item['preco'];
            $itemPedido->save();

            // Se o item tiver adicionais salvos na sessão, grava na tabela de adicionais
            if (isset($item['adicionais']) && count($item['adicionais']) > 0) {
                foreach ($item['adicionais'] as $idAdd => $add) {
                    $itemAdd = new ItemPedidoAdicional();
                    $itemAdd->id_item_pedido_fk = $itemPedido->id_item_pedido; // ID do item gerado acima
                    $itemAdd->id_adicional_fk = $idAdd;
                    $itemAdd->preco_cobrado_add = $add['preco'];
                    $itemAdd->save();
                }
            }
        }

        // 5. Sucesso! Limpa o carrinho da sessão e redireciona
        session()->forget('carrinho');

        return redirect()->route('site.checkout.pedidos')->with('success', 'Pedido realizado com sucesso!');

    } catch (\Exception $e) {
        // Se der qualquer erro no banco, ele vai parar aqui e te mostrar o erro exato
        return redirect()->back()->with('error', 'Erro ao salvar pedido: ' . $e->getMessage())->withInput();
    }
    }
}
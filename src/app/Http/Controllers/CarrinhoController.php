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
    // 5. FINALIZAR PEDIDO (Redireciona direto para o Whats da Loja)
    // =========================================================
    public function finalizarPedido(Request $request)
    {
        $carrinho = session()->get('carrinho', []);
        if (empty($carrinho)) {
            return redirect()->back()->with('error', 'Seu carrinho está vazio!');
        }

        if (!auth()->check()) {
            return redirect()->back()->with('error', 'Você precisa estar logado para finalizar o pedido.');
        }

        $formaSelecionada = $request->input('pagamento') ?? $request->input('forma_pagamento');

        if (!$formaSelecionada || $formaSelecionada === 'delivery') {
            return redirect()->back()->with('error', 'Por favor, selecione uma forma de pagamento válida na Etapa 2.');
        }

        $formaBanco = 'DINHEIRO';
        switch (strtolower($formaSelecionada)) {
            case 'pix': $formaBanco = 'PIX'; break;
            case 'debito': case 'cartao': case 'cartao_debito': $formaBanco = 'CARTAO_DEBITO'; break;
            case 'credito': case 'cartao_credito': $formaBanco = 'CARTAO_CREDITO'; break;
            case 'dinheiro': $formaBanco = 'DINHEIRO'; break;
        }

        try {
            // PROCURA OU CRIA O ENDEREÇO EM TEMPO REAL
            $endereco = Endereco::where('id_cliente_fk', auth()->user()->id_cliente)->first();

            if ($request->filled('endereco') && $request->filled('numero')) {
                if (!$endereco) {
                    $endereco = new Endereco();
                    $endereco->id_cliente_fk = auth()->user()->id_cliente;
                }
                
                $endereco->rua_endereco = $request->endereco;
                $endereco->numero_endereco = $request->numero;
                $endereco->bairro_endereco = $request->bairro;
                $endereco->cep_endereco = $request->cep;
                $endereco->complemento_endereco = $request->complemento;
                $endereco->save();
            }

            if (!$endereco) {
                return redirect()->back()->with('error', 'Por favor, preencha o seu endereço de entrega na Etapa 1 para prosseguir.');
            }

            // Monta o endereço legível em texto
            $textoEndereco = "{$endereco->rua_endereco}, Nº {$endereco->numero_endereco} - {$endereco->bairro_endereco}";
            if (!empty($endereco->complemento_endereco)) {
                $textoEndereco .= " ({$endereco->complemento_endereco})";
            }

            // SALVA O REGISTRO DO PEDIDO NO BANCO
            $pedido = new Pedido();
            $pedido->id_cliente_fk = auth()->user()->id_cliente; 
            $pedido->id_endereco_fk = $endereco->id_endereco; 
            $pedido->forma_pagamento_pedido = $formaBanco; 
            $pedido->observacoes_pedido = $request->observacao;
            $pedido->status_pedido = 'PENDENTE';
            
            $totalPedido = 0;
            foreach ($carrinho as $item) {
                $totalPedido += $item['preco'] * $item['quantidade'];
            }
            $pedido->valor_total_pedido = $totalPedido;
            $pedido->save();

            // VINCULA OS ITENS E SUB-ADICIONAIS
            foreach ($carrinho as $idProduto => $item) {
                $itemPedido = new ItemPedido();
                $itemPedido->id_pedido_fk = $pedido->id_pedido; 
                $itemPedido->id_produto_fk = $item['id_produto'];
                $itemPedido->quantidade_item = $item['quantidade'];
                $itemPedido->preco_unitario_item = $item['preco'];
                $itemPedido->save();

                if (isset($item['adicionais']) && count($item['adicionais']) > 0) {
                    foreach ($item['adicionais'] as $add) {
                        $itemAdd = new ItemPedidoAdicional();
                        $itemAdd->id_item_pedido_fk = $itemPedido->id_item_pedido; 
                        $itemAdd->id_adicional_fk = $add['id_adicional'];
                        $itemAdd->preco_cobrado_add = $add['preco'];
                        $itemAdd->save();
                    }
                }
            }

            // Limpa o carrinho da sessão
            session()->forget('carrinho');

            // 🌟 REDIRECIONAMENTO DIRETO PARA O NÚMERO DA BIA (11981826719)
            if ($formaBanco === 'PIX') {
                $telefoneLoja = '5511981826719'; // Número da Loja recebendo o pedido
                $numeroFormatado = str_pad($pedido->id_pedido, 4, '0', STR_PAD_LEFT);
                $valorFormatado = number_format($totalPedido, 2, ',', '.');
                $nomeCliente = explode(' ', auth()->user()->nome_cliente)[0];
                
                // Texto pré-definido para o cliente disparar direto para a Bia
                $texto = "Olá Fit Bia! Meu nome é *{$nomeCliente}*.\n\n";
                $texto .= "Acabei de fechar o pedido *#{$numeroFormatado}* no site.\n";
                $texto .= "O valor total deu *R$ {$valorFormatado}* e eu escolhi pagar via *PIX*.\n\n";
                $texto .= "O meu endereço de entrega é:\n*{$textoEndereco}*\n\n";
                $texto .= "Pode me enviar a chave PIX para eu fazer o pagamento, por favor?";

                $urlZap = "https://api.whatsapp.com/send?phone={$telefoneLoja}&text=" . urlencode($texto);
                return redirect()->away($urlZap);
            }

            // Se for Dinheiro ou Cartão na entrega, manda o cliente para o painel de histórico dele
            return redirect()->route('site.painel')->with('success', 'Pedido realizado com sucesso! Acompanhe o status no seu painel.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao salvar o pedido: ' . $e->getMessage())->withInput();
        }
    }
}
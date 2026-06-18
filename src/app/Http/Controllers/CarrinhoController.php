<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;
use Illuminate\Support\Facades\DB;
use App\Models\Adicional; // Certifique se o nome do seu Model de adicionais é esse!

class CarrinhoController extends Controller
{
    // 1. Mostrar a tela do Carrinho// 1. Mostrar a tela do Carrinho
   // 1. Mostrar a tela do Carrinho
  // 1. Mostrar a tela do Carrinho com Garantia de Sugestões
    public function index()
    {
        $carrinho = session()->get('carrinho', []);

        $subtotal = 0;
        foreach ($carrinho as $item) {
            $subtotal += $item['preco'] * $item['quantidade'];
        }

        // 1. Tentativa principal: Puxa produtos ATIVOS aleatórios
        $relacionados = \App\Models\Produto::where('status_produto', 'ATIVO')
                            ->inRandomOrder()
                            ->take(3)
                            ->get();

        // 2. Lógica de Repescagem: Se não encontrou 3 ativos, completa com outros do banco
        if ($relacionados->count() < 3) {
            // Descobre quais IDs já foram pegos para não repetir
            $idsJaSelecionados = $relacionados->pluck('id_produto')->toArray();
            
            // Calcula quantos faltam para fechar 3
            $quantosFaltam = 3 - $relacionados->count();

            // Puxa os que faltam ignorando os que já pegamos
            $repescagem = \App\Models\Produto::whereNotIn('id_produto', $idsJaSelecionados)
                                ->inRandomOrder()
                                ->take($quantosFaltam)
                                ->get();

            // Junta os dois resultados em uma lista só
            $relacionados = $relacionados->merge($repescagem);
        }

        // Passa a lista garantida de 3 itens para a sua view original
        return view('site.checkout.checkout', compact('carrinho', 'subtotal', 'relacionados'));
    }

    // 2. Adicionar item ao Carrinho vindo do Modal com Adicionais
    public function adicionar(Request $request)
    {
        $produto = Produto::findOrFail($request->id_produto);
        $carrinho = session()->get('carrinho', []);

        $adicionaisEscolhidos = [];
        $precoTotalAdicionais = 0;

        // Se o formulário enviou a lista de adicionais
        if ($request->has('adicionais')) {
            foreach ($request->adicionais as $idAdicional => $quantidade) {
                if ($quantidade > 0) {
                    // Busca o adicional no banco para validar o nome e preço reais
                    $adicionalObj = Adicional::find($idAdicional);
                    if ($adicionalObj) {
                        $adicionaisEscolhidos[] = [
                            'id_adicional' => $adicionalObj->id_adicional,
                            'nome'         => $adicionalObj->nome_adicional,
                            'preco'        => $adicionalObj->preco_adicional,
                            'quantidade'   => $quantidade
                        ];
                        // Soma o preço (Ex: 2 unidades de Patinho de R$ 2,50 = R$ 5,00)
                        $precoTotalAdicionais += ($adicionalObj->preco_adicional * $quantidade);
                    }
                }
            }
        }

        // Criamos uma chave única combinando o ID do produto, os adicionais e a observação.
        // Isso permite que o cliente adicione o MESMO produto com acompanhamentos diferentes no carrinho!
        $cartKey = $produto->id_produto . '_' . md5(json_encode($adicionaisEscolhidos) . $request->observacao);

        // Se esse prato idêntico já estiver no carrinho, só aumenta a quantidade geral dele
        if (isset($carrinho[$cartKey])) {
            $carrinho[$cartKey]['quantidade']++;
        } else {
            // Se for novo, monta o prato com o preço base + a soma dos adicionais escolhidos
            $carrinho[$cartKey] = [
                'id_produto' => $produto->id_produto,
                'nome'       => $produto->nome_produto,
                'descricao'  => $produto->descricao_produto,
                'preco'      => $produto->preco_base_produto + $precoTotalAdicionais,
                'preco_base' => $produto->preco_base_produto,
                'quantidade' => 1,
                'observacao' => $request->observacao,
                'foto'       => $produto->foto_produto,
                'adicionais' => $adicionaisEscolhidos // Lista de adicionais salvos dentro do item
            ];
        }

        session()->put('carrinho', $carrinho);

        return redirect()->route('site.carrinho')->with('success', 'Produto adicionado ao carrinho!');
    }
    // Atualizar quantidade (+ ou -) direto no carrinho
    public function atualizar(Request $request, $id)
    {
        $carrinho = session()->get('carrinho');

        if (isset($carrinho[$id])) {
            if ($request->acao == 'aumentar') {
                $carrinho[$id]['quantidade']++;
            } elseif ($request->acao == 'diminuir' && $carrinho[$id]['quantidade'] > 1) {
                // Só diminui se for maior que 1. Se for 1 e ele quiser tirar, ele usa o botão de lixeira.
                $carrinho[$id]['quantidade']--;
            }
            session()->put('carrinho', $carrinho);
        }

        return redirect()->back(); // Recarrega a página atualizando os valores
    }
    // 3. Remover item do Carrinho
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
    // FINALIZAR PEDIDO (Salva Cliente, Endereço, Pedido e Itens)
    // =========================================================
    public function finalizarPedido(Request $request)
    {
        $carrinho = session()->get('carrinho');

        // Se o carrinho estiver vazio por algum motivo, bloqueia a compra
        if (!$carrinho || count($carrinho) == 0) {
            return redirect()->back()->with('error', 'Seu carrinho está vazio!');
        }

        // 1. Calcula o total do pedido varrendo a sessão
        $totalPedido = 0;
        foreach ($carrinho as $item) {
            $totalPedido += $item['preco'] * $item['quantidade'];
        }

        // Inicia uma Transação de Banco de Dados (Se algo falhar no meio, ele desfaz tudo)
        DB::beginTransaction();

        try {
            // =========================================================
            // PASSO 1: CLIENTE (tbl_cliente)
            // Verifica se já existe um cliente com esse WhatsApp
            // =========================================================
            $clienteExistente = DB::table('tbl_cliente')
                                  ->where('whatsapp_cliente', $request->whatsapp)
                                  ->first();

            if ($clienteExistente) {
                // Se já comprou antes, pega o ID dele
                $idCliente = $clienteExistente->id_cliente;
            } else {
                // Se é cliente novo, cadastra na tbl_cliente
                $idCliente = DB::table('tbl_cliente')->insertGetId([
                    'nome_cliente'     => $request->nome_cliente,
                    'whatsapp_cliente' => $request->whatsapp,
                    'status_cliente'   => 'ATIVO',
                    'created_at'       => now(),
                    'updated_at'       => now(),
                    // Nota: CPF, E-mail e Senha ficarão nulos/vazios já que é uma compra rápida (Guest)
                ]);
            }

            // =========================================================
            // PASSO 2: ENDEREÇO (tbl_endereco)
            // Salva o endereço vinculado ao cliente
            // =========================================================
            $idEndereco = DB::table('tbl_endereco')->insertGetId([
                'id_cliente_fk'        => $idCliente,
                'cep_endereco'         => $request->cep,
                'rua_endereco'         => $request->endereco,
                'numero_endereco'      => $request->numero,
                'bairro_endereco'      => $request->bairro,
                'complemento_endereco' => $request->complemento ?? '',
                'cidade_endereco'      => 'São Paulo', // Fixo, conforme o formulário
                'created_at'           => now(),
                'updated_at'           => now(),
            ]);

            // =========================================================
            // PASSO 3: O PEDIDO (tbl_pedido)
            // =========================================================
            $idPedido = DB::table('tbl_pedido')->insertGetId([
                'id_cliente_fk'          => $idCliente,
                'id_endereco_fk'         => $idEndereco,
                'forma_pagamento_pedido' => $request->pagamento ?? 'PIX',
                'status_pedido'          => 'PENDENTE',
                'valor_total_pedido'     => $totalPedido,
                'observacoes_pedido'     => $request->observacoes ?? '',
                'created_at'             => now(),
                'updated_at'             => now(),
            ]);

            // =========================================================
            // PASSO 4: ITENS DO PEDIDO E ADICIONAIS
            // =========================================================
            foreach ($carrinho as $item) {
                // Salva o prato principal na tbl_item_pedido
                $idItemPedido = DB::table('tbl_item_pedido')->insertGetId([
                    'id_pedido_fk'        => $idPedido,
                    'id_produto_fk'       => $item['id_produto'],
                    'quantidade_item'     => $item['quantidade'],
                    'preco_unitario_item' => $item['preco_base'], 
                    'created_at'          => now(),
                    'updated_at'          => now(),
                ]);

                // Verifica se esse prato tem adicionais escolhidos (tbl_item_pedido_adicional)
                if (isset($item['adicionais']) && count($item['adicionais']) > 0) {
                    foreach ($item['adicionais'] as $add) {
                        DB::table('tbl_item_pedido_adicional')->insert([
                            'id_item_pedido_fk' => $idItemPedido,
                            'id_adicional_fk'   => $add['id_adicional'],
                            'preco_cobrado_add' => $add['preco'], 
                            'created_at'        => now(),
                            'updated_at'        => now(),
                        ]);
                    }
                }
            }

            // Se o código chegou até aqui sem nenhum erro, SALVA DE VERDADE no banco!
            DB::commit();

            // Limpa o carrinho
            session()->forget('carrinho');

            // Redireciona para a Home com mensagem de sucesso
            return redirect()->route('site.home')->with('success', 'Pedido #' . $idPedido . ' realizado com sucesso! Em breve entraremos em contato.');

        } catch (\Exception $e) {
            // Se der erro (ex: faltou alguma coluna no banco), desfaz tudo e avisa
            DB::rollBack();
            return redirect()->back()->with('error', 'Erro ao finalizar pedido: ' . $e->getMessage());
        }
    }
    
}

@extends('layout.site')

@push('css')
    <link rel="stylesheet" href="{{ asset('fitbia/css/checkout.css') }}">
    <link rel="stylesheet" href="{{ asset('fitbia/css/pedidos.css') }}">
@endpush

@section('content')

{{-- LÓGICA PHP: Puxar os dados do cliente e endereço se ele estiver logado --}}
@php
    $enderecoSalvo = null;
    $nomeUsuario = '';
    $whatsappUsuario = '';

    if(auth()->check()){
        $nomeUsuario = auth()->user()->nome_cliente;
        $whatsappUsuario = auth()->user()->whatsapp_cliente;
        // Busca o endereço ligado ao cliente
        $enderecoSalvo = \App\Models\Endereco::where('id_cliente_fk', auth()->user()->id_cliente)->first();
    }
@endphp

<div class="container pedidos-container">
    
    {{-- CABEÇALHO --}}
    <div class="pedidos-header">
        <div class="header-titulos">
            <h2>Meu Carrinho / Checkout</h2>
            <p>Revise suas marmitas e finalize seu pedido.</p>
        </div>
        <i class="ph ph-tote header-icone-sacola"></i> 
    </div>

    {{-- POP-UP DE SUCESSO INTELIGENTE (ADICIONAR/REMOVER) --}}
    @if(session('success'))
        @php
            $mensagem = session('success');
            $ehRemocao = str_contains(strtolower($mensagem), 'removid');
            $titulo = $ehRemocao ? 'Item Removido' : 'Adicionado ao carrinho';
            $cor = $ehRemocao ? '#ef4444' : '#059669'; 
            $icone = $ehRemocao ? 'ph-trash' : 'ph-check-circle';
        @endphp

        <div id="toast-sucesso" style="position: fixed; top: 20px; right: 20px; background: white; border-radius: 10px; box-shadow: 0 10px 25px rgba(0,0,0,0.15); display: flex; align-items: center; gap: 15px; padding: 15px 25px; z-index: 10000; border-left: 5px solid {{ $cor }}; transform: translateX(120%); transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);">
            <i class="ph {{ $icone }}" style="color: {{ $cor }}; font-size: 28px;"></i>
            <div>
                <h4 style="margin: 0; color: #1f2937; font-size: 16px;">{{ $titulo }}</h4>
                <p style="margin: 2px 0 0 0; color: #6b7280; font-size: 13px;">{{ $mensagem }}</p>
            </div>
            <button onclick="document.getElementById('toast-sucesso').style.display='none'" style="background: none; border: none; cursor: pointer; color: #9ca3af; margin-left: 15px; font-size: 20px;">
                <i class="ph ph-x"></i>
            </button>
        </div>
    @endif


    {{-- ==========================================
         FASE 1: CARRINHO E SUGESTÕES 
         ========================================== --}}
    <div id="fase-carrinho">
        <div class="pedidos-layout">
            
            {{-- LISTA DE ITENS DO CARRINHO --}}
            <div class="pedidos-lista">
                @php $subtotal = 0; @endphp
                
                @if(session('carrinho') && count(session('carrinho')) > 0)
                    @foreach(session('carrinho') as $id_sessao => $item)
                        @php $subtotal += $item['preco'] * $item['quantidade']; @endphp
                        
                        <div class="item-pedido">
                            <div class="item-img-container" onclick="toggleDetalhes('{{ $id_sessao }}')" title="Clique para ver detalhes" style="cursor: pointer;">
                                @if(isset($item['foto']) && $item['foto'])
                                    <img src="{{ asset('fitbia/images/produto/' . $item['foto']) }}" alt="{{ $item['nome'] }}" class="item-img">
                                @else
                                    <img src="https://via.placeholder.com/100" alt="Sem foto" class="item-img">
                                @endif
                            </div>
                            
                            <div class="item-info">
                                <h3 onclick="toggleDetalhes('{{ $id_sessao }}')" style="cursor: pointer; display: flex; align-items: center; gap: 5px; margin: 0 0 5px 0;">
                                    {{ $item['nome'] }} 
                                    <i class="ph ph-caret-down" style="font-size: 14px; color: #9ca3af;"></i>
                                </h3>
                                <p class="item-preco">R$ {{ number_format($item['preco'], 2, ',', '.') }}</p>

                                <div id="detalhes-{{ $id_sessao }}" style="display: none; margin-top: 10px; padding-top: 10px; border-top: 1px dashed #e5e7eb;">
                                    <p class="item-desc" style="margin-bottom: 8px; color: #6b7280;">{{ $item['descricao'] }}</p>
                                    @if(isset($item['adicionais']) && count($item['adicionais']) > 0)
                                        <p class="item-desc" style="color: #059669; font-size: 12px; margin-bottom: 4px;">
                                            <strong>Adicionais:</strong><br>
                                            @foreach($item['adicionais'] as $add)
                                                - {{ $add['quantidade'] }}x {{ $add['nome'] }}<br>
                                            @endforeach
                                        </p>
                                    @endif
                                    @if(isset($item['observacao']) && $item['observacao'] != '')
                                        <p class="item-desc" style="color: #d97706; font-style: italic; font-size: 12px;">
                                            <strong>Obs:</strong> {{ $item['observacao'] }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="item-acoes" style="display: flex; flex-direction: column; align-items: flex-end; gap: 15px;">
                                <div style="display: flex; align-items: center; border: 1px solid #e5e7eb; border-radius: 4px; overflow: hidden; background: #fff;">
                                    <form action="{{ route('carrinho.atualizar', $id_sessao) }}" method="POST" style="margin: 0;">
                                        @csrf
                                        <input type="hidden" name="acao" value="diminuir">
                                        <button type="submit" style="background: transparent; border: none; padding: 6px 12px; font-size: 18px; cursor: pointer; color: #374151;">−</button>
                                    </form>
                                    <span style="padding: 6px 15px; font-size: 14px; font-weight: bold; color: #1f2937; border-left: 1px solid #e5e7eb; border-right: 1px solid #e5e7eb; min-width: 15px; text-align: center;">
                                        {{ $item['quantidade'] }}
                                    </span>
                                    <form action="{{ route('carrinho.atualizar', $id_sessao) }}" method="POST" style="margin: 0;">
                                        @csrf
                                        <input type="hidden" name="acao" value="aumentar">
                                        <button type="submit" style="background: transparent; border: none; padding: 6px 12px; font-size: 18px; cursor: pointer; color: #374151;">+</button>
                                    </form>
                                </div>
                                <form action="{{ route('carrinho.remover', $id_sessao) }}" method="POST" style="margin: 0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-remover-destaque" title="Remover item">
                                        <i class="ph ph-trash"></i> Remover
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div style="text-align: center; padding: 40px; color: #6b7280;">
                        <i class="ph ph-shopping-cart" style="font-size: 48px; margin-bottom: 10px;"></i>
                        <p>Seu carrinho está vazio.</p>
                    </div>
                @endif
            </div>

            {{-- RESUMO DO CARRINHO (Botão chama o JavaScript para esconder esta tela e abrir os formulários) --}}
            <div class="pedidos-resumo">
                <h3>Resumo do Pedido</h3>
                <div class="resumo-linha">
                    <span>Subtotal</span>
                    <span>R$ {{ isset($subtotal) ? number_format($subtotal, 2, ',', '.') : '0,00' }}</span>
                </div>
                <div class="resumo-linha">
                    <span>Taxa de Entrega</span>
                    <span class="destaque-verde">A calcular</span>
                </div>
                <hr class="divisor">
                <div class="resumo-linha total">
                    <span>Total</span>
                    <span>R$ {{ isset($subtotal) ? number_format($subtotal, 2, ',', '.') : '0,00' }}</span>
                </div>
                
                @if(session('carrinho') && count(session('carrinho')) > 0)
                    <button type="button" class="btn-avancar" onclick="iniciarCheckout()">Avançar para entrega</button>
                @else
                    <button class="btn-avancar" disabled style="opacity: 0.5; cursor: not-allowed;">Avançar para entrega</button>
                @endif
            </div>
        </div>

        {{-- PRODUTOS RELACIONADOS --}}
        <div class="relacionados-section">
            <h3>Complete sua refeição</h3>
            <p>Que tal adicionar uma bebida ou sobremesa fit?</p>
            
            <div class="relacionados-grid">
                {{-- ITEM 1 --}}
                <div class="card-relacionado">
                    <img src="https://via.placeholder.com/60" alt="Suco Detox">
                    <div class="relacionado-info">
                        <h4>Suco Verde Detox</h4>
                        <span class="relacionado-preco">R$ 12,00</span>
                    </div>
                    <button class="btn-add-mini" title="Adicionar" onclick="adicionarFixo(1)">
                        <i class="ph ph-plus"></i>
                    </button>
                </div>
                {{-- ITEM 2 --}}
                <div class="card-relacionado">
                    <img src="https://via.placeholder.com/60" alt="Brownie Fit">
                    <div class="relacionado-info">
                        <h4>Brownie Fit Cacau</h4>
                        <span class="relacionado-preco">R$ 15,00</span>
                    </div>
                    <button class="btn-add-mini" title="Adicionar" onclick="adicionarFixo(2)">
                        <i class="ph ph-plus"></i>
                    </button>
                </div>
                {{-- ITEM 3 --}}
                <div class="card-relacionado">
                    <img src="https://via.placeholder.com/60" alt="Salada de Frutas">
                    <div class="relacionado-info">
                        <h4>Salada de Frutas</h4>
                        <span class="relacionado-preco">R$ 10,00</span>
                    </div>
                    <button class="btn-add-mini" title="Adicionar" onclick="adicionarFixo(3)">
                        <i class="ph ph-plus"></i>
                    </button>
                </div>
            </div>
        </div>

        {{-- FORMULÁRIO OCULTO PARA ADD RELACIONADOS --}}
        <form id="form-add-fixo" action="{{ route('carrinho.adicionar') }}" method="POST" style="display: none;">
            @csrf
            <input type="hidden" name="id_produto" id="id-produto-fixo">
        </form>
    </div>
    {{-- FIM FASE 1 --}}


    {{-- ==========================================
         FASE 2: FORMULÁRIO DE CHECKOUT OCULTO 
         ========================================== --}}
   <form id="fase-checkout" action="{{ route('pedido.salvar') }}" method="POST" style="display: none;" novalidate>
        @csrf

        <div class="checkout-layout">
            <div class="checkout-formularios">
                
                {{-- ETAPA 1 (Com os valores do banco embutidos) --}}
                <div class="checkout-secao etapa-checkout ativo" id="conteudo-etapa-1">
                    <h3><i class="ph ph-map-pin"></i> 1. Onde vamos entregar?</h3>
                    <div class="form-grid">
                        <div class="input-group">
                            <label for="cep">CEP</label>
                            <input type="text" id="cep" name="cep" placeholder="Ex: 01001-000" maxlength="9" value="{{ old('cep', $enderecoSalvo->cep_endereco ?? '') }}" required />
                        </div>
                        <div class="input-group">
                            <label for="endereco_sp">Endereço em São Paulo (Rua)</label>
                            <input type="text" id="endereco_sp" name="endereco" placeholder="Rua, Avenida, Alameda..." value="{{ old('endereco', $enderecoSalvo->rua_endereco ?? '') }}" required />
                        </div>
                        <div class="input-group">
                            <label for="numero_casa">Número</label>
                            <input type="text" id="numero_casa" name="numero" placeholder="Número da casa ou prédio" value="{{ old('numero', $enderecoSalvo->numero_endereco ?? '') }}" required />
                        </div>
                        <div class="input-group">
                            <label for="bairro_cond">Bairro / Condomínio</label>
                            <input type="text" id="bairro_cond" name="bairro" placeholder="Seu bairro ou condomínio" value="{{ old('bairro', $enderecoSalvo->bairro_endereco ?? '') }}" required />
                        </div>
                        <div class="input-group">
                            <label for="apto_ref">APTO / Referência / Complemento</label>
                            <input type="text" id="apto_ref" name="complemento" placeholder="Apto, bloco, ponto de referência..." value="{{ old('complemento', $enderecoSalvo->complemento_endereco ?? '') }}" />
                        </div>
                    </div>
                    <div class="botoes-etapa">
                        <button type="button" class="btn-proximo" onclick="irParaEtapa(2)">
                            Avançar para Entrega <i class="ph ph-arrow-right"></i>
                        </button>
                    </div>
                </div>

                {{-- ETAPA 2 --}}
                <div class="checkout-secao etapa-checkout" id="conteudo-etapa-2">
                    <h3><i class="ph ph-moped"></i> 2. Tipo de Entrega e Pagamento</h3>
                    <h4 class="subtitulo-checkout">Tipo de Pedido</h4>
                    <div class="radio-group-horizontal">
                        <label class="radio-customizado">
                            <input type="radio" name="tipo_pedido" value="delivery" checked />
                            <i class="ph ph-motorcycle"></i> Delivery
                        </label>
                    </div>

                    <h4 class="subtitulo-checkout" style="margin-top: 20px">Forma de Pagamento</h4>
                    <div class="opcoes-pagamento">
                        <label class="opcao-card">
                            <input type="radio" name="pagamento" value="dinheiro" />
                            <div class="opcao-conteudo"><span>Dinheiro</span></div>
                        </label>
                        <label class="opcao-card">
                            <input type="radio" name="pagamento" value="pix" checked />
                            <div class="opcao-conteudo"><span>PIX (Chave exibida após o envio)</span></div>
                        </label>
                        <label class="opcao-card">
                            <input type="radio" name="pagamento" value="debito" />
                            <div class="opcao-conteudo"><span>Cartão de Débito - Maquininha</span></div>
                        </label>
                        <div class="step" id="step-2">
                            <label class="opcao-card">
                                <input type="radio" name="pagamento" value="credito" />
                                <div class="opcao-conteudo"><span>Cartão de Crédito - Maquininha</span></div>
                            </label>
                        </div>
                        <div class="botoes-etapa">
                            <button type="button" class="btn-voltar" onclick="irParaEtapa(1)">
                                <i class="ph ph-arrow-left"></i> Voltar
                            </button>
                            <button type="button" class="btn-proximo" onclick="irParaEtapa(3)">
                                Avançar para Dados Pessoais <i class="ph ph-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- ETAPA 3 (Com os valores do cliente embutidos) --}}
                <div class="checkout-secao etapa-checkout" id="conteudo-etapa-3">
                    <h3><i class="ph ph-user"></i> 3. Seus Dados Pessoais</h3>
                    <div class="form-grid">
                        <div class="input-group">
                            <label for="nome_titular">Nome</label>
                            <input type="text" id="nome_titular" name="nome_cliente" placeholder="Seu nome completo" value="{{ old('nome_cliente', $nomeUsuario) }}" required />
                        </div>
                        <div class="input-group">
                            <label for="whatsapp">Seu WhatsApp (somente dígitos)</label>
                            <input type="tel" id="whatsapp" name="whatsapp" placeholder="Ex: 11999998888" value="{{ old('whatsapp', $whatsappUsuario) }}" required />
                        </div>
                        <div class="input-group">
                            <label for="aniversario">Aniversário (opcional, para brindes)</label>
                            <input type="text" id="aniversario" name="aniversario" placeholder="dd/mm" />
                        </div>
                    </div>
                    <div class="botoes-etapa">
                        <button type="button" class="btn-voltar" onclick="irParaEtapa(2)">
                            <i class="ph ph-arrow-left"></i> Voltar
                        </button>
                        <button type="button" class="btn-proximo" onclick="irParaEtapa(4)">
                            Avançar para Revisão <i class="ph ph-arrow-right"></i>
                        </button>
                    </div>
                </div>

                {{-- ETAPA 4 --}}
                <div class="checkout-secao etapa-checkout" id="conteudo-etapa-4">
                    <h3><i class="ph ph-calculator"></i> 4. Revisão Final</h3>
                    <div class="input-group">
                        <label for="cupom">Possui Cupom de Desconto?</label>
                        <div class="cupom-container">
                            <input type="text" id="cupom" name="cupom" placeholder="Cupom de desconto" />
                            <button type="button" class="btn-cupom">Aplicar</button>
                        </div>
                    </div>
                    <div class="input-group" style="margin-top: 20px">
                        <label for="observacoes">OBSERVAÇÕES / CPF NA NOTA</label>
                        <input type="text" id="observacoes" name="observacoes" placeholder="Ex: Sem cebola, deixar na portaria..." />
                    </div>
                    <div class="botoes-etapa">
                        <button type="button" class="btn-voltar" onclick="irParaEtapa(3)">
                            <i class="ph ph-arrow-left"></i> Voltar
                        </button>
                    </div>
                </div>
            </div>

          {{-- RESUMO FINAL (Com Aviso Inteligente) --}}
            <div class="checkout-resumo">
                <h3>Resumo do Pedido</h3>
                <div class="resumo-valores">
                    <div class="resumo-linha">
                        <span>Subtotal:</span>
                        <span>R$ {{ isset($subtotal) ? number_format($subtotal, 2, ',', '.') : '0,00' }}</span>
                    </div>
                    <div class="resumo-linha">
                        <span>Taxa de entrega:</span>
                        <span class="destaque-verde">A calcular</span>
                    </div>
                    <hr class="divisor" />
                    <div class="resumo-linha total">
                        <span>Total:</span>
                        <span>R$ {{ isset($subtotal) ? number_format($subtotal, 2, ',', '.') : '0,00' }}</span>
                    </div>
                </div>

                {{-- AVISO ADICIONADO --}}
                <div style="background-color: #fff9db; border-left: 4px solid #f59f00; padding: 12px; margin: 15px 0; border-radius: 4px; font-size: 13px; color: #664d03; line-height: 1.4;">
                    <i class="ph ph-info" style="font-size: 16px; vertical-align: middle; margin-right: 4px;"></i>
                    <strong>Atenção:</strong> Seu pedido será registrado no sistema e você será redirecionado para concluir o pagamento e a finalização diretamente no WhatsApp.
                </div>

                {{-- BOTÃO FINAL DE SUBMIT COM CONFIRMAÇÃO --}}
                <button type="submit" class="btn-confirmar" id="btn-finalizar-checkout" disabled style="opacity: 0.5; cursor: not-allowed" onclick="return confirmarEnvio()">
                    ENVIAR PEDIDO <i class="ph ph-arrow-right"></i>
                </button>
            </div>

                {{-- BOTÃO FINAL DE SUBMIT --}}
                <button type="submit" class="btn-confirmar" id="btn-finalizar-checkout" disabled style="opacity: 0.5; cursor: not-allowed">
                    ENVIAR PEDIDO <i class="ph ph-arrow-right"></i>
                </button>
            </div>
        </div>
    </form>
    {{-- FIM FASE 2 --}}

</div>

@endsection

@push('scripts')

  

<script>
    // 1. TOAST (Mensagens de Sucesso)
    setTimeout(() => {
        const toast = document.getElementById('toast-sucesso');
        if (toast) toast.style.transform = 'translateX(0)';
    }, 100);

    setTimeout(() => {
        const toast = document.getElementById('toast-sucesso');
        if (toast) toast.style.transform = 'translateX(120%)';
    }, 4000);

    // 2. TOGGLE DETALHES DO PRODUTO NO CARRINHO
    function toggleDetalhes(id) {
        const divDetalhes = document.getElementById('detalhes-' + id);
        divDetalhes.style.display = divDetalhes.style.display === 'none' ? 'block' : 'none';
    }

    // 3. ADICIONAR PRODUTOS RELACIONADOS FIXOS
    function adicionarFixo(id) {
        document.getElementById('id-produto-fixo').value = id;
        document.getElementById('form-add-fixo').submit();
    }

  // 4. MUDANÇA DE FASE: DO CARRINHO PARA O CHECKOUT (COM PROTEÇÃO DE LOGIN)
    function iniciarCheckout() {
        @if(auth()->check())
            // Se o cliente ESTIVER LOGADO, faz a transição suave para a Fase 2 (Formulários)
            document.getElementById('fase-carrinho').style.display = 'none';
            document.getElementById('fase-checkout').style.display = 'block';
            window.scrollTo({ top: 0, behavior: "smooth" });
        @else
            // Se o cliente NÃO estiver logado, manda ele para a página de Login!
            alert("Para finalizar seu pedido, faça login ou cadastre-se rapidinho!");
            window.location.href = "{{ url('/login') }}"; 
        @endif
    }

    // 5. NAVEGAÇÃO E VALIDAÇÃO DE ETAPAS DO CHECKOUT
    function irParaEtapa(etapaDestino) {
        
        // Antes de avançar, valida a etapa atual (se estiver indo para frente)
        let etapaAtual = etapaDestino - 1;
        
        if (etapaAtual > 0 && etapaDestino > etapaAtual) {
            let secaoAtual = document.getElementById(`conteudo-etapa-${etapaAtual}`);
            // Pega todos os campos que têm o atributo "required" nesta seção
            let inputsObrigatorios = secaoAtual.querySelectorAll('input[required]');
            let tudoPreenchido = true;

            inputsObrigatorios.forEach(input => {
                if (input.value.trim() === '') {
                    tudoPreenchido = false;
                    input.style.borderColor = '#ef4444'; // Pinta a borda de vermelho
                } else {
                    input.style.borderColor = '#d1d5db'; // Volta ao cinza normal
                }
            });

            if (!tudoPreenchido) {
                alert('Por favor, preencha todos os campos obrigatórios (em vermelho) antes de avançar.');
                return; // Trava o cliente aqui, não deixa mudar de tela
            }
        }

        // Se estiver tudo preenchido, faz a troca de tela visualmente
        document.querySelectorAll('.etapa-checkout').forEach(secao => {
            secao.classList.remove('ativo');
        });
        document.getElementById(`conteudo-etapa-${etapaDestino}`).classList.add('ativo');

        document.querySelectorAll('.step').forEach((passo, index) => {
            if (index + 1 <= etapaDestino) {
                passo.classList.add('ativo');
            } else {
                passo.classList.remove('ativo');
            }
        });

        // Libera o botão final apenas na Etapa 4
        const btnFinalizar = document.getElementById('btn-finalizar-checkout');
        if (etapaDestino === 4) {
            btnFinalizar.disabled = false;
            btnFinalizar.style.opacity = "1";
            btnFinalizar.style.cursor = "pointer";
        } else {
            btnFinalizar.disabled = true;
            btnFinalizar.style.opacity = "0.5";
            btnFinalizar.style.cursor = "not-allowed";
        }
        
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    // 6. BUSCA DE CEP AUTOMÁTICA
    document.addEventListener("DOMContentLoaded", function() {
        const inputCep = document.getElementById('cep');
        
        if (inputCep) {
            inputCep.addEventListener('blur', function() {
                let cepDigitado = this.value.replace(/\D/g, '');
                if (cepDigitado.length === 8) {
                    fetch(`https://viacep.com.br/ws/${cepDigitado}/json/`)
                        .then(resposta => resposta.json())
                        .then(dados => {
                            if (!dados.erro) {
                                document.getElementById('endereco_sp').value = dados.logradouro;
                                document.getElementById('bairro_cond').value = dados.bairro;
                                document.getElementById('numero_casa').focus();
                            } else {
                                alert("CEP não encontrado. Por favor, verifique.");
                            }
                        })
                        .catch(erro => console.error("Erro na busca do CEP:", erro));
                }
            });
        }
    });

    function confirmarEnvio() {
        return confirm("Deseja confirmar o envio do seu pedido? Você será direcionado ao WhatsApp da Fit Bia para finalizar!");
    }

</script>

<script>
    // Seleciona o formulário de checkout
    const formCheckout = document.getElementById('fase-checkout');
    
    if (formCheckout) {
        formCheckout.addEventListener('submit', function() {
            // Segundos antes de ir para o WhatsApp, reescrevemos o histórico do navegador.
            // Trocamos a URL atual pela URL do Painel de Pedidos.
            window.history.replaceState(null, '', '{{ route("site.painel") }}');
        });
    }
</script>


@endpush
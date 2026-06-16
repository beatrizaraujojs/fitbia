   <div class="container pedidos-container">
    
    <div class="pedidos-header">
    <div class="header-titulos">
        <h2>Meu Carrinho</h2>
        <p>Revise suas marmitas e pratos antes de finalizar.</p>
    </div>
    <i class="ph ph-tote header-icone-sacola"></i> 
</div>


    <div class="pedidos-layout">
        
      <div class="pedidos-lista">
            @php $subtotal = 0; @endphp
            
            @if(session('carrinho') && count(session('carrinho')) > 0)
                @foreach(session('carrinho') as $id_sessao => $item)
                    @php $subtotal += $item['preco'] * $item['quantidade']; @endphp
                    
                    <div class="item-pedido">
                        {{-- FOTO CLICÁVEL --}}
                        <div class="item-img-container" onclick="toggleDetalhes('{{ $id_sessao }}')" title="Clique para ver detalhes" style="cursor: pointer;">
                            @if(isset($item['foto']) && $item['foto'])
                                <img src="{{ asset('fitbia/images/produto/' . $item['foto']) }}" alt="{{ $item['nome'] }}" class="item-img">
                            @else
                                <img src="https://via.placeholder.com/100" alt="Sem foto" class="item-img">
                            @endif
                        </div>
                        
                        <div class="item-info">
                            {{-- TÍTULO CLICÁVEL COM ÍCONE DE SETINHA --}}
                            <h3 onclick="toggleDetalhes('{{ $id_sessao }}')" style="cursor: pointer; display: flex; align-items: center; gap: 5px; margin: 0 0 5px 0;">
                                {{ $item['nome'] }} 
                                <i class="ph ph-caret-down" style="font-size: 14px; color: #9ca3af;"></i>
                            </h3>
                            
                            <p class="item-preco">R$ {{ number_format($item['preco'], 2, ',', '.') }}</p>

                            {{-- CAIXA DE DETALHES OCULTA (Abre ao clicar) --}}
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
                            
                            {{-- CAIXINHA DE QUANTIDADE ESTILO NIKE --}}
                            <div style="display: flex; align-items: center; border: 1px solid #e5e7eb; border-radius: 4px; overflow: hidden; background: #fff;">
                                
                                {{-- Botão Menos --}}
                                <form action="{{ route('carrinho.atualizar', $id_sessao) }}" method="POST" style="margin: 0;">
                                    @csrf
                                    <input type="hidden" name="acao" value="diminuir">
                                    <button type="submit" style="background: transparent; border: none; padding: 6px 12px; font-size: 18px; cursor: pointer; color: #374151; transition: background 0.2s;" onmouseover="this.style.background='#f3f4f6'" onmouseout="this.style.background='transparent'">−</button>
                                </form>

                                {{-- Número --}}
                                <span style="padding: 6px 15px; font-size: 14px; font-weight: bold; color: #1f2937; border-left: 1px solid #e5e7eb; border-right: 1px solid #e5e7eb; min-width: 15px; text-align: center;">
                                    {{ $item['quantidade'] }}
                                </span>

                                {{-- Botão Mais --}}
                                <form action="{{ route('carrinho.atualizar', $id_sessao) }}" method="POST" style="margin: 0;">
                                    @csrf
                                    <input type="hidden" name="acao" value="aumentar">
                                    <button type="submit" style="background: transparent; border: none; padding: 6px 12px; font-size: 18px; cursor: pointer; color: #374151; transition: background 0.2s;" onmouseover="this.style.background='#f3f4f6'" onmouseout="this.style.background='transparent'">+</button>
                                </form>
                                
                            </div>
                            
                            {{-- Botão de Remover --}}
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
            
            {{-- Se o carrinho estiver vazio, o botão fica desabilitado --}}
            @if(session('carrinho') && count(session('carrinho')) > 0)
                <a href="#conteudo-etapa-1" class="btn-avancar" onclick="document.querySelector('.checkout-container').scrollIntoView({behavior: 'smooth'})">Avançar para entrega</a>
            @else
                <button class="btn-avancar" disabled style="opacity: 0.5; cursor: not-allowed;">Avançar para entrega</button>
            @endif
        </div>

    </div>
<div class="relacionados-section">
    <h3>Complete sua refeição</h3>
    <p>Que tal adicionar uma bebida ou sobremesa fit?</p>
    
    <div class="relacionados-grid">
        
        <div class="card-relacionado">
            <img src="https://via.placeholder.com/60" alt="Suco Detox">
            <div class="relacionado-info">
                <h4>Suco Verde Detox</h4>
                <span class="relacionado-preco">R$ 12,00</span>
            </div>
            {{-- Apenas adicionamos o onclick com o ID real do banco --}}
            <button class="btn-add-mini" title="Adicionar" onclick="adicionarFixo(1)">
                <i class="ph ph-plus"></i>
            </button>
        </div>

        <div class="card-relacionado">
            <img src="https://via.placeholder.com/60" alt="Brownie Fit">
            <div class="relacionado-info">
                <h4>Brownie Fit Cacau</h4>
                <span class="relacionado-preco">R$ 15,00</span>
            </div>
            {{-- Troque o 2 pelo ID real do Brownie no seu banco --}}
            <button class="btn-add-mini" title="Adicionar" onclick="adicionarFixo(2)">
                <i class="ph ph-plus"></i>
            </button>
        </div>

         <div class="card-relacionado">
            <img src="https://via.placeholder.com/60" alt="Salada de Frutas">
            <div class="relacionado-info">
                <h4>Salada de Frutas</h4>
                <span class="relacionado-preco">R$ 10,00</span>
            </div>
            {{-- Troque o 3 pelo ID real da Salada no seu banco --}}
            <button class="btn-add-mini" title="Adicionar" onclick="adicionarFixo(3)">
                <i class="ph ph-plus"></i>
            </button>
        </div>

    </div>
</div>

{{-- === FORMULÁRIO MESTRE INVISÍVEL === --}}
{{-- Fica totalmente escondido no final da página, sem quebrar o CSS --}}
<form id="form-add-fixo" action="{{ route('carrinho.adicionar') }}" method="POST" style="display: none;">
    @csrf
    <input type="hidden" name="id_produto" id="id-produto-fixo">
</form>

{{-- === INJECT DE LOGICA JAVASCRIPT === --}}
<script>
    function adicionarFixo(id) {
        // 1. Injeta o ID do produto clicado no campo invisível
        document.getElementById('id-produto-fixo').value = id;
        // 2. Dispara o envio do formulário de forma oculta
        document.getElementById('form-add-fixo').submit();
    }
</script>

</div>


{{-- SCRIPT PARA ABRIR/FECHAR OS DETALHES --}}
        <script>
            function toggleDetalhes(id) {
                const divDetalhes = document.getElementById('detalhes-' + id);
                if (divDetalhes.style.display === 'none') {
                    divDetalhes.style.display = 'block';
                } else {
                    divDetalhes.style.display = 'none';
                }
            }
        </script>
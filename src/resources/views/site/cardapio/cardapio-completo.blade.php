{{-- ======================================================== --}}
{{-- SEÇÃO DO CARDÁPIO (Fundo Limpo + Controles Compactos) --}}
{{-- ======================================================== --}}
<section class="cardapio-completo">
    
    {{-- BARRA DE CONTROLES: TÍTULO + PESQUISA + ORDENAÇÃO TUDO JUNTO --}}
    <div class="container header-ordenacao">
        <h2 class="titulo-secao-cardapio">Menu Fit Bia</h2>
        
        <div class="controles-wrapper">
            
            {{-- Nova Pesquisa Compacta --}}
            <form action="{{ route('site.cardapio') }}" method="GET" class="form-pesquisa-compacta">
                @if(request('cat'))
                    <input type="hidden" name="cat" value="{{ request('cat') }}">
                @endif
                <input type="text" name="busca" placeholder="Buscar prato..." value="{{ request('busca') }}">
                <button type="submit" aria-label="Buscar"><i class="ph ph-magnifying-glass"></i></button>
            </form>

            {{-- Filtro de Ordenação --}}
            <form id="form-ordenacao" method="GET" action="{{ route('site.cardapio') }}" class="form-ordenacao">
                @if(request('busca'))
                    <input type="hidden" name="busca" value="{{ request('busca') }}">
                @endif
                @if(request('cat'))
                    <input type="hidden" name="cat" value="{{ request('cat') }}">
                @endif

                <div class="select-wrapper">
                    <i class="ph ph-arrows-down-up"></i>
                    <select name="ordem" onchange="document.getElementById('form-ordenacao').submit();" class="select-premium">
                        <option value="">Ordenar por...</option>
                        <option value="menor_preco" {{ request('ordem') == 'menor_preco' ? 'selected' : '' }}>Menor preço</option>
                        <option value="maior_preco" {{ request('ordem') == 'maior_preco' ? 'selected' : '' }}>Maior preço</option>
                        <option value="az" {{ request('ordem') == 'az' ? 'selected' : '' }}>A-Z</option>
                    </select>
                </div>
            </form>
            
        </div>
    </div>

    {{-- BARRA DE CATEGORIAS LIMPA (Substitui o carrossel bugado) --}}
    <div class="container">
        <div class="categorias-wrapper">
            <a href="{{ route('site.cardapio') }}{{ request('busca') ? '?busca='.request('busca') : '' }}" class="filtro-btn-clean {{ !request('cat') ? 'ativo' : '' }}" data-id="todos">Todos</a>
            @foreach($categorias as $categoria)
                <a href="{{ route('site.cardapio') }}?cat={{ $categoria->id_categoria }}{{ request('busca') ? '&busca='.request('busca') : '' }}" class="filtro-btn-clean {{ request('cat') == $categoria->id_categoria ? 'ativo' : '' }}" data-id="{{ $categoria->id_categoria }}">
                    {{ $categoria->nome_categoria }}
                </a>
            @endforeach
        </div>
    </div>

    {{-- LISTAGEM DE CATEGORIAS E PRODUTOS --}}
    @foreach($categorias as $categoria)
    <div class="categoria-faixa" data-id="{{ $categoria->id_categoria }}">
        <div class="container">
            <h2 class="categoria-titulo">{{ $categoria->nome_categoria }}</h2>

            <div class="produtos-grid-premium">
                @foreach($categoria->produtos as $produto)
                <div class="produto-card-premium">
                    
                    <div class="produto-foto-premium">
                       <img src="{{ asset('fitbia/images/produto/' . $produto->foto_produto) }}" alt="{{ $produto->nome_produto }}">
                    </div>
                    
                    <div class="produto-info-premium">
                        <span class="tag-fitbia-exclusiva">Natural</span>
                        <h3 class="produto-nome-premium">{{ $produto->nome_produto }}</h3>
                        <p class="produto-desc-premium">{{ $produto->descricao_produto }}</p>
                        
                        <div class="fitbia-macros-pills">
                            <span>312 kcal</span>
                            <span>25g prot</span>
                            <span>30g carb</span>
                        </div>

                        <div class="produto-footer-premium">
                            <span class="produto-preco-premium">R$ {{ number_format($produto->preco_base_produto, 2, ',', '.') }}</span>
                            <button class="add-btn-fitbia-clean" data-id="{{ $produto->id_produto }}" onclick="abrirModal(this)">
                                <i class="ph ph-plus"></i> Adicionar
                            </button>
                        </div>
                    </div>
                </div>

                {{-- MODAL DE ADICIONAIS DO PRODUTO --}}
                <div class="modal-overlay" id="modal-{{ $produto->id_produto }}">
                    <div class="modal-conteudo">
                        <div class="modal-cabecalho">
                            <h3>{{ $produto->nome_produto }}</h3>
                            <button class="btn-fechar" data-id="{{ $produto->id_produto }}" onclick="fecharModal(this)">×</button>
                        </div>

                        <form action="{{ route('carrinho.adicionar') }}" method="POST" class="form-carrinho-ajax" style="display: flex; flex-direction: column; flex: 1; overflow: hidden;">
                            @csrf
                            <input type="hidden" name="id_produto" value="{{ $produto->id_produto }}">

                            <div class="modal-corpo">
                                @foreach($produto->gruposAdicionais as $grupo)
                                <div class="grupo-adicional" data-max="{{ $grupo->qtd_max_grupo }}" style="margin-bottom: 20px;">
                                    <div class="grupo-titulo">
                                        <h4>{{ $grupo->nome_grupo_adicional }}</h4>
                                        <div>
                                            <span>
                                                @if($grupo->qtd_min_grupo > 0) (Obrigatório, max {{ $grupo->qtd_max_grupo }}) @else (Opcional, max {{ $grupo->qtd_max_grupo }}) @endif
                                            </span>
                                            <small class="msg-erro" style="color: #d32f2f; display: none; font-size: 11px; font-weight: bold; text-align: right; margin-top: 2px;">
                                                Limite máximo atingido!
                                            </small>
                                        </div>
                                    </div>

                                    @foreach($grupo->adicionais as $adicional)
                                    <div class="linha-item" data-id-adicional="{{ $adicional->id_adicional }}" data-preco="{{ $adicional->preco_adicional }}">
                                        <div class="info-item">
                                            <span class="nome">{{ $adicional->nome_adicional }}</span>
                                            <span class="preco">
                                                @if($adicional->preco_adicional > 0) + R$ {{ number_format($adicional->preco_adicional, 2, ',', '.') }} @else Grátis @endif
                                            </span>
                                        </div>
                                        <div class="controle-qtd">
                                            <button type="button" class="btn-menos" onclick="alterarQtd(this, -1)">-</button>
                                            <span class="qtd">0</span>
                                            <input type="hidden" name="adicionais[{{ $adicional->id_adicional }}]" class="input-qtd" value="0">
                                            <button type="button" class="btn-mais" onclick="alterarQtd(this, 1)">+</button>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                @endforeach

                                <div class="campo-observacao">
                                    <textarea name="observacao" placeholder="Alguma observação? Ex: Tirar cebola..."></textarea>
                                </div>
                            </div>

                            <div class="modal-rodape">
                                <button type="submit" class="btn-avancar">
                                    Avançar R$ <span class="valor-btn" data-base="{{ $produto->preco_base_produto }}">{{ number_format($produto->preco_base_produto, 2, ',', '.') }}</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endforeach

    {{-- 🛒 MODAL INTERMEDIÁRIO DE DECISÃO --}}
    <div id="modal-decisao-carrinho" class="modal-decisao-overlay" style="display: none;">
        <div class="modal-decisao-box">
            <div class="modal-decisao-icone">
                <i class="ph ph-hand-heart"></i>
            </div>
            <h2>Item adicionado!</h2>
            <p>Sua escolha saudável já foi salva. O que deseja fazer?</p>
            <div class="modal-decisao-botoes">
                <button type="button" onclick="fecharModalDecisao()" class="btn-decisao-continuar">Continuar Comprando</button>
                <a href="{{ route('site.carrinho') }}" class="btn-decisao-carrinho">Fechar Pedido e Ir pro Carrinho</a>
            </div>
        </div>
    </div>

    {{-- ======================================================== --}}
    {{-- ESTILOS REFINADOS (Limpo e Organizado) --}}
    {{-- ======================================================== --}}
    <style>
        .cardapio-completo {
            padding-bottom: 80px;
            background-color: var(--bg-principal, #FAF9F6); 
        }

        /* Organização do Topo (Título + Busca + Filtro) */
        .header-ordenacao {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 5%;
            margin-bottom: 10px;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            flex-wrap: wrap;
            gap: 20px;
        }

        .titulo-secao-cardapio {
            font-family: 'Montserrat', sans-serif;
            font-size: 26px;
            color: var(--verde-escuro, #2b4230);
            font-weight: 700;
            margin: 0;
        }

        .controles-wrapper {
            display: flex;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        /* Nova Pesquisa Compacta */
        .form-pesquisa-compacta {
            display: flex;
            align-items: center;
            background: #ffffff;
            border: 1px solid rgba(0,0,0,0.08);
            border-radius: 30px;
            padding: 0 15px;
            height: 42px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.02);
            transition: all 0.3s ease;
        }

        .form-pesquisa-compacta:focus-within {
            border-color: var(--verde-folha, #3C8A4B);
            box-shadow: 0 4px 15px rgba(60, 138, 75, 0.1);
        }

        .form-pesquisa-compacta input {
            border: none;
            outline: none;
            background: transparent;
            font-family: 'Inter', sans-serif;
            font-size: 14px;
            width: 160px;
            color: var(--verde-escuro, #2b4230);
        }

        .form-pesquisa-compacta button {
            background: none;
            border: none;
            color: var(--verde-oliva, #30352f);
            font-size: 18px;
            cursor: pointer;
            display: flex;
            align-items: center;
            padding: 0;
            margin-left: 5px;
        }

        /* Select de Ordenação */
        .select-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .select-wrapper i {
            position: absolute;
            left: 15px;
            color: var(--verde-oliva, #30352f);
            font-size: 18px;
            pointer-events: none;
        }

        .select-premium {
            appearance: none;
            -webkit-appearance: none;
            background-color: #ffffff;
            border: 1px solid rgba(0,0,0,0.08);
            border-radius: 30px;
            padding: 0 40px 0 45px;
            height: 42px;
            font-family: 'Inter', sans-serif;
            font-size: 14px;
            font-weight: 500;
            color: var(--verde-escuro, #2b4230);
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(0,0,0,0.02);
            transition: all 0.3s ease;
        }

        .select-premium:focus, .select-premium:hover {
            border-color: var(--verde-folha, #3C8A4B);
            box-shadow: 0 4px 15px rgba(60, 138, 75, 0.1);
            outline: none;
        }

        /* Barra de Categorias Limpa (Sem bugs) */
        .categorias-wrapper {
            display: flex;
            gap: 12px;
            overflow-x: auto;
            padding: 10px 5% 30px 5%;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }
        .categorias-wrapper::-webkit-scrollbar {
            display: none;
        }

        .filtro-btn-clean {
            background-color: #f3f4f6;
            color: #4b5563;
            border-radius: 50px;
            padding: 8px 20px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            white-space: nowrap;
            transition: all 0.3s;
            border: 1px solid transparent;
        }

        .filtro-btn-clean:hover {
            background-color: #e5e7eb;
            color: var(--verde-escuro, #2b4230);
        }

        .filtro-btn-clean.ativo {
            background-color: var(--verde-escuro, #2b4230);
            color: #fff;
            box-shadow: 0 4px 12px rgba(43, 66, 48, 0.2);
        }

        /* Resto do Layout */
        .categoria-faixa {
            padding: 20px 0 60px 0; 
        }

        .categoria-titulo {
            font-family: 'Montserrat', sans-serif;
            font-size: 28px;
            font-weight: 700;
            color: var(--verde-escuro, #2b4230);
            margin-bottom: 30px; 
            position: relative;
            padding-bottom: 12px;
            display: inline-block;
        }

        .categoria-titulo::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 40px;
            height: 3px;
            background-color: var(--verde-folha, #3C8A4B);
            border-radius: 4px;
        }

        .produtos-grid-premium {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 30px; 
        }

        .produto-card-premium {
            background: #ffffff;
            border-radius: 20px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            border: 1px solid rgba(0,0,0,0.03);
            box-shadow: 0 5px 20px rgba(0,0,0,0.03);
            transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
        }

        .produto-card-premium:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.08);
        }

        .produto-foto-premium {
            width: 100%;
            height: 220px; 
            overflow: hidden;
        }

        .produto-foto-premium img {
            width: 100%;
            height: 100%;
            object-fit: cover; 
            transition: transform 0.5s ease;
        }

        .produto-card-premium:hover .produto-foto-premium img {
            transform: scale(1.05); 
        }

        .produto-info-premium {
            padding: 24px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .tag-fitbia-exclusiva {
            font-size: 10px;
            background: rgba(43, 66, 48, 0.08);
            color: #2b4230;
            font-weight: 700;
            padding: 4px 8px;
            border-radius: 4px;
            text-transform: uppercase;
            display: inline-block;
            margin-bottom: 10px;
            width: max-content;
        }

        .produto-nome-premium { 
            font-size: 18px; 
            color: #111; 
            margin: 0 0 8px 0; 
            font-weight: 700; 
            line-height: 1.3;
        }

        .produto-desc-premium { 
            font-size: 13px; 
            color: #6b7280; 
            line-height: 1.5; 
            margin-bottom: 15px; 
            height: 38px; 
            overflow: hidden; 
            display: -webkit-box; 
            -webkit-line-clamp: 2; 
            -webkit-box-orient: vertical; 
        }

        .fitbia-macros-pills { 
            display: flex; 
            gap: 8px; 
            margin-bottom: 20px; 
        }

        .fitbia-macros-pills span { 
            font-size: 11px; 
            background: #f3f4f6; 
            color: #4b5563; 
            padding: 4px 8px; 
            border-radius: 12px; 
            font-weight: 600; 
        }

        .produto-footer-premium { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            margin-top: auto; 
            border-top: 1px solid #f3f4f6;
            padding-top: 15px;
        }

        .produto-preco-premium { 
            font-size: 20px; 
            font-weight: 800; 
            color: var(--verde-escuro, #2b4230); 
        }

        .add-btn-fitbia-clean {
            background: var(--verde-escuro, #2b4230);
            color: white;
            border: none;
            padding: 10px 16px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.3s;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .add-btn-fitbia-clean:hover { 
            background: var(--verde-folha, #3C8A4B); 
        }

        /* Estilos dos Modais */
        .modal-decisao-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); backdrop-filter: blur(4px); z-index: 10000; display: flex; align-items: center; justify-content: center; }
        .modal-decisao-box { background: #fff; padding: 25px; border-radius: 16px; width: 90%; max-width: 360px; text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
        .modal-decisao-icone { background: #eef5f0; color: #2b4230; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px auto; font-size: 24px; }
        .modal-decisao-box h2 { font-size: 18px; color: #111827; margin: 0 0 6px 0; font-weight: 700; }
        .modal-decisao-box p { font-size: 13px; color: #6b7280; margin: 0 0 20px 0; }
        .modal-decisao-botoes { display: flex; flex-direction: column; gap: 8px; }
        .btn-decisao-carrinho { background: #2b4230; color: #fff; padding: 10px; border-radius: 6px; text-decoration: none; font-weight: bold; font-size: 13px; display: block; }
        .btn-decisao-continuar { background: #fff; border: 1px solid #d1d5db; color: #4b5563; padding: 10px; border-radius: 6px; font-weight: 600; font-size: 13px; cursor: pointer; }

        .modal-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 9999; justify-content: center; align-items: center; }
        .modal-conteudo { background-color: #ffffff; width: 90%; max-width: 400px; border-radius: 15px; overflow: hidden; display: flex; flex-direction: column; max-height: 90vh; }
        .modal-cabecalho { padding: 15px 20px; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; align-items: center; }
        .modal-cabecalho h3 { margin: 0; color: #2c4230; font-size: 18px; }
        .btn-fechar { background: none; border: none; font-size: 28px; cursor: pointer; color: #999; }
        .modal-corpo { padding: 20px; overflow-y: auto; }
        .grupo-titulo { background-color: #f1f1f1; padding: 10px; margin-bottom: 10px; display: flex; justify-content: space-between; align-items: center; border-radius: 6px; }
        .grupo-titulo h4 { margin: 0; color: #333; font-size: 14px; }
        .grupo-titulo span { color: #d32f2f; font-size: 12px; font-weight: bold; }
        .linha-item { display: flex; justify-content: space-between; align-items: center; padding: 15px 0; border-bottom: 1px solid #eee; }
        .info-item { display: flex; flex-direction: column; }
        .info-item .nome { font-weight: bold; color: #333; font-size: 14px; }
        .info-item .preco { font-size: 12px; color: #666; margin-top: 5px; }
        .controle-qtd { display: flex; align-items: center; gap: 15px; }
        .controle-qtd button { background-color: #4CAF50; color: white; border: none; border-radius: 6px; width: 30px; height: 30px; font-size: 18px; cursor: pointer; }
        .controle-qtd .qtd { font-weight: bold; font-size: 16px; width: 15px; text-align: center; }
        .campo-observacao textarea { width: 100%; box-sizing: border-box; padding: 10px; border: 1px solid #ccc; border-radius: 8px; margin-top: 20px; height: 80px; resize: none; }
        .modal-rodape { padding: 15px 20px; border-top: 1px solid #eee; }
        .btn-avancar { width: 100%; background-color: #2b4230; color: white; border: none; padding: 15px; border-radius: 8px; font-size: 16px; font-weight: bold; cursor: pointer; }
        
        @media (max-width: 768px) {
            .produtos-grid-premium {
                grid-template-columns: 1fr; 
            }
            .header-ordenacao {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
            .controles-wrapper {
                width: 100%;
                justify-content: space-between;
            }
            .form-pesquisa-compacta, .form-ordenacao, .select-premium {
                width: 100%;
            }
            .form-pesquisa-compacta input {
                width: 100%;
            }
        }
    </style>

    {{-- ======================================================== --}}
    {{-- SCRIPTS DE INTERAÇÃO DOS MODAIS E CARRINHO --}}
    {{-- ======================================================== --}}
    <script>
        function abrirModal(botao) {
            let idProduto = botao.getAttribute('data-id');
            document.getElementById('modal-' + idProduto).style.display = 'flex';
        }

        function fecharModal(botao) {
            let idProduto = botao.getAttribute('data-id');
            document.getElementById('modal-' + idProduto).style.display = 'none';
        }

        function fecharModalDecisao() {
            document.getElementById('modal-decisao-carrinho').style.display = 'none';
        }

        window.onclick = function(event) {
            if (event.target.classList.contains('modal-overlay')) event.target.style.display = 'none';
            if (event.target.classList.contains('modal-decisao-overlay')) event.target.style.display = 'none';
        }

        document.querySelectorAll('.form-carrinho-ajax').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                let formData = new FormData(this);
                let actionUrl = this.getAttribute('action');
                let modalProduto = this.closest('.modal-overlay');

                fetch(actionUrl, {
                    method: 'POST',
                    body: formData,
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(response => {
                    if (modalProduto) modalProduto.style.display = 'none';
                    this.reset();
                    this.querySelectorAll('.qtd').forEach(s => s.innerText = '0');
                    
                    document.getElementById('modal-decisao-carrinho').style.display = 'flex';

                    let bolinhaCarrinho = document.getElementById('contador-carrinho');
                    if(bolinhaCarrinho) {
                        bolinhaCarrinho.style.display = 'flex';
                        
                        let qtdAtual = parseInt(bolinhaCarrinho.innerText) || 0;
                        bolinhaCarrinho.innerText = qtdAtual + 1;
                        
                        bolinhaCarrinho.classList.add('pular');
                        setTimeout(() => bolinhaCarrinho.classList.remove('pular'), 300);
                    }
                })
                .catch(error => {
                    console.error('Erro:', error);
                    alert('Erro ao processar carrinho. Tente novamente.');
                });
            });
        });

        function atualizarPrecoModal(modal) {
            let spanValor = modal.querySelector('.valor-btn');
            let precoTotal = parseFloat(spanValor.getAttribute('data-base'));
            
            modal.querySelectorAll('.linha-item').forEach(linha => {
                let qtd = parseInt(linha.querySelector('.qtd').innerText);
                let precoAdicional = parseFloat(linha.getAttribute('data-preco')) || 0;
                if (qtd > 0 && precoAdicional > 0) precoTotal += (qtd * precoAdicional);
            });
            
            spanValor.innerText = precoTotal.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        }

        function alterarQtd(botao, valor) {
            let grupo = botao.closest('.grupo-adicional');
            let maxPermitido = parseInt(grupo.getAttribute('data-max'));
            let spanQtdAtual = botao.parentElement.querySelector('.qtd');
            let inputQtdAtual = botao.parentElement.querySelector('.input-qtd'); 
            let qtdItemAtual = parseInt(spanQtdAtual.innerText);
            let msgErro = grupo.querySelector('.msg-erro');

            if (valor < 0) {
                if (qtdItemAtual + valor >= 0) {
                    spanQtdAtual.innerText = qtdItemAtual + valor;
                    if (inputQtdAtual) inputQtdAtual.value = qtdItemAtual + valor; 
                    if (msgErro) msgErro.style.display = 'none';
                    atualizarPrecoModal(botao.closest('.modal-conteudo'));
                }
                return;
            }

            let totalAtualDoGrupo = 0;
            grupo.querySelectorAll('.qtd').forEach(span => totalAtualDoGrupo += parseInt(span.innerText));

            if (totalAtualDoGrupo + valor > maxPermitido) {
                if (msgErro) {
                    msgErro.style.display = 'block';
                    setTimeout(() => { msgErro.style.display = 'none'; }, 2500);
                }
                return;
            }

            spanQtdAtual.innerText = qtdItemAtual + valor;
            if (inputQtdAtual) inputQtdAtual.value = qtdItemAtual + valor; 
            atualizarPrecoModal(botao.closest('.modal-conteudo'));
        }
    </script>

    {{-- ======================================================== --}}
    {{-- SCRIPT CORRIGIDO DE FILTRO DE CATEGORIAS DA PÁGINA        --}}
    {{-- ======================================================== --}}
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const urlParams = new URLSearchParams(window.location.search);
            let idCategoriaEscolhida = urlParams.get('cat') || 'todos';
            const temBuscaAtiva = urlParams.has('busca') && urlParams.get('busca') !== '';

            // 🌟 A MÁGICA DA CORREÇÃO AQUI:
            // Se o usuário fez uma pesquisa por texto, nós NÃO escondemos as faixas por categoria.
            // Deixamos o Laravel mostrar livremente o que ele achou no banco!
            document.querySelectorAll('.categoria-faixa').forEach(faixa => {
                if (temBuscaAtiva) {
                    faixa.style.display = 'block'; 
                } else {
                    const idFaixa = faixa.getAttribute('data-id');
                    if (idCategoriaEscolhida === 'todos' || idFaixa === idCategoriaEscolhida) {
                        faixa.style.display = 'block'; 
                    } else {
                        faixa.style.display = 'none';  
                    }
                }
            });

            // Acende o botão correto na barra
            document.querySelectorAll('.filtro-btn-clean').forEach(btn => {
                btn.classList.remove('ativo');
                let idBotao = btn.getAttribute('data-id');
                
                if (idBotao === idCategoriaEscolhida || (idCategoriaEscolhida === 'todos' && !idBotao)) {
                    btn.classList.add('ativo');
                }
            });
            
            // Arrastar a barra com o mouse no Desktop
            const track = document.querySelector('.categorias-wrapper');
            if (track) {
                let isDown = false;
                let startX;
                let scrollLeft;

                track.addEventListener('mousedown', (e) => {
                    isDown = true;
                    startX = e.pageX - track.offsetLeft;
                    scrollLeft = track.scrollLeft;
                });
                track.addEventListener('mouseleave', () => { isDown = false; });
                track.addEventListener('mouseup', () => { isDown = false; });
                track.addEventListener('mousemove', (e) => {
                    if (!isDown) return;
                    e.preventDefault();
                    const x = e.pageX - track.offsetLeft;
                    const walk = (x - startX) * 2; 
                    track.scrollLeft = scrollLeft - walk;
                });
            }
        });
    </script>
    
</section>
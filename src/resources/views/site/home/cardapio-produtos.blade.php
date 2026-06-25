<section class="cardapio-produtos-dark">
    <div class="container">

        {{-- Cabeçalho da Seção Premium --}}
        <div class="secao-header-ifood">
            <div class="header-textos">
                <span class="subtitulo-dark">PARA O SEU DIA A DIA</span>
                <h2 class="titulo-dark">Os Favoritos <span class="destaque-dark">Fit Bia</span></h2>
                <p class="desc-dark">Pratos ultracongelados cheios de sabor e nutrientes. Escolha os seus e monte sua rotina.</p>
            </div>
            <a href="{{ route('site.cardapio') }}" class="btn-ver-todos">Ver Cardápio Completo</a>
        </div>

        <div class="carrossel-ifood-wrapper">
            {{-- Botão Voltar --}}
            <button class="btn-scroll btn-esq" onclick="scrollIfood(-1)" aria-label="Voltar">
                <i class="ph ph-caret-left"></i>
            </button>
            
            <div class="carrossel-ifood-track" id="track-ifood">
                
                @foreach($categorias as $categoria)
                    @php $nomeCategoria = Str::lower($categoria->nome_categoria); @endphp

                    {{-- 🚫 Ignora os Combos no carrossel da home --}}
                    @if(!Str::contains($nomeCategoria, 'combo'))
                        
                        @foreach($categoria->produtos as $produto)
                            {{-- CARD ESTILO iFOOD --}}
                            <div class="card-ifood">
                                <div class="foto-ifood">
                                    <img src="{{ asset('fitbia/images/produto/' . $produto->foto_produto) }}" alt="{{ $produto->nome_produto }}">
                                </div>
                                
                                <div class="info-ifood">
                                    <span class="tag-fitbia">Natural</span>
                                    <h3 class="nome-ifood">{{ $produto->nome_produto }}</h3>
                                    <p class="desc-ifood">{{ $produto->descricao_produto }}</p>
                                    
                                    <div class="footer-ifood">
                                        <div class="preco-wrapper">
                                            <span class="preco-ifood">R$ {{ number_format($produto->preco_base_produto, 2, ',', '.') }}</span>
                                        </div>
                                        
                                        {{-- O Botão de Adicionar Redondo --}}
                                        <button class="add-btn-ifood" data-id="{{ $produto->id_produto }}" onclick="abrirModal(this)" title="Adicionar ao Carrinho">
                                            <i class="ph ph-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            {{-- MODAL DE ADICIONAIS DO PRODUTO (Escondido, abre no clique do +) --}}
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
                                            <div class="grupo-adicional" data-max="{{ $grupo->qtd_max_grupo }}">
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

                    @endif
                @endforeach

            </div>

            {{-- Botão Avançar --}}
            <button class="btn-scroll btn-dir" onclick="scrollIfood(1)" aria-label="Avançar">
                <i class="ph ph-caret-right"></i>
            </button>
        </div>
    </div>

    {{-- 🛒 MODAL INTERMEDIÁRIO DE DECISÃO (Continua na mesma pegada) --}}
    <div id="modal-decisao-carrinho" class="modal-decisao-overlay" style="display: none;">
        <div class="modal-decisao-box">
            <div class="modal-decisao-icone"><i class="ph ph-hand-heart"></i></div>
            <h2>Item adicionado!</h2>
            <p>Sua escolha saudável já foi salva. O que deseja fazer?</p>
            <div class="modal-decisao-botoes">
                <button type="button" onclick="fecharModalDecisao()" class="btn-decisao-continuar">Continuar Escolhendo</button>
                <a href="{{ route('site.carrinho') }}" class="btn-decisao-carrinho">Ir para o Carrinho</a>
            </div>
        </div>
    </div>

    {{-- ======================================================== --}}
    {{-- CSS: ESTILO IFOOD ESCURO + MODAIS --}}
    {{-- ======================================================== --}}
    <style>
        .cardapio-produtos-dark { 
            background-color: var(--verde-escuro, #2b4230); 
            padding: 80px 0; 
            overflow: hidden; 
            font-family: 'Inter', sans-serif;
        }

        /* Header da Seção mais atrativo */
        .secao-header-ifood { 
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 40px; 
            flex-wrap: wrap;
            gap: 20px;
        }

        .header-textos { max-width: 600px; }

        .subtitulo-dark { 
            color: #bed3ba;
            font-size: 13px; 
            font-weight: 700; 
            letter-spacing: 2px; 
            text-transform: uppercase; 
            display: block;
            margin-bottom: 8px;
        }

        .titulo-dark { 
            font-family: 'Montserrat', sans-serif;
            font-size: 36px; 
            font-weight: 700; 
            color: #ffffff; 
            margin: 0 0 10px 0; 
        }

        .destaque-dark { color: var(--verde-folha, #4CAF50); }

        .desc-dark {
            color: rgba(255,255,255,0.7);
            font-size: 15px;
            line-height: 1.6;
            margin: 0;
        }

        .btn-ver-todos {
            background-color: transparent;
            color: #ffffff;
            border: 2px solid #ffffff;
            padding: 10px 24px;
            border-radius: 30px;
            font-weight: 600;
            font-size: 14px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-ver-todos:hover {
            background-color: #ffffff;
            color: var(--verde-escuro, #2b4230);
        }

        /* Carrossel */
        .carrossel-ifood-wrapper { position: relative; }

        .carrossel-ifood-track {
            display: flex;
            gap: 20px;
            overflow-x: auto;
            padding: 10px 5px 30px 5px; /* Padding embaixo para sombra */
            scroll-snap-type: x mandatory;
            scrollbar-width: none;
            -ms-overflow-style: none;
            scroll-behavior: smooth;
        }

        .carrossel-ifood-track::-webkit-scrollbar { display: none; }

        /* Card iFood Premium */
        .card-ifood {
            background: #ffffff;
            border-radius: 16px;
            min-width: 250px; /* Largura ideal */
            max-width: 250px;
            display: flex;
            flex-direction: column;
            scroll-snap-align: start;
            box-shadow: 0 5px 20px rgba(0,0,0,0.2);
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .card-ifood:hover { transform: translateY(-8px); }

        .foto-ifood { width: 100%; height: 160px; overflow: hidden; }
        .foto-ifood img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease; }
        .card-ifood:hover .foto-ifood img { transform: scale(1.05); }

        .info-ifood { padding: 20px; display: flex; flex-direction: column; flex-grow: 1; }

        .tag-fitbia {
            font-size: 10px;
            background: rgba(76, 175, 80, 0.1);
            color: var(--verde-folha, #4CAF50);
            font-weight: 700;
            padding: 4px 8px;
            border-radius: 4px;
            text-transform: uppercase;
            width: max-content;
            margin-bottom: 10px;
        }

        .nome-ifood { font-size: 16px; color: #1a1a1a; margin: 0 0 8px 0; font-weight: 700; line-height: 1.3; }
        .desc-ifood { font-size: 13px; color: #666; margin: 0 0 20px 0; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }

        .footer-ifood { display: flex; justify-content: space-between; align-items: center; margin-top: auto; border-top: 1px solid #f3f4f6; padding-top: 15px; }

        .preco-ifood { font-family: 'Montserrat', sans-serif; font-size: 18px; font-weight: 800; color: var(--verde-escuro, #2b4230); }

        /* Botão Redondo (+) */
        .add-btn-ifood { 
            background: var(--verde-escuro, #2b4230); 
            color: #ffffff; 
            border: none; 
            width: 40px; 
            height: 40px; 
            border-radius: 50%; 
            font-size: 20px; 
            cursor: pointer; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            transition: all 0.3s ease; 
            box-shadow: 0 4px 10px rgba(43, 66, 48, 0.2);
        }

        .add-btn-ifood:hover { background: var(--verde-folha, #4CAF50); transform: scale(1.05); }

        /* Setas Flutuantes */
        .btn-scroll { position: absolute; top: calc(50% - 20px); transform: translateY(-50%); background: #fff; border: none; width: 48px; height: 48px; border-radius: 50%; box-shadow: 0 5px 15px rgba(0,0,0,0.3); font-size: 24px; color: var(--verde-escuro, #2b4230); cursor: pointer; z-index: 10; display: flex; align-items: center; justify-content: center; transition: 0.2s; }
        .btn-scroll:hover { background: var(--verde-folha, #4CAF50); color: #fff; }
        .btn-esq { left: -20px; }
        .btn-dir { right: -20px; }

        /* CSS dos Modais (Obrigatório para o botão funcionar) */
        .modal-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.6); backdrop-filter: blur(4px); z-index: 9999; justify-content: center; align-items: center; }
        .modal-conteudo { background-color: #ffffff; width: 90%; max-width: 450px; border-radius: 16px; overflow: hidden; display: flex; flex-direction: column; max-height: 90vh; box-shadow: 0 20px 40px rgba(0,0,0,0.2); }
        .modal-cabecalho { padding: 18px 24px; border-bottom: 1px solid #f1f1f1; display: flex; justify-content: space-between; align-items: center; background: #fbfbfb; }
        .modal-cabecalho h3 { margin: 0; color: var(--verde-escuro); font-size: 18px; font-weight: 700; }
        .btn-fechar { background: none; border: none; font-size: 28px; cursor: pointer; color: #999; transition: color 0.2s; }
        .btn-fechar:hover { color: #333; }
        .modal-corpo { padding: 24px; overflow-y: auto; }
        .grupo-adicional { margin-bottom: 24px; }
        .grupo-titulo { background-color: #f8f9fa; padding: 12px 16px; margin-bottom: 12px; border-radius: 8px; border-left: 4px solid var(--verde-folha); }
        .grupo-titulo h4 { margin: 0 0 4px 0; color: #333; font-size: 15px; }
        .linha-item { display: flex; justify-content: space-between; align-items: center; padding: 12px 0; border-bottom: 1px solid #f1f1f1; }
        .info-item .nome { font-weight: 600; color: #444; font-size: 14px; display: block; }
        .info-item .preco { font-size: 13px; color: #666; margin-top: 2px; display: block; }
        .controle-qtd { display: flex; align-items: center; gap: 12px; }
        .controle-qtd button { background-color: #f3f4f6; color: var(--verde-escuro); border: none; border-radius: 8px; width: 32px; height: 32px; font-size: 18px; cursor: pointer; transition: 0.2s; }
        .controle-qtd button:hover { background-color: #e5e7eb; }
        .controle-qtd .qtd { font-weight: bold; font-size: 16px; width: 20px; text-align: center; }
        .campo-observacao textarea { width: 100%; box-sizing: border-box; padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; height: 80px; resize: none; font-family: inherit; }
        .modal-rodape { padding: 20px 24px; border-top: 1px solid #f1f1f1; background: #fff; }
        .btn-avancar { width: 100%; background-color: var(--verde-escuro); color: white; border: none; padding: 16px; border-radius: 12px; font-size: 16px; font-weight: bold; cursor: pointer; transition: 0.3s; }
        .btn-avancar:hover { background-color: var(--verde-folha); }

        /* Modal Decisão */
        .modal-decisao-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); backdrop-filter: blur(4px); z-index: 10000; display: flex; align-items: center; justify-content: center; }
        .modal-decisao-box { background: #fff; padding: 30px; border-radius: 16px; width: 90%; max-width: 360px; text-align: center; }
        .modal-decisao-icone { background: rgba(76, 175, 80, 0.1); color: var(--verde-folha); width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px auto; font-size: 28px; }
        .modal-decisao-botoes { display: flex; flex-direction: column; gap: 10px; margin-top: 20px;}
        .btn-decisao-carrinho { background: var(--verde-escuro); color: #fff; padding: 12px; border-radius: 8px; text-decoration: none; font-weight: bold; font-size: 14px; }
        .btn-decisao-continuar { background: #fff; border: 1px solid #e5e7eb; color: #4b5563; padding: 12px; border-radius: 8px; font-weight: 600; cursor: pointer; }

        @media (max-width: 768px) { 
            .btn-scroll { display: none; } 
            .secao-header-ifood { flex-direction: column; align-items: flex-start; }
            .btn-ver-todos { width: 100%; text-align: center; }
        }
    </style>

    {{-- ======================================================== --}}
    {{-- SCRIPTS: CARROSSEL AUTOPLAY E MODAIS AJAX --}}
    {{-- ======================================================== --}}
    <script>
        // 1. CARROSSEL INTELIGENTE
        function scrollIfood(direcao) {
            const track = document.getElementById('track-ifood');
            if (track) track.scrollBy({ left: direcao * 270, behavior: 'smooth' }); // 250(card) + 20(gap)
        }

        document.addEventListener("DOMContentLoaded", () => {
            const track = document.getElementById('track-ifood');
            let autoPlayTimer;

            function iniciarAutoPlay() {
                autoPlayTimer = setInterval(() => {
                    if (track) {
                        // Se chegou no final, volta pro inicio suavemente
                        if (track.scrollLeft + track.clientWidth >= track.scrollWidth - 10) {
                            track.scrollTo({ left: 0, behavior: 'smooth' });
                        } else {
                            scrollIfood(1);
                        }
                    }
                }, 3000); // Roda a cada 3s
            }

            function pausarAutoPlay() { clearInterval(autoPlayTimer); }

            if (track) {
                iniciarAutoPlay();
                // Pausa se o cliente for mexer
                track.addEventListener('mouseenter', pausarAutoPlay);
                track.addEventListener('mouseleave', iniciarAutoPlay);
                track.addEventListener('touchstart', pausarAutoPlay);
                track.addEventListener('touchend', iniciarAutoPlay);
            }
        });

        // 2. LÓGICA DOS MODAIS (ADICIONAR)
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

        // Envio do formulário via AJAX para o carrinho e Bolinha do Menu
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

        // Atualização de Preço e Quantidade dentro do Modal
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
</section>
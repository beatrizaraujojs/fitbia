


{{-- ======================================================== --}}
{{-- SEÇÃO DO CARDÁPIO (Faixas de ponta a ponta + CARDS MENORES) --}}
{{-- ======================================================== --}}
<section class="cardapio-completo" style="padding-top: 10px;">
    @foreach($categorias as $categoria)
    @php
        $fundosSuaves = ['#f4f7f4', '#faf6f0', '#f1f5f9', '#fbf4f5'];
        $corDeFundo = $fundosSuaves[$loop->index % count($fundosSuaves)];
    @endphp
    
    <div class="categoria-faixa" data-id="{{ $categoria->id_categoria }}" style="background-color: {{ $corDeFundo }}; padding: 50px 0; margin-bottom: 15px;">
        <div class="container">
            <h2 class="categoria-titulo" style="color: #2b4230; margin-bottom: 25px; font-size: 24px; font-weight: 700;">{{ $categoria->nome_categoria }}</h2>

            <div class="produtos-grid-compacto">
                @foreach($categoria->produtos as $produto)
                <div class="produto-card-compacto">
                    <div class="mancha-card"></div>
                    
                    <div class="produto-foto-compacta">
                       <img src="{{ asset('fitbia/images/produto/' . $produto->foto_produto) }}" alt="{{ $produto->nome_produto }}">
                    </div>
                    
                    <div class="produto-info-compacta">
                        <span class="tag-fitbia-exclusiva">Natural</span>
                        <h3 class="produto-nome-compacto">{{ $produto->nome_produto }}</h3>
                        <p class="produto-desc-compacto">{{ $produto->descricao_produto }}</p>
                        
                        <div class="fitbia-macros-pills">
                            <span>312 kcal</span>
                            <span>25g prot</span>
                            <span>30g carb</span>
                        </div>

                        <div class="produto-footer-compacto">
                            <span class="produto-preco-compacto">R$ {{ number_format($produto->preco_base_produto, 2, ',', '.') }}</span>
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

    {{-- SCRIPTS DE INTERAÇÃO E FILTROS --}}
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
                })
                .catch(error => {
                    console.error('Erro:', error);
                    alert('Erro ao processar carrinho.');
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

        document.addEventListener("DOMContentLoaded", () => {
            const track = document.getElementById('filtros-track');

            if (track) {
                const originalContent = track.innerHTML;
                track.innerHTML += originalContent;

                let isPaused = false;
                let isDown = false;
                let scrollSpeed = 1;
                let startX, scrollLeft;

                function smoothScroll() {
                    if (!isPaused && !isDown) {
                        track.scrollLeft += scrollSpeed;
                        if (track.scrollLeft >= track.scrollWidth / 2) {
                            track.scrollLeft = 0;
                        }
                    }
                    requestAnimationFrame(smoothScroll);
                }
                requestAnimationFrame(smoothScroll);

                track.addEventListener('mouseenter', () => isPaused = true);
                track.addEventListener('mouseleave', () => isPaused = false);
                track.addEventListener('touchstart', () => isPaused = true);
                track.addEventListener('touchend', () => isPaused = false);

                track.addEventListener('mousedown', (e) => {
                    isDown = true;
                    track.style.cursor = 'grabbing'; 
                    startX = e.pageX - track.offsetLeft;
                    scrollLeft = track.scrollLeft;
                });
                track.addEventListener('mouseup', () => { isDown = false; track.style.cursor = 'pointer'; });
                track.addEventListener('mouseleave', () => { isDown = false; });
                track.addEventListener('mousemove', (e) => {
                    if (!isDown) return;
                    e.preventDefault();
                    const x = e.pageX - track.offsetLeft;
                    const walk = (x - startX) * 2;
                    track.scrollLeft = scrollLeft - walk;
                });
            }

            const urlParams = new URLSearchParams(window.location.search);
            let idCategoriaEscolhida = urlParams.get('cat') || 'todos';

            document.querySelectorAll('.filtro-btn').forEach(btn => {
                btn.classList.remove('ativo');
                if (btn.getAttribute('data-id') === idCategoriaEscolhida) {
                    btn.classList.add('ativo');
                }
            });

            document.querySelectorAll('.categoria-faixa').forEach(faixa => {
                const idFaixa = faixa.getAttribute('data-id');
                if (idCategoriaEscolhida === 'todos' || idFaixa === idCategoriaEscolhida) {
                    faixa.style.display = 'block';
                } else {
                    faixa.style.display = 'none';
                }
            });
        });
    </script>

    {{-- ======================================================== --}}
    {{-- ESTILOS REFINADOS E COMPACTADOS --}}
    {{-- ======================================================== --}}
    <style>
        #filtros-track::-webkit-scrollbar { display: none; }

        .filtro-btn {
            background: #f4f5f6;
            color: #4b5563;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            border-radius: 30px;
            padding: 10px 22px;
            transition: all 0.2s ease;
            border: 1px solid transparent;
            cursor: pointer;
        }
        .filtro-btn:hover { background: #e5e7eb; color: #1f2937; }
        .filtro-btn.ativo {
            background: #2b4230;
            color: #ffffff !important;
            box-shadow: 0 4px 12px rgba(43, 66, 48, 0.2);
        }

        /* ⚡ RETORNADO O GRID PARA COMPACTO (Min 210px) */
        .produtos-grid-compacto {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(210px, 1fr));
            gap: 15px;
        }

        .produto-card-compacto {
            background: #ffffff;
            border-radius: 12px;
            padding: 14px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.02);
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            border: 1px solid rgba(0,0,0,0.02);
        }

        .produto-foto-compacta img {
            width: 100%;
            height: 135px; /* Foto menor e harmônica */
            object-fit: cover;
            border-radius: 8px;
        }

        .tag-fitbia-exclusiva {
            font-size: 9px;
            background: rgba(43, 66, 48, 0.08);
            color: #2b4230;
            font-weight: 700;
            padding: 2px 6px;
            border-radius: 4px;
            text-transform: uppercase;
            display: inline-block;
            margin-bottom: 6px;
        }

        .produto-nome-compacto { font-size: 15px; color: #111; margin: 4px 0; font-weight: 700; }
        .produto-desc-compacto { font-size: 12px; color: #666; line-height: 1.4; margin-bottom: 8px; height: 34px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; }

        .fitbia-macros-pills { display: flex; gap: 5px; margin-bottom: 12px; }
        .fitbia-macros-pills span { font-size: 10px; background: #f3f4f6; color: #4b5563; padding: 2px 6px; border-radius: 12px; font-weight: 500; }

        .produto-footer-compacto { display: flex; justify-content: space-between; align-items: center; margin-top: auto; padding-top: 5px; }
        .produto-preco-compacto { font-size: 17px; font-weight: 800; color: #2b4230; }

        .add-btn-fitbia-clean {
            background: #2b4230;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            transition: opacity 0.2s;
            display: flex;
            align-items: center;
            gap: 4px;
        }
        .add-btn-fitbia-clean:hover { opacity: 0.9; }

        /* MODAIS */
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
    </style>
</section>
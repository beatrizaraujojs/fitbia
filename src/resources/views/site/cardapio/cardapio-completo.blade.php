<section class="cardapio-completo">
    <div class="container">

        @foreach($categorias as $categoria)
        <div class="categoria-bloco" data-id="{{ $categoria->id_categoria }}" style="margin-top: 40px;">
            <h2 class="categoria-titulo">{{ $categoria->nome_categoria }}</h2>

            <div class="produtos-grid">

                @foreach($categoria->produtos as $produto)
                <div class="produto-card">
                    <div class="mancha-card"></div>
                    <div class="produto-foto">
                       <img src="{{ asset('fitbia/images/produto/' . $produto->foto_produto) }}" alt="{{ $produto->nome_produto }}">
                    </div>
                    <div class="produto-info">
                        <h3 class="produto-nome">{{ $produto->nome_produto }}</h3>
                        <p class="produto-desc">{{ $produto->descricao_produto }}</p>
                        <div class="produto-footer">
                            <span class="produto-preco">R$ {{ number_format($produto->preco_base_produto, 2, ',', '.') }}</span>
                            <button class="add-btn" data-id="{{ $produto->id_produto }}" onclick="abrirModal(this)">+</button>
                        </div>
                    </div>
                </div>

                {{-- MODAL DO PRODUTO --}}
                <div class="modal-overlay" id="modal-{{ $produto->id_produto }}">
                    <div class="modal-conteudo">

                        <div class="modal-cabecalho">
                            <h3>{{ $produto->nome_produto }}</h3>
                            <button class="btn-fechar" data-id="{{ $produto->id_produto }}" onclick="fecharModal(this)">×</button>
                        </div>

                        {{-- === INÍCIO DO FORMULÁRIO DO CARRINHO === --}}
                        <form action="{{ route('carrinho.adicionar') }}" method="POST" style="display: flex; flex-direction: column; flex: 1; overflow: hidden;">
                            @csrf
                            <input type="hidden" name="id_produto" value="{{ $produto->id_produto }}">

                            <div class="modal-corpo">

                                @foreach($produto->gruposAdicionais as $grupo)
                                <div class="grupo-adicional" data-max="{{ $grupo->qtd_max_grupo }}" style="margin-bottom: 20px;">
                                    <div class="grupo-titulo">
                                        <h4>{{ $grupo->nome_grupo_adicional }}</h4>
                                        <div>
                                            <span>
                                                @if($grupo->qtd_min_grupo > 0)
                                                (Obrigatório, max {{ $grupo->qtd_max_grupo }})
                                                @else
                                                (Opcional, max {{ $grupo->qtd_max_grupo }})
                                                @endif
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
                                                @if($adicional->preco_adicional > 0)
                                                + R$ {{ number_format($adicional->preco_adicional, 2, ',', '.') }}
                                                @else
                                                Grátis
                                                @endif
                                            </span>
                                        </div>
                                        <div class="controle-qtd">
                                            {{-- IMPORTANTE: type="button" impede o botão de enviar o form sozinho --}}
                                            <button type="button" class="btn-menos" onclick="alterarQtd(this, -1)">-</button>
                                            
                                            <span class="qtd">0</span>
                                            {{-- Este input carrega a quantidade do adicional selecionado --}}
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
                                {{-- Botão agora é do tipo SUBMIT para enviar o formulário --}}
                                <button type="submit" class="btn-avancar">
                                    Avançar R$
                                    <span class="valor-btn" data-base="{{ $produto->preco_base_produto }}">
                                        {{ number_format($produto->preco_base_produto, 2, ',', '.') }}
                                    </span>
                                </button>
                            </div>
                        </form>
                        {{-- === FIM DO FORMULÁRIO === --}}

                    </div>
                </div>
                @endforeach

            </div>
        </div>
        @endforeach

    </div>

    <script>
        // 1. Função para abrir o modal
        function abrirModal(botao) {
            let idProduto = botao.getAttribute('data-id');
            document.getElementById('modal-' + idProduto).style.display = 'flex';
        }

        // 2. Função para fechar o modal
        function fecharModal(botao) {
            let idProduto = botao.getAttribute('data-id');
            document.getElementById('modal-' + idProduto).style.display = 'none';
        }

        // Fecha o modal se clicar no fundo escuro
        window.onclick = function(event) {
            if (event.target.classList.contains('modal-overlay')) {
                event.target.style.display = 'none';
            }
        }

        // 3. Calcula o preço dinâmico do modal
        function atualizarPrecoModal(modal) {
            let spanValor = modal.querySelector('.valor-btn');
            let precoTotal = parseFloat(spanValor.getAttribute('data-base'));

            let linesAdicionais = modal.querySelectorAll('.linha-item');
            linesAdicionais.forEach(linha => {
                let qtd = parseInt(linha.querySelector('.qtd').innerText);
                let precoAdicional = parseFloat(linha.getAttribute('data-preco')) || 0;

                if (qtd > 0 && precoAdicional > 0) {
                    precoTotal += (qtd * precoAdicional);
                }
            });

            spanValor.innerText = precoTotal.toLocaleString('pt-BR', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }

        // 4. CORRIGIDA: Altera quantidade na tela e no input oculto do formulário
        function alterarQtd(botao, valor) {
            let grupo = botao.closest('.grupo-adicional');
            let maxPermitido = parseInt(grupo.getAttribute('data-max'));

            let spanQtdAtual = botao.parentElement.querySelector('.qtd');
            let inputQtdAtual = botao.parentElement.querySelector('.input-qtd'); // Pega o input escondido
            let qtdItemAtual = parseInt(spanQtdAtual.innerText);
            let msgErro = grupo.querySelector('.msg-erro');

            if (valor < 0) {
                if (qtdItemAtual + valor >= 0) {
                    spanQtdAtual.innerText = qtdItemAtual + valor;
                    if (inputQtdAtual) inputQtdAtual.value = qtdItemAtual + valor; // Atualiza o input hidden
                    if (msgErro) msgErro.style.display = 'none';

                    atualizarPrecoModal(botao.closest('.modal-conteudo'));
                }
                return;
            }

            let todosSpansQtd = grupo.querySelectorAll('.qtd');
            let totalAtualDoGrupo = 0;

            todosSpansQtd.forEach(span => {
                totalAtualDoGrupo += parseInt(span.innerText);
            });

            if (totalAtualDoGrupo + valor > maxPermitido) {
                if (msgErro) {
                    msgErro.style.display = 'block';
                    setTimeout(() => { msgErro.style.display = 'none'; }, 2500);
                }
                return;
            }

            spanQtdAtual.innerText = qtdItemAtual + valor;
            if (inputQtdAtual) inputQtdAtual.value = qtdItemAtual + valor; // Atualiza o input hidden

            atualizarPrecoModal(botao.closest('.modal-conteudo'));
        }

        document.addEventListener("DOMContentLoaded", () => {
            const urlParams = new URLSearchParams(window.location.search);
            const idCategoriaEscolhida = urlParams.get('cat');
            const termoBusca = urlParams.get('busca') ? urlParams.get('busca').toLowerCase() : null;

            if (idCategoriaEscolhida) {
                document.querySelectorAll('.filtro-btn').forEach(btn => {
                    btn.classList.remove('ativo');
                    if (btn.getAttribute('data-id') === idCategoriaEscolhida) {
                        btn.classList.add('ativo');
                    }
                });
            }

            document.querySelectorAll('.categoria-bloco').forEach(bloco => {
                let temProdutoVisivel = false;
                const idBloco = bloco.getAttribute('data-id');
                const passaCategoria = !idCategoriaEscolhida || idCategoriaEscolhida === 'todos' || idBloco === idCategoriaEscolhida;

                bloco.querySelectorAll('.produto-card').forEach(card => {
                    const nomeProduto = card.querySelector('.produto-nome').innerText.toLowerCase();
                    const descProduto = card.querySelector('.produto-desc').innerText.toLowerCase();
                    const passaTexto = !termoBusca || nomeProduto.includes(termoBusca) || descProduto.includes(termoBusca);

                    if (passaCategoria && passaTexto) {
                        card.style.display = '';
                        temProdutoVisivel = true;
                    } else {
                        card.style.display = 'none';
                    }
                });

                if (passaCategoria && temProdutoVisivel) {
                    bloco.style.display = 'block';
                } else {
                    bloco.style.display = 'none';
                }
            });
        });
    </script>

    <style>
        /* O seu CSS original do modal permanece intocado aqui */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            z-index: 9999;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .modal-conteudo {
            background-color: #ffffff;
            width: 90%;
            max-width: 400px;
            border-radius: 15px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            max-height: 90vh;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        .modal-cabecalho {
            padding: 15px 20px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-cabecalho h3 {
            margin: 0;
            color: #2c4230;
            font-size: 18px;
        }

        .btn-fechar {
            background: none;
            border: none;
            font-size: 28px;
            cursor: pointer;
            color: #999;
        }

        .modal-corpo {
            padding: 20px;
            overflow-y: auto;
        }

        .grupo-titulo {
            background-color: #f1f1f1;
            padding: 10px;
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-radius: 6px;
        }

        .grupo-titulo h4 {
            margin: 0;
            color: #333;
            font-size: 14px;
        }

        .grupo-titulo span {
            color: #d32f2f;
            font-size: 12px;
            font-weight: bold;
        }

        .linha-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #eee;
        }

        .info-item {
            display: flex;
            flex-direction: column;
        }

        .info-item .nome {
            font-weight: bold;
            color: #333;
            font-size: 14px;
        }

        .info-item .preco {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
        }

        .controle-qtd {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .controle-qtd button {
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 6px;
            width: 30px;
            height: 30px;
            font-size: 18px;
            cursor: pointer;
        }

        .controle-qtd .qtd {
            font-weight: bold;
            font-size: 16px;
            width: 15px;
            text-align: center;
        }

        .campo-observacao textarea {
            width: 100%;
            box-sizing: border-box;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            margin-top: 20px;
            height: 80px;
            resize: none;
            font-family: inherit;
        }

        .modal-rodape {
            padding: 15px 20px;
            border-top: 1px solid #eee;
        }

        .btn-avancar {
            width: 100%;
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 15px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }

        .btn-avancar:hover {
            background-color: #45a049;
        }
    </style>
</section>
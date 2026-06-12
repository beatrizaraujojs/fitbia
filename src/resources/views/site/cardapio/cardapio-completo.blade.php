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

                <div class="modal-overlay" id="modal-{{ $produto->id_produto }}">
                    <div class="modal-conteudo">

                        <div class="modal-cabecalho">
                            <h3>{{ $produto->nome_produto }}</h3>
                            <button class="btn-fechar" data-id="{{ $produto->id_produto }}" onclick="fecharModal(this)">×</button>
                        </div>

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
                                        <button class="btn-menos" onclick="alterarQtd(this, -1)">-</button>
                                        <span class="qtd">0</span>
                                        <button class="btn-mais" onclick="alterarQtd(this, 1)">+</button>
                                    </div>
                                </div>
                                @endforeach

                            </div>
                            @endforeach

                            <div class="campo-observacao">
                                <textarea placeholder="Alguma observação? Ex: Tirar cebola..."></textarea>
                            </div>
                        </div>

                        <div class="modal-rodape">
                            <button class="btn-avancar" data-id="{{ $produto->id_produto }}" onclick="adicionarAoCarrinho(this)">
                                Avançar R$
                                <span class="valor-btn" data-base="{{ $produto->preco_base_produto }}">
                                    {{ number_format($produto->preco_base_produto, 2, ',', '.') }}
                                </span>
                            </button>
                        </div>

                    </div>
                </div>
                @endforeach

            </div>
        </div>
        @endforeach

    </div>

    <script>
        // Variável global para o carrinho (começa zerada)
        let totalItensCarrinho = 0;

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

        // 3. NOVA FUNÇÃO: Calcula o preço dinâmico do modal
        function atualizarPrecoModal(modal) {
            let spanValor = modal.querySelector('.valor-btn');
            let precoTotal = parseFloat(spanValor.getAttribute('data-base'));

            let linhasAdicionais = modal.querySelectorAll('.linha-item');
            linhasAdicionais.forEach(linha => {
                let qtd = parseInt(linha.querySelector('.qtd').innerText);
                // Pega o valor ou considera 0 se for grátis
                let precoAdicional = parseFloat(linha.getAttribute('data-preco')) || 0;

                if (qtd > 0 && precoAdicional > 0) {
                    precoTotal += (qtd * precoAdicional); // Soma (Qtd x Preço)
                }
            });

            // Formata para o padrão R$ 0,00 e joga na tela
            spanValor.innerText = precoTotal.toLocaleString('pt-BR', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }

        // 4. ATUALIZADA: Função dos botões de + e -
        function alterarQtd(botao, valor) {
            let grupo = botao.closest('.grupo-adicional');
            let maxPermitido = parseInt(grupo.getAttribute('data-max'));

            let spanQtdAtual = botao.parentElement.querySelector('.qtd');
            let qtdItemAtual = parseInt(spanQtdAtual.innerText);
            let msgErro = grupo.querySelector('.msg-erro');

            // Se for para diminuir (-1)
            if (valor < 0) {
                if (qtdItemAtual + valor >= 0) {
                    spanQtdAtual.innerText = qtdItemAtual + valor;
                    if (msgErro) msgErro.style.display = 'none';

                    // Atualiza o preço ao diminuir
                    atualizarPrecoModal(botao.closest('.modal-conteudo'));
                }
                return;
            }

            // Se for para aumentar (+1)
            let todosSpansQtd = grupo.querySelectorAll('.qtd');
            let totalAtualDoGrupo = 0;

            todosSpansQtd.forEach(span => {
                totalAtualDoGrupo += parseInt(span.innerText);
            });

            // Trava do limite
            if (totalAtualDoGrupo + valor > maxPermitido) {
                if (msgErro) {
                    msgErro.style.display = 'block';
                    setTimeout(() => {
                        msgErro.style.display = 'none';
                    }, 2500);
                }
                return;
            }

            spanQtdAtual.innerText = qtdItemAtual + valor;

            // Atualiza o preço ao aumentar
            atualizarPrecoModal(botao.closest('.modal-conteudo'));
        }

        // 5. ATUALIZADA: Função de enviar para o carrinho
        function adicionarAoCarrinho(botao) {

            alert("O navegador ouviu o clique! O JavaScript está vivo!");

            let idProduto = botao.getAttribute('data-id');
            let modal = document.getElementById('modal-' + idProduto);
            let observacao = modal.querySelector('.campo-observacao textarea').value;

            let adicionaisEscolhidos = [];
            let linhasAdicionais = modal.querySelectorAll('.linha-item');

            linhasAdicionais.forEach(linha => {
                let qtd = parseInt(linha.querySelector('.qtd').innerText);
                if (qtd > 0) {
                    let idAdicional = linha.getAttribute('data-id-adicional');
                    adicionaisEscolhidos.push({
                        id: idAdicional,
                        quantidade: qtd
                    });
                }
            });

            let itemCarrinho = {
                produto_id: idProduto,
                adicionais: adicionaisEscolhidos,
                observacao: observacao
            };

            // ---- A MÁGICA DO FETCH COMEÇA AQUI ----

            // 1. Pega o carimbo de segurança que colocamos no Passo 1
            let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // 2. Muda o texto do botão para o usuário ver que está carregando
            let btnAvancar = modal.querySelector('.btn-avancar');
            let textoOriginal = btnAvancar.innerHTML;
            btnAvancar.innerHTML = "Adicionando...";
            btnAvancar.disabled = true;

            // 3. O Entregador (Fetch) levando os dados pro Laravel
            // Substitua por isto:
            fetch('{{ route("carrinho.adicionar") }}', {

                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify(itemCarrinho)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.sucesso) {
                        // Atualiza a bolinha vermelha no header!
                        let bolinhaCarrinho = document.getElementById('contador-carrinho');
                        if (bolinhaCarrinho) {
                            bolinhaCarrinho.innerText = data.totalItens;
                            bolinhaCarrinho.style.display = 'inline-block';
                        }

                        // Volta o botão ao normal e fecha o modal
                        btnAvancar.innerHTML = textoOriginal;
                        btnAvancar.disabled = false;

                        let btnFechar = modal.querySelector('.btn-fechar');
                        fecharModal(btnFechar);
                    }
                })
                .catch(error => {
                    console.error("Erro ao adicionar no carrinho:", error);
                    alert("Erro ao enviar! Confira o console.");

                    // Volta o botão ao normal se der erro
                    btnAvancar.innerHTML = textoOriginal;
                    btnAvancar.disabled = false;
                });
        }


        document.addEventListener("DOMContentLoaded", () => {
            // 1. Pega o que está na URL
            const urlParams = new URLSearchParams(window.location.search);
            const idCategoriaEscolhida = urlParams.get('cat');

            // Pega o texto da busca e transforma tudo em minúsculo para não ter erro de maiúscula/minúscula
            const termoBusca = urlParams.get('busca') ? urlParams.get('busca').toLowerCase() : null;

            // 2. Destaca o botão de categoria correto lá no topo
            if (idCategoriaEscolhida) {
                document.querySelectorAll('.filtro-btn').forEach(btn => {
                    btn.classList.remove('ativo');
                    if (btn.getAttribute('data-id') === idCategoriaEscolhida) {
                        btn.classList.add('ativo');
                    }
                });
            }

            // 3. O super filtro: Categoria + Pesquisa de Texto
            document.querySelectorAll('.categoria-bloco').forEach(bloco => {
                let temProdutoVisivel = false;
                const idBloco = bloco.getAttribute('data-id');

                // Confere se o bloco atual é da categoria que o cliente quer ver
                const passaCategoria = !idCategoriaEscolhida || idCategoriaEscolhida === 'todos' || idBloco === idCategoriaEscolhida;

                // Agora varre cada prato dentro desse bloco
                bloco.querySelectorAll('.produto-card').forEach(card => {
                    const nomeProduto = card.querySelector('.produto-nome').innerText.toLowerCase();
                    const descProduto = card.querySelector('.produto-desc').innerText.toLowerCase();

                    // Confere se a palavra pesquisada existe no título ou na descrição do prato
                    const passaTexto = !termoBusca || nomeProduto.includes(termoBusca) || descProduto.includes(termoBusca);

                    // Se bateu com a categoria E tem a palavra pesquisada, mostra o card!
                    if (passaCategoria && passaTexto) {
                        card.style.display = ''; // Deixa o CSS original agir
                        temProdutoVisivel = true;
                    } else {
                        card.style.display = 'none'; // Esconde o card
                    }
                });

                // Se a categoria inteira ficou sem nenhum produto após a busca (ex: buscou "salmão" na categoria "bebidas"), esconde o título da categoria
                if (passaCategoria && temProdutoVisivel) {
                    bloco.style.display = 'block';
                } else {
                    bloco.style.display = 'none';
                }
            });
        });
    </script>

    <style>
        /* --- SEU CSS COMPLETO DO MODAL SE MANTÉM EXATAMENTE AQUI IGUAL --- */
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
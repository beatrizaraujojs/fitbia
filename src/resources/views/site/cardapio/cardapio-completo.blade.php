


    <section class="cardapio-completo">
    <div class="container">
        
        @foreach($categorias as $categoria)
            <div class="categoria-bloco" style="margin-top: 40px;">
                <h2 class="categoria-titulo">{{ $categoria->nome_categoria }}</h2>
                
                <div class="produtos-grid">
                    
                    @foreach($categoria->produtos as $produto)
                        <div class="produto-card">
                            <div class="mancha-card"></div>
                            <div class="produto-foto">
                                <img src="https://images.unsplash.com/photo-1546069901-ba9599a7e63c?q=80&w=500" alt="{{ $produto->nome_produto }}">
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
                                        <div class="grupo-adicional" style="margin-bottom: 20px;">
                                            <div class="grupo-titulo">
                                                <h4>{{ $grupo->nome_grupo_adicional }}</h4>
                                                <span>
                                                    @if($grupo->qtd_min_grupo > 0)
                                                        (Obrigatório, max {{ $grupo->qtd_max_grupo }})
                                                    @else
                                                        (Opcional, max {{ $grupo->qtd_max_grupo }})
                                                    @endif
                                                </span>
                                            </div>

                                            @foreach($grupo->adicionais as $adicional)
                                                <div class="linha-item">
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
                                    <button class="btn-avancar">Avançar R$ {{ number_format($produto->preco_base_produto, 2, ',', '.') }}</button>
                                </div>

                            </div>
                        </div>
                        @endforeach </div>
            </div>
        @endforeach </div>






        <script>


// Função para abrir o modal
function abrirModal(botao) {
    // Pega o ID que guardamos no 'data-id' do botão
    let idProduto = botao.getAttribute('data-id'); 
    document.getElementById('modal-' + idProduto).style.display = 'flex';
}

// Função para fechar o modal
function fecharModal(botao) {
    // Pega o ID que guardamos no 'data-id' do botão
    let idProduto = botao.getAttribute('data-id'); 
    document.getElementById('modal-' + idProduto).style.display = 'none';
}

    // Fecha o modal se clicar no fundo escuro de qualquer um deles
    window.onclick = function(event) {
        if (event.target.classList.contains('modal-overlay')) {
            event.target.style.display = 'none';
        }
    }

    // Função dos botões de + e - (continua idêntica e super inteligente)
   function alterarQtd(botao, valor) {
    // 1. Encontra o grupo inteiro onde este item está
    let grupo = botao.closest('.grupo-adicional');
    let maxPermitido = parseInt(grupo.getAttribute('data-max'));
    
    // 2. Encontra o span de quantidade do item específico que foi clicado
    let spanQtdAtual = botao.parentElement.querySelector('.qtd');
    let qtdItemAtual = parseInt(spanQtdAtual.innerText);
    let msgErro = grupo.querySelector('.msg-erro');
    
    // --- SE FOR PARA DIMINUIR O ITEM (-1) ---
    if (valor < 0) {
        if (qtdItemAtual + valor >= 0) {
            spanQtdAtual.innerText = qtdItemAtual + valor;
            // Esconde a mensagem de erro se o usuário resolveu diminuir algo
            if (msgErro) msgErro.style.display = 'none';
        }
        return; // Interrompe aqui pois diminuir nunca estoura o máximo
    }
    
    // --- SE FOR PARA AUMENTAR O ITEM (+1) ---
    // 3. Soma a quantidade atual de TODOS os adicionais deste grupo
    let todosSpansQtd = grupo.querySelectorAll('.qtd');
    let totalAtualDoGrupo = 0;
    
    todosSpansQtd.forEach(span => {
        totalAtualDoGrupo += parseInt(span.innerText);
    });
    
    // 4. Valida se a nova adição vai passar do limite do grupo
    if (totalAtualDoGrupo + valor > maxPermitido) {
        // Mostra a mensagem de erro vermelha
        if (msgErro) {
            msgErro.style.display = 'block';
            
            // Efeito extra: Faz a mensagem sumir sozinha após 2.5 segundos
            setTimeout(() => {
                msgErro.style.display = 'none';
            }, 2500);
        }
        return; // 🛑 INTERROMPE A CONTAGEM (não faz nada)
    }
    
    // 5. Se passou em todas as regras, atualiza o número na tela
    spanQtdAtual.innerText = qtdItemAtual + valor;
}
</script>

<style>
    /* --- ESTILOS APENAS DO MODAL --- */
    .modal-overlay {
        display: none; 
        position: fixed;
        top: 0; left: 0; width: 100%; height: 100%;
        background-color: rgba(0,0,0,0.6);
        z-index: 9999; 
        justify-content: center;
        align-items: center;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .modal-conteudo {
        background-color: #ffffff; /* ISSO AQUI VAI DEIXAR A CAIXA BRANCA! */
        width: 90%;
        max-width: 400px;
        border-radius: 15px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        max-height: 90vh;
        box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    }

    .modal-cabecalho {
        padding: 15px 20px;
        border-bottom: 1px solid #eee;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-cabecalho h3 { margin: 0; color: #2c4230; font-size: 18px; }

    .btn-fechar {
        background: none; border: none; font-size: 28px; cursor: pointer; color: #999;
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
    .grupo-titulo h4 { margin: 0; color: #333; font-size: 14px; }
    .grupo-titulo span { color: #d32f2f; font-size: 12px; font-weight: bold; }

    .linha-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 0;
        border-bottom: 1px solid #eee;
    }

    .info-item { display: flex; flex-direction: column; }
    .info-item .nome { font-weight: bold; color: #333; font-size: 14px; }
    .info-item .preco { font-size: 12px; color: #666; margin-top: 5px; }

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

    .controle-qtd .qtd { font-weight: bold; font-size: 16px; width: 15px; text-align: center; }

    .campo-observacao textarea {
        width: 100%; box-sizing: border-box; padding: 10px;
        border: 1px solid #ccc; border-radius: 8px; margin-top: 20px;
        height: 80px; resize: none; font-family: inherit;
    }

    .modal-rodape {
        padding: 15px 20px;
        border-top: 1px solid #eee;
    }

    .btn-avancar {
        width: 100%; background-color: #4CAF50; color: white;
        border: none; padding: 15px; border-radius: 8px;
        font-size: 16px; font-weight: bold; cursor: pointer;
    }
    .btn-avancar:hover { background-color: #45a049; }
</style>

</section>
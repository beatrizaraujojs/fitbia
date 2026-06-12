<section class="cardapio-produtos">
    <div class="container">

        <div class="secao-header">
            <span class="subtitulo">NOSSO CARDÁPIO</span>
            <h2 class="titulo-secao">Escolha sua <span class="destaque">Fit Bia</span> do dia</h2>
        </div>

        <div class="carrossel-wrapper">
            <button class="seta-carrossel esquerda" onclick="moverCarrossel(-1)">
                <i class="ph ph-caret-left"></i>
            </button>
            
            <div class="carrossel-container">
                <div class="produtos-carrossel-track" id="carrossel-track">
                    
                    @foreach($categorias as $categoria)
                        @php $nomeCategoria = Str::lower($categoria->nome_categoria); @endphp

                        {{-- 🚫 Ignora apenas os Combos. Todo o resto (Marmitas, Bebidas, Doces, Saladas) vai entrar na fila para passar --}}
                        @if(!Str::contains($nomeCategoria, 'combo'))
                            
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
                                            
                                            <button class="add-btn" data-id="{{ $produto->id_produto }}" onclick="abrirModal(this)">
                                                <i class="ph ph-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        @endif
                    @endforeach

                </div>
            </div>

            <button class="seta-carrossel direita" onclick="moverCarrossel(1)">
                <i class="ph ph-caret-right"></i>
            </button>
        </div>
    </div>

    <style>
        .carrossel-wrapper { position: relative; display: flex; align-items: center; gap: 10px; width: 100%; }
        .carrossel-container { overflow: hidden; width: 100%; padding: 15px 5px; }
        .produtos-carrossel-track { display: flex; gap: 20px; transition: transform 0.4s ease-in-out; }
        .produtos-carrossel-track .produto-card { min-width: calc(25% - 15px); box-sizing: border-box; }
        
        @media (max-width: 1024px) { .produtos-carrossel-track .produto-card { min-width: calc(33.333% - 14px); } }
        @media (max-width: 768px) { .produtos-carrossel-track .produto-card { min-width: calc(50% - 10px); } }
        @media (max-width: 480px) { .produtos-carrossel-track .produto-card { min-width: 100%; } }
        
        .seta-carrossel { background-color: #ffffff; border: none; width: 25px; height: 25px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 22px; cursor: pointer; box-shadow: 0 4px 12px rgba(0,0,0,0.15); color: #2c4230; z-index: 10; transition: all 0.2s; flex-shrink: 0; }
        .seta-carrossel:hover { background-color: #4CAF50; color: white; }

        /* 🚨 DOMANDO A BOLINHA GIGANTE: */
        .produto-footer {
            display: flex;
            justify-content: space-between;
            align-items: center; /* Alinha verticalmente o preço e o botão */
            width: 100%;
        }

        .produto-footer .add-btn {
            width: 36px !important;
            height: 36px !important;
            border-radius: 50% !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            flex-shrink: 0 !important; /* ❌ IMPEDE O FLEXBOX DE ESTICAR O BOTÃO */
            padding: 0 !important;
            box-sizing: border-box !important;
        }
    </style>

    <script>
        let posicaoAtual = 0;
        let tempoAutoPlay;

        function moverCarrossel(direcao) {
            const track = document.getElementById('carrossel-track');
            const cards = track.querySelectorAll('.produto-card');
            
            if (cards.length === 0) return;

            const cardWidth = cards[0].offsetWidth + 20; 
            const containerVisibleWidth = track.parentElement.offsetWidth;
            const maxScroll = track.scrollWidth - containerVisibleWidth;
            
            posicaoAtual += direcao;
            let novoDeslocamento = posicaoAtual * cardWidth;

            // Loop infinito suave: chegou no final da fila de produtos, reseta pro começo
            if (novoDeslocamento > maxScroll || novoDeslocamento < 0) {
                posicaoAtual = 0;
                novoDeslocamento = 0;
            }

            track.style.transform = `translateX(-${novoDeslocamento}px)`;
            resetarTempoAutoPlay();
        }

        function iniciarAutoPlay() {
            tempoAutoPlay = setInterval(() => {
                moverCarrossel(1);
            }, 3000); // Passa sozinho a cada 3 segundos
        }

        function resetarTempoAutoPlay() {
            clearInterval(tempoAutoPlay);
            iniciarAutoPlay();
        }

        document.addEventListener("DOMContentLoaded", () => {
            iniciarAutoPlay();

            const container = document.querySelector('.carrossel-container');
            container.addEventListener('mouseenter', () => clearInterval(tempoAutoPlay));
            container.addEventListener('mouseleave', () => iniciarAutoPlay());
        });
    </script>
</section>
<div class="filtros-bar" style="width: 100%; overflow: hidden; padding: 15px 0;">
    
    {{-- O "Trilho" ocupando 100% da tela --}}
    <div class="filtros-container" id="filtros-track" style="display: flex; flex-wrap: nowrap; overflow-x: auto; gap: 12px; padding: 0 20px; width: 100%; scrollbar-width: none; -ms-overflow-style: none; align-items: center;">
        
        <a href="{{ route('site.cardapio') }}" class="filtro-btn {{ !request('cat') ? 'ativo' : '' }}" data-id="todos" style="flex: 0 0 auto; white-space: nowrap;">
            Todos
        </a>

        @foreach($categorias as $categoria)
            <a href="{{ route('site.cardapio') }}?cat={{ $categoria->id_categoria }}" class="filtro-btn {{ request('cat') == $categoria->id_categoria ? 'ativo' : '' }}" data-id="{{ $categoria->id_categoria }}" style="flex: 0 0 auto; white-space: nowrap;">
                {{ $categoria->nome_categoria }}
            </a>
        @endforeach

    </div>
</div>

<style>
    /* Esconde a barra de rolagem nativa */
    #filtros-track::-webkit-scrollbar {
        display: none;
    }

    /* Estilo dos botões */
    .filtro-btn {
        background-color: #f3f4f6;
        color: #4b5563;
        border-radius: 50px;
        padding: 10px 24px;
        font-size: 14px;
        font-weight: 600;
        transition: all 0.3s ease;
        border: 1px solid transparent;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
    }

    .filtro-btn:not(.ativo):hover {
        background-color: #e5e7eb;
        color: var(--verde-escuro, #2D4030);
        transform: translateY(-2px);
    }

    .filtro-btn.ativo {
        background-color: var(--verde-escuro, #2D4030);
        color: #ffffff !important;
        box-shadow: 0 4px 15px rgba(45, 64, 48, 0.2);
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const track = document.getElementById('filtros-track');

        if (track) {
            // Verifica se a pessoa fez uma busca na URL
            const urlParams = new URLSearchParams(window.location.search);
            const isBuscando = urlParams.has('busca') && urlParams.get('busca') !== '';
            
            // Conta quantos botões sobraram na tela
            const numeroDeBotoes = track.querySelectorAll('.filtro-btn').length;

            let isDown = false;
            let startX;
            let scrollLeft;

            // 1. ARRASTAR MANUALMENTE COM O MOUSE (Funciona sempre)
            track.addEventListener('mousedown', (e) => {
                isDown = true;
                track.style.cursor = 'grabbing'; 
                startX = e.pageX - track.offsetLeft;
                scrollLeft = track.scrollLeft;
            });

            track.addEventListener('mouseup', () => {
                isDown = false;
                track.style.cursor = 'pointer';
            });

            track.addEventListener('mouseleave', () => {
                isDown = false;
                track.style.cursor = 'pointer';
            });

            track.addEventListener('mousemove', (e) => {
                if (!isDown) return;
                e.preventDefault();
                const x = e.pageX - track.offsetLeft;
                const walk = (x - startX) * 2; // Velocidade de arrasto manual
                track.scrollLeft = scrollLeft - walk;
            });

            // 2. LÓGICA INTELIGENTE DO CARROSSEL INFINITO
            // Só duplica e roda sozinho se NÃO for uma pesquisa E tiver mais de 4 categorias na tela
            if (!isBuscando && numeroDeBotoes > 4) {
                const originalContent = track.innerHTML;
                track.innerHTML += originalContent; // Duplica os botões

                let isPaused = false;
                let scrollSpeed = 1; 

                function smoothScroll() {
                    if (!isPaused && !isDown) {
                        track.scrollLeft += scrollSpeed;
                        if (track.scrollLeft >= track.scrollWidth / 2) {
                            track.scrollLeft = 0;
                        }
                    }
                    requestAnimationFrame(smoothScroll);
                }

                // Inicia o deslizamento contínuo
                requestAnimationFrame(smoothScroll);

                // Pausar ao passar o mouse ou tocar no celular
                track.addEventListener('mouseenter', () => isPaused = true);
                track.addEventListener('mouseleave', () => isPaused = false);
                track.addEventListener('touchstart', () => isPaused = true);
                track.addEventListener('touchend', () => isPaused = false);
            }
        }
    });
</script>
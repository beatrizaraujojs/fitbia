<div class="filtros-bar" style="width: 100%; overflow: hidden; padding: 15px 0;">
    
    {{-- O "Trilho" ocupando 100% da tela --}}
    <div class="filtros-container" id="filtros-track" style="display: flex; overflow-x: auto; gap: 12px; padding: 0 20px; width: 100%; scrollbar-width: none; -ms-overflow-style: none;">
        
        <a href="{{ route('site.cardapio') }}" class="filtro-btn ativo" data-id="todos" style="flex: 0 0 auto; white-space: nowrap;">
            Todos
        </a>

        @foreach($categorias as $categoria)
            <a href="{{ route('site.cardapio') }}?cat={{ $categoria->id_categoria }}" class="filtro-btn" data-id="{{ $categoria->id_categoria }}" style="flex: 0 0 auto; white-space: nowrap;">
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
</style>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const track = document.getElementById('filtros-track');

        if (track) {
            // TRUQUE DO LOOP INFINITO: Clona os itens e joga no final da lista
            const originalContent = track.innerHTML;
            track.innerHTML += originalContent; // Duplica os botões para não dar espaço em branco

            let isPaused = false;
            let scrollSpeed = 1; // Velocidade do deslizamento (1 pixel por frame)

            // Função que faz o carrossel andar suavemente sem parar
            function smoothScroll() {
                if (!isPaused && !isDown) {
                    track.scrollLeft += scrollSpeed;

                    // Se rolou até a metade (onde começa a cópia), volta pro início sem ninguém perceber
                    if (track.scrollLeft >= track.scrollWidth / 2) {
                        track.scrollLeft = 0;
                    }
                }
                requestAnimationFrame(smoothScroll);
            }

            // Inicia o deslizamento contínuo
            requestAnimationFrame(smoothScroll);

            // --- PAUSAR O DESLIZAMENTO SE O MOUSE PASSAR POR CIMA ---
            track.addEventListener('mouseenter', () => isPaused = true);
            track.addEventListener('mouseleave', () => isPaused = false);
            
            // Pausa no celular ao tocar na tela
            track.addEventListener('touchstart', () => isPaused = true);
            track.addEventListener('touchend', () => isPaused = false);


            // --- ARRASTAR COM O MOUSE (DESKTOP) ---
            let isDown = false;
            let startX;
            let scrollLeft;

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
        }
    });
</script>
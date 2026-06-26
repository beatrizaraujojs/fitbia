<section class="local-casinha">
    <div class="container">
        
        <div class="local-header">
            <span class="subtitulo">NOSSO ESPAÇO</span>
            <h2 class="titulo-secao">Onde a mágica ganha sabor.</h2>
            <p class="desc-local">
                Um ambiente projetado com os mais altos padrões de higiene da alta gastronomia, mas sem perder aquele toque acolhedor de casa. Sinta-se à vontade.
            </p>
        </div>

        {{-- GRID DO MOSAICO: TEMA INSTAGRAM (VÍDEO NO BLOCO MAIOR) --}}
        <div class="galeria-grid">
            
            {{-- 1. REELS PRINCIPAL (BLOCO MAIOR - ESQUERDA) --}}
            <a href="https://www.instagram.com/reel/DJCepK5pqJp/?utm_source=ig_web_copy_link&igsh=MzRlODBvNWFlZA==" target="_blank" class="img-galeria foto-destaque" style="display: block; text-decoration: none;">
                <img src="{{ asset('fitbia/images/produto/capavideo1.jpg') }}" alt="Reels Principal" style="width: 100%; height: 100%; object-fit: cover; border-radius: inherit;">
            </a>
            
            {{-- 2. IMAGEM DO FEED (TOPO DIREITA) --}}
            <img src="{{ asset('fitbia/images/produto/instabia.png') }}" alt="Nosso Feed" class="img-galeria">
            
            {{-- 3. REELS SECUNDÁRIO (BASE DIREITA) --}}
            <a href="https://www.instagram.com/reel/DI6LtGqx8eL/?utm_source=ig_web_copy_link&igsh=MzRlODBvNWFlZA==" target="_blank" class="img-galeria" style="display: block; text-decoration: none;">
                <img src="{{ asset('fitbia/images/produto/capavideo2.jpg') }}" alt="Reels Secundário" style="width: 100%; height: 100%; object-fit: cover; border-radius: inherit;">
            </a>

        </div>

        <div class="local-info">
            <div class="info-item">
                <i class="ph ph-map-pin"></i>
                <div>
                    <strong>Venha nos visitar</strong>
                    <span>Rua da Natureza, 123 - Jardins, SP</span>
                </div>
            </div>
            <div class="info-item">
                <i class="ph ph-clock"></i>
                <div>
                    <strong>Horário de Funcionamento</strong>
                    <span>Segunda a Sexta, das 08h às 18h</span>
                </div>
            </div>
        </div>

    </div>
</section>


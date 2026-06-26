<style>
    /* ==========================================
       SEÇÃO PROPÓSITO E METAS INTELIGENTES
       ========================================== */
    .proposito-casinha {
        background-color: var(--bg-principal);
        padding: 120px 0;
        overflow: hidden;
    }

    .proposito-grid {
        display: flex;
        align-items: center;
        gap: 80px;
    }

    /* Lado Esquerdo - Texto e Metas */
    .proposito-texto {
        flex: 1;
    }

    .proposito-texto .subtitulo {
        color: var(--verde-folha);
        font-weight: 700;
        letter-spacing: 2px;
        display: block;
        margin-bottom: 15px;
    }

    .proposito-texto .titulo-secao {
        font-size: 40px;
        color: var(--verde-escuro);
        line-height: 1.2;
        margin-bottom: 25px;
    }

    .desc-proposito {
        font-size: 16px;
        color: #555;
        line-height: 1.8;
        margin-bottom: 40px;
    }

    /* Estilo das Metas Inteligentes (Chique e Minimalista) */
    .metas-container {
        display: flex;
        flex-direction: column;
        gap: 25px;
    }

    .meta-item {
        display: flex;
        gap: 20px;
        padding-top: 25px;
        border-top: 1px solid rgba(0,0,0,0.08); /* Linha divisória elegante */
    }

    .meta-numero {
        font-family: 'Montserrat', sans-serif;
        font-size: 24px;
        font-weight: 700;
        color: var(--verde-folha);
        opacity: 0.8;
    }

    .meta-conteudo h4 {
        font-size: 18px;
        color: var(--verde-escuro);
        margin-bottom: 8px;
        font-weight: 600;
    }

    .meta-conteudo p {
        font-size: 14px;
        color: #666;
        line-height: 1.6;
    }

    /* Lado Direito - Composição de Fotos Editorial */
    .proposito-fotos {
        flex: 1;
        position: relative;
        height: 600px;
        display: flex;
        align-items: center;
    }

    .foto-comp {
        position: absolute;
        border-radius: 12px;
        box-shadow: 0 25px 50px rgba(0,0,0,0.1);
        object-fit: cover;
    }

    /* Foto de trás (Maior) */
    .f-principal {
        width: 80%;
        height: 500px;
        right: 0;
        top: 0;
        z-index: 1;
    }

    /* Foto da frente (Menor, sobrepondo e criando profundidade) */
    .f-secundaria {
        width: 55%;
        height: 380px;
        left: 0;
        bottom: 20px;
        z-index: 2;
        border: 8px solid var(--bg-principal);
    }

    /* Selinho flutuante chique */
    .selo-qualidade {
        position: absolute;
        top: 50px;
        left: -20px;
        background-color: var(--verde-escuro);
        color: var(--bg-principal);
        width: 110px;
        height: 110px;
        border-radius: 50%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        z-index: 3;
        box-shadow: 0 15px 30px rgba(61, 90, 53, 0.3);
    }

    .selo-qualidade i {
        font-size: 28px;
        color: var(--verde-folha);
        margin-bottom: 5px;
    }

    .selo-qualidade span {
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    /* ==========================================
       RESPONSIVIDADE PROPÓSITO E METAS
       ========================================== */
    @media (max-width: 992px) {
        .proposito-grid {
            flex-direction: column;
            gap: 60px;
        }

        .proposito-texto {
            text-align: left;
        }

        .proposito-fotos {
            width: 100%;
            height: 500px;
        }

        .f-principal { width: 75%; height: 400px; right: 0; }
        .f-secundaria { width: 60%; height: 300px; bottom: 0; }
    }
    
    @media (max-width: 768px) {
        .proposito-casinha {
            padding: 60px 0;
            overflow: visible; 
        }

        .proposito-grid {
            gap: 30px; 
        }

        .proposito-fotos {
            width: 100%;
            height: auto;
            display: flex;
            justify-content: center;
            position: relative;
            padding: 60px 0;
        }

        .foto-comp {
            position: relative;
            box-shadow: 0 15px 30px rgba(0,0,0,0.2);
        }

        .f-principal {
            width: 65%;
            height: 280px;
            margin-right: -15%; 
            z-index: 1;
            top: -20px;
        }

        .f-secundaria {
            width: 50%;
            height: 200px;
            margin-top: 40px; 
            z-index: 2;
            border: 5px solid var(--bg-principal);
            left: auto; 
        }

        .selo-qualidade {
            display: none;
        }

        .proposito-texto .titulo-secao {
            font-size: 28px;
            margin-bottom: 15px;
            line-height: 1.2;
        }

        .desc-proposito {
            font-size: 14px;
            margin-bottom: 25px;
            line-height: 1.5;
            color: #444;
        }

        .meta-item {
            padding: 15px 0;
            text-align: left;
            border-top: 1px solid rgba(61, 90, 53, 0.1);
        }

        .meta-conteudo h4 {
            font-size: 15px;
            font-weight: 700;
        }
    }

    /* MANCHAS */
    .proposito-casinha::before,
    .proposito-casinha::after {
        content: '';
        position: absolute;
        z-index: 0;
        pointer-events: none; 
    }

    .proposito-casinha::before {
        width: 450px;
        height: 400px;
        background: rgba(61, 90, 53, 0.25); 
        top: -50px;
        right: -100px;
        border-radius: 40% 60% 70% 30% / 40% 40% 60% 50%;
        transform: rotate(-15deg);
    }

    .proposito-casinha::after {
        width: 350px;
        height: 350px;
        background: rgba(139, 174, 124, 0.3); 
        bottom: -50px;
        left: -100px;
        border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%;
    }

    @media (max-width: 768px) {
        .proposito-casinha::before {
            width: 250px;
            height: 220px;
            top: 0;
            right: -50px;
            opacity: 0.4;
        }

        .proposito-casinha::after {
            width: 200px;
            height: 200px;
            bottom: 10%;
            left: -40px;
            opacity: 0.4;
        }
    }

    /* ==========================================
       SEÇÃO DO LOCAL (GALERIA MOSAICO ESCURA)
       ========================================== */
    .local-casinha {
        background-color: var(--verde-escuro); 
        padding: 100px 0;
    }

    .local-header {
        text-align: center;
        max-width: 600px;
        margin: 0 auto 50px auto;
    }

    .local-header .subtitulo {
        color: var(--verde-folha);
        font-weight: 700;
        letter-spacing: 2px;
        display: block;
        margin-bottom: 15px;
    }

    .local-header .titulo-secao {
        font-size: 36px;
        color: var(--bg-principal); 
        line-height: 1.2;
        margin-bottom: 20px;
    }

    .desc-local {
        font-size: 16px;
        color: rgba(255, 255, 255, 0.7); 
        line-height: 1.6;
    }

    .galeria-grid {
        display: grid;
        grid-template-columns: 1.5fr 1fr; 
        grid-template-rows: 250px 250px; 
        gap: 25px; 
        margin-bottom: 50px;
    }

    .img-galeria {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 12px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.6); 
        transition: transform 0.4s ease, box-shadow 0.4s ease;
    }

    .img-galeria:hover {
        transform: scale(1.02);
        box-shadow: 0 30px 60px rgba(0, 0, 0, 0.8); 
        z-index: 2;
        position: relative;
    }

    .foto-destaque {
        grid-row: span 2; 
    }

    .local-info {
        display: flex;
        justify-content: center;
        gap: 60px;
        padding-top: 40px;
        border-top: 1px solid rgba(255, 255, 255, 0.08);
    }

    .info-item {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .info-item i {
        font-size: 32px;
        color: var(--verde-folha);
        background: rgba(255, 255, 255, 0.05); 
        padding: 12px;
        border-radius: 50%;
        box-shadow: 0 10px 20px rgba(0,0,0,0.3);
    }

    .info-item strong {
        display: block;
        color: var(--bg-principal); 
        font-size: 15px;
        margin-bottom: 4px;
    }

    .info-item span {
        color: rgba(255, 255, 255, 0.5); 
        font-size: 14px;
    }

    @media (max-width: 768px) {
        .local-casinha {
            padding: 60px 0;
        }

        .local-header .titulo-secao {
            font-size: 28px;
        }

        .desc-local {
            font-size: 14px;
            padding: 0 10px;
        }

        .galeria-grid {
            grid-template-columns: 1fr;
            grid-template-rows: 300px 200px 200px; 
            gap: 20px;
        }

        .foto-destaque {
            grid-row: auto;
        }

        .local-info {
            flex-direction: column;
            gap: 30px;
            align-items: center;
            text-align: center;
        }

        .info-item {
            flex-direction: column;
            gap: 10px;
        }
    }


    /* ==========================================
       SEÇÃO DO MAPA (LUXURY / LIGHT MODE)
       ========================================== */
    .mapa-luxury {
        background-color: var(--bg-principal);
        padding: 120px 0;
        position: relative; 
        border-top: 1px solid rgba(0, 0, 0, 0.05); 
    }

    .mapa-grid-luxury {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 120px; 
        position: relative;
    }

    /* Lado Esquerdo (Informações Elegantes) */
    .mapa-info-luxury {
        flex: 1;
        z-index: 2; 
    }

    .subtitulo-luxury {
        color: var(--verde-folha);
        font-weight: 600;
        letter-spacing: 3px;
        font-size: 11px; 
        text-transform: uppercase;
        display: block;
        margin-bottom: 25px;
    }

    .titulo-luxury {
        font-family: 'Montserrat', sans-serif; 
        font-size: 48px;
        font-weight: 300;
        color: var(--verde-escuro);
        line-height: 1.2;
        margin-bottom: 35px;
    }

    .desc-luxury {
        font-size: 15px;
        color: #666;
        line-height: 1.8;
        margin-bottom: 50px;
        font-weight: 300;
    }

    /* Lista de Contatos Minimalista */
    .contato-lista-luxury {
        display: flex;
        flex-direction: column;
        gap: 30px;
        margin-bottom: 50px;
    }

    .contato-item-luxury {
        display: flex;
        flex-direction: column;
    }

    .contato-label {
        color: #999;
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: 2px;
        margin-bottom: 8px;
        font-weight: 500;
    }

    .contato-valor {
        color: var(--verde-escuro);
        font-size: 16px;
        line-height: 1.5;
        font-weight: 400;
    }

    /* Botão Estilo Editorial */
    .btn-luxury {
        display: inline-block;
        padding: 12px 0;
        color: var(--verde-escuro);
        text-decoration: none;
        font-weight: 600;
        font-size: 12px;
        letter-spacing: 2px;
        text-transform: uppercase;
        border-bottom: 1px solid var(--verde-escuro);
        transition: all 0.4s ease;
    }

    .btn-luxury:hover {
        color: var(--verde-folha);
        border-bottom-color: var(--verde-folha);
        padding-right: 20px;
    }

    /* --- LADO DIREITO (MAPA) TOTALMENTE CORRIGIDO --- */
    .mapa-frame-luxury {
        flex: 1;
        width: 100%;
        height: 600px; /* Mapa alto no PC */
        position: relative;
        border-radius: 16px; 
        overflow: hidden; /* Corta o mapa nos cantos arredondados */
        z-index: 1;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
        display: block;
    }

    .mapa-frame-luxury iframe {
        position: absolute; /* Prende nos cantos da caixa */
        top: 0;
        left: 0;
        width: 100% !important;
        height: 100% !important;
        border: 0 !important;
        display: block;
        filter: saturate(60%) contrast(105%);
        transition: all 0.3s ease;
    }

    .mapa-frame-luxury iframe:hover {
        filter: saturate(100%) contrast(100%);
    }

    /* A DECORAÇÃO (O Prato no Centro) */
    .decoracao-prato-centro {
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%); 
        z-index: 3; 
        width: 250px;
        height: 250px;
        pointer-events: none; 
        filter: drop-shadow(-10px 15px 20px rgba(0,0,0,0.15)); 
    }

    .decoracao-prato-centro img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    /* ==========================================
       RESPONSIVO (CELULAR E TABLET DO MAPA)
       ========================================== */
    @media (max-width: 992px) {
        .mapa-grid-luxury {
            flex-direction: column;
            gap: 20px; 
            padding: 0 15px;
        }

        .mapa-info-luxury {
            order: 1;
            width: 100%;
        }

        .decoracao-prato-centro {
            position: relative;
            left: auto;
            top: auto;
            transform: none;
            margin: 20px auto -80px auto; 
            width: 150px;
            height: 150px;
            z-index: 5;
            order: 2;
        }

        .mapa-frame-luxury {
            width: 100%;
            height: 400px; 
            min-height: 400px; 
            order: 3;
            border-radius: 16px; 
            margin-top: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            display: block; 
        }
    }

    @media (max-width: 768px) {
        .mapa-luxury {
            padding: 60px 0 80px 0;
        }

        .titulo-luxury {
            font-size: 32px;
        }

        .mapa-frame-luxury {
            height: 380px;
            min-height: 380px;
        }
    }
</style>

<section class="mapa-luxury" id="localizacao">
    <div class="container mapa-grid-luxury">
        
        <div class="mapa-info-luxury">
            <span class="subtitulo-luxury">VISITE NOSSO ESPAÇO</span>
            <h2 class="titulo-luxury">Uma experiência <br>além do sabor.</h2>
            
            <p class="desc-luxury">
                Nossa cozinha de portas abertas. Adoramos receber nossos clientes para um café, mostrar a origem de nossos ingredientes e compartilhar a verdadeira essência da alta gastronomia funcional.
            </p>

            <div class="contato-lista-luxury">
                <div class="contato-item-luxury">
                    <span class="contato-label">Endereço</span>
                    <span class="contato-valor">Rua Cel. Manuel Feliciano de Souza, 662<br>Vila Jacuí, São Paulo - SP</span>
                </div>
                
                <div class="contato-item-luxury">
                    <span class="contato-label">Reservas & Atendimento</span>
                    <span class="contato-valor">(11) 95426-6504</span>
                </div>

                <div class="contato-item-luxury">
                    <span class="contato-label">Horários</span>
                    <span class="contato-valor">Seg à Sex: 09h às 17h | Sáb: 09h às 13h</span>
                </div>
            </div>

            <a href="https://maps.app.goo.gl/cHiJW8O2GgBhzpQR71SK18jmQCo" target="_blank" class="btn-luxury">Ver no Google Maps</a>
        </div>

        <div class="decoracao-prato-centro">
            <img src="https://parspng.com/wp-content/uploads/2023/08/saladpng.parspng.com-14.png" alt="Prato Decorativo Fit Bia" onerror="this.style.display='none'">
        </div>

        <div class="mapa-frame-luxury">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3659.1009893457187!2d-46.46320078864708!3d-23.49283455909289!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94ce63003ab6c35b%3A0x2a40e6c8d7a454ef!2sR.%20Cel.%20Manuel%20Feliciano%20de%20Souza%2C%20662%20-%20Vila%20Jacui%2C%20S%C3%A3o%20Paulo%20-%20SP%2C%2008060-060!5e0!3m2!1spt-BR!2sbr!4v1716942464732!5m2!1spt-BR!2sbr" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>

    </div>
</section>
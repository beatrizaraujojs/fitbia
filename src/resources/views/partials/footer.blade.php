<footer class="footer-escuro">
    <div class="container footer-grid">
        
        <div class="footer-col">
            <div class="logo-wrapper-footer">
               <img src="{{ asset('fitbia/images/produto/FITBIA%20LOGO.svg') }}" alt="Logo Fit Bia" class="footer-logo-img">
            </div>
            <p class="footer-desc">Alimentação saudável, prática e com sabor de verdade. Criada para transformar a sua rotina e trazer bem-estar para o seu dia a dia.</p>
        </div>

        <div class="footer-col">
            <h3>Navegação</h3>
            <ul>
                <li><a href="{{ route('home') }}">Início</a></li>
                <li><a href="{{ route('site.cardapio') }}">Cardápio</a></li>
                <li><a href="{{ route('home') }}#nossa-casinha">Nossa Casinha</a></li>
                <li><a href="{{ route('home') }}#depoimentos">Depoimentos</a></li>
            </ul>
        </div>

        <div class="footer-col">
            <h3>Funcionamento</h3>
            <p>Segunda a Sexta<br><span>09h às 20h</span></p>
            <p>Sábados<br><span>09h às 16h</span></p>
            <p>Domingo<br><span style="opacity: 0.5;">Fechado</span></p>
        </div>

        <div class="footer-col">
            <h3>Contato</h3>
            <p>contato@fitbia.com.br</p>
            
            <p><a href="https://api.whatsapp.com/send?phone=5511954266504" target="_blank" class="footer-whatsapp-link">(11) 95426-6504</a></p>
            
            <div class="footer-sociais">
                <a href="https://instagram.com/fitbiacomidas" target="_blank" aria-label="Instagram"><i class="ph ph-instagram-logo"></i></a>
                <a href="https://api.whatsapp.com/send?phone=5511954266504" target="_blank" aria-label="WhatsApp"><i class="ph ph-whatsapp-logo"></i></a>
            </div>
        </div>

    </div>

    <div class="footer-bottom">
        <div class="container footer-bottom-container">
            <p>&copy; {{ date('Y') }} Fit Bia. Todos os direitos reservados.</p>
            <p>Feito para a Bia</p>
        </div>
    </div>

    <button id="btnVoltarTopo" title="Voltar ao início">
        <i class="ph ph-arrow-up"></i>
    </button>
</footer>

<style>
    .footer-escuro {
        background-color: var(--verde-escuro, #2D4030);
        color: var(--bg-principal, #FAF9F6);
        padding: 100px 0 0 0; /* Mais espaço no topo */
        font-family: 'Inter', sans-serif;
    }

    .footer-escuro .container {
        max-width: 1300px; 
        margin: 0 auto;
        padding: 0 5%;
        width: 100%;
    }

    .footer-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 60px; /* Ótimo espaçamento entre as colunas */
        padding-bottom: 80px; 
        border-bottom: none !important; /* Linha fina ridícula removida com sucesso! */
    }

    .logo-wrapper-footer {
        margin-bottom: 20px;
        display: flex;
        align-items: center;
    }

    .footer-logo-img {
        width: 140px; 
        height: auto; 
        display: block; 
        filter: brightness(0) invert(1); /* Deixa o logo original 100% branco */
    }

    /* Títulos das Colunas */
    .footer-col h3 {
        font-family: 'Montserrat', sans-serif;
        font-size: 16px;
        font-weight: 600;
        color: var(--bg-principal, #FAF9F6);
        margin-bottom: 30px; /* Mais espaço abaixo do título */
        letter-spacing: 1.5px;
        text-transform: uppercase;
        margin-top: 0;
    }

    /* Textos Gerais */
    .footer-col p, .footer-desc {
        color: rgba(250, 249, 246, 0.7);
        font-size: 15px;
        line-height: 1.8; /* Leitura mais leve e espaçada */
        font-weight: 300;
        margin-bottom: 15px;
        margin-top: 0;
    }

    .footer-col p span {
        color: var(--bg-principal, #FAF9F6);
        font-weight: 500;
    }

    /* WhatsApp Link no Texto */
    .footer-whatsapp-link {
        color: inherit !important; 
        text-decoration: none !important; 
        transition: opacity 0.3s ease;
    }

    .footer-whatsapp-link:hover {
        opacity: 0.7;
    }

    /* Menu de Links */
    .footer-col ul {
        list-style-type: none !important; /* Sem bolinhas */
        padding: 0 !important;
        margin: 0 !important;
    }

    .footer-col ul li {
        margin-bottom: 18px; /* Mais espaço entre as linhas do menu */
        padding: 0 !important;
    }

    .footer-col ul li a {
        color: rgba(250, 249, 246, 0.7) !important; 
        text-decoration: none !important; 
        font-size: 15px;
        font-weight: 300;
        display: inline-block;
        transition: color 0.3s ease;
    }

    .footer-col ul li a:hover {
        color: var(--verde-folha, #3C8A4B) !important;
    }

    /* Redes Sociais */
    .footer-sociais {
        display: flex;
        gap: 20px;
        margin-top: 25px;
    }

    .footer-sociais a {
        color: var(--bg-principal, #FAF9F6) !important;
        font-size: 24px;
        text-decoration: none !important;
        transition: transform 0.3s ease, color 0.3s ease;
        display: inline-block;
    }

    .footer-sociais a:hover {
        color: var(--verde-folha, #3C8A4B) !important;
        transform: translateY(-3px);
    }

    /* Faixa de Baixo (Copyright) */
    .footer-bottom {
        background-color: #213023; 
        padding: 30px 0;
    }

    .footer-bottom-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
    }

    .footer-bottom p {
        font-size: 13px;
        color: rgba(250, 249, 246, 0.5);
        margin: 0 !important;
    }

    /* Estilo do Botão Voltar ao Topo */
    #btnVoltarTopo {
        position: fixed;
        bottom: 30px;
        right: 30px;
        background-color: var(--verde-folha, #3C8A4B);
        color: #ffffff;
        border: none;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        font-size: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        
        /* Começa oculto */
        opacity: 0;
        visibility: hidden;
        transform: translateY(20px);
        transition: all 0.3s ease;
        z-index: 999;
    }

    /* Classe ativada pelo JavaScript */
    #btnVoltarTopo.mostrar {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    #btnVoltarTopo:hover {
        background-color: var(--verde-oliva, #30352f);
        transform: translateY(-5px);
    }

    /* Responsividade */
    @media (max-width: 992px) {
        .footer-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 50px;
        }
    }

    @media (max-width: 576px) {
        .footer-escuro { padding-top: 70px; }
        .footer-grid { grid-template-columns: 1fr; gap: 45px; padding-bottom: 50px; }
        .footer-bottom-container { flex-direction: column; gap: 12px; text-align: center; }
        #btnVoltarTopo { bottom: 20px; right: 20px; width: 45px; height: 45px; font-size: 20px; }
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const btnTopo = document.getElementById("btnVoltarTopo");

        if (btnTopo) {
            // Monitoriza a rolagem da página
            window.addEventListener("scroll", function() {
                // Aparece se rolar mais de 300px para baixo
                if (window.scrollY > 300) {
                    btnTopo.classList.add("mostrar");
                } else {
                    btnTopo.classList.remove("mostrar");
                }
            });

            // Executa a subida suave ao clicar
            btnTopo.addEventListener("click", function() {
                window.scrollTo({
                    top: 0,
                    behavior: "smooth" /* Efeito deslize */
                });
            });
        }
    });
</script>
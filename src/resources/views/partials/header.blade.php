
   
   
   <header class="header">
        <div class="container header-container">
            
            <a href="#" class="logo-link" aria-label="Página Inicial">
                <div class="logo-wrapper">
                    FIT BI<span class="letra-a">A<i class="ph-light ph-leaf folha-logo"></i></span>
                </div>
            </a>
        <nav class="nav-menu" id="nav-menu">
<a href="{{ route('home') }}">Home</a>
    
    <div class="menu-item-com-submenu">
        <a href="{{ route('site.cardapio') }}">Cardápio <i class="ph ph-caret-down"></i></a>
        <div class="submenu">
            <a href="cardapio.html#pratos-principais">Pratos Principais</a>
            <a href="cardapio.html#saladas">Saladas Fit</a>
            <a href="cardapio.html#kits">Kits Semanais</a>
            <a href="cardapio.html#lanches">Lanches & Doces</a>
        </div>
    </div>
    
    <div class="menu-item-com-submenu">
        <a href="{{ route('site.casinha') }}">Nossa Casinha <i class="ph ph-caret-down"></i></a>
        <div class="submenu">
            <a href="casinha.html#historia">Nossa História</a>
            <a href="casinha.html#localizacao">Como Chegar</a>
        </div>
    </div>
    
    <div class="menu-item-com-submenu">
        <a href="{{ route('site.contato') }}">Contato <i class="ph ph-caret-down"></i></a>
        <div class="submenu">
            <a href="contato.html#fale-conosco">Fale Conosco</a>
            <a href="contato.html#faq">Perguntas Frequentes</a>
        </div>
    </div>
</nav>  
<div class="header-icones">
    <a href="#" aria-label="Minha Conta" id="btn-login"><i class="ph ph-user"></i></a>
    
    <a href="{{ route('site.checkout') }}" aria-label="Carrinho"><i class="ph ph-shopping-cart"></i></a>
    <button class="menu-toggle" id="menu-toggle" aria-label="Abrir Menu">
        <i class="ph ph-list"></i>
    </button>
</div>

        </div>
    </header>



    <div class="modal-overlay" id="modal-login">
    <div class="modal-box">
        <button class="fechar-modal" id="fechar-modal">&times;</button>
        
        <div class="modal-header">
            <h2>Bem-vindo(a)!</h2>
            <p>Faça login para continuar</p>
        </div>

        <form class="modal-form">
            <div class="input-group">
                <label for="email">E-mail</label>
                <input type="email" id="email" placeholder="Seu e-mail cadastrado" required>
            </div>
            
            <div class="input-group">
                <label for="senha">Senha</label>
                <input type="password" id="senha" placeholder="Sua senha" required>
            </div>

            <button type="submit" class="btn-entrar">Entrar</button>
        </form>

        <div class="modal-footer">
            <p>Ainda não tem conta? <a href="{{ route('site.cadastro') }}">Cadastre-se aqui</a></p>
        </div>
    </div>
</div>

<script>
        document.addEventListener("DOMContentLoaded", () => {
            const btnLogin = document.getElementById("btn-login"); 
            const modal = document.getElementById("modal-login");
            const btnFechar = document.getElementById("fechar-modal");

            btnLogin.addEventListener("click", (e) => {
                e.preventDefault(); 
                modal.style.display = "flex";
            });

            btnFechar.addEventListener("click", () => {
                modal.style.display = "none";
            });

            modal.addEventListener("click", (e) => {
                if (e.target === modal) {
                    modal.style.display = "none";
                }
            });
        });
    </script>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        // Pega todos os itens que têm submenu
        const itensComSubmenu = document.querySelectorAll('.menu-item-com-submenu');

        itensComSubmenu.forEach(item => {
            // Opcional: Se quiser que abra só clicando na setinha, e não no link inteiro
            const linkPai = item.querySelector('a');
            const submenu = item.querySelector('.submenu');

            linkPai.addEventListener('click', (e) => {
                // Se a tela for menor que 992px (mobile)
                if (window.innerWidth <= 992) {
                    // Previne que o link vá para a página principal logo de cara
                    // (Opcional, mas recomendado para navegação mobile)
                    e.preventDefault(); 
                    submenu.classList.toggle('aberto');
                }
            });
        });
    });
</script>


    <script>
        const btnMenu = document.getElementById('menu-toggle');
        const navMenu = document.getElementById('nav-menu');
        const iconeMenu = btnMenu.querySelector('i');

        btnMenu.addEventListener('click', () => {
            // Liga/Desliga a classe 'ativo' no menu
            navMenu.classList.toggle('ativo');
            
            // Troca o ícone de hambúrguer para 'X' ao abrir
            if(navMenu.classList.contains('ativo')) {
                iconeMenu.classList.remove('ph-list');
                iconeMenu.classList.add('ph-x');
            } else {
                iconeMenu.classList.remove('ph-x');
                iconeMenu.classList.add('ph-list');
            }
        });
    </script>


<script src="script.js" defer></script>


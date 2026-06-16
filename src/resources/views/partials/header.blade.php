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

                    {{-- 🔒 TRAVA DE SEGURANÇA: Se a página atual tiver as categorias, lista elas --}}
                    @if(isset($categorias) && count($categorias) > 0)

                    <a href="{{ route('site.cardapio') }}">
                        Todos
                    </a>

                    @foreach($categorias as $categoria)
                    <a href="{{ route('site.cardapio') }}?cat={{ $categoria->id_categoria }}">
                        {{ $categoria->nome_categoria }}
                    </a>
                    @endforeach

                    @else
                    {{-- 🔄 FALLBACK: Caso você esteja em páginas sem acesso direto ao banco --}}
                    <a href="{{ route('site.cardapio') }}">Ver Cardápio Completo</a>
                    @endif

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
            <a href="#" id="btn-abrir-login" aria-label="Minha Conta" title="Ir para Minha Conta">
                <i class="ph ph-user"></i>
            </a>
            {{-- Ícone do Carrinho com Badge Dinâmico --}}
            <a href="{{ route('site.checkout') }}" style="position: relative; display: inline-block; text-decoration: none; color: inherit;">
                <i class="ph ph-shopping-cart" style="font-size: 28px;"></i>

                {{-- Só mostra a bolinha se o carrinho tiver itens --}}
                @if(session('carrinho') && count(session('carrinho')) > 0)
                <span style="position: absolute; top: -5px; right: -10px; background-color: #ef4444; color: white; border-radius: 50%; padding: 2px 6px; font-size: 11px; font-weight: bold; border: 2px solid white;">
                    {{ count(session('carrinho')) }}
                </span>
                @endif
            </a>

            <button class="menu-toggle" id="menu-toggle" aria-label="Abrir Menu">
                <i class="ph ph-list"></i>
            </button>
        </div>

        <div class="modal-overlay" id="modal-login">
            <div class="modal-box">
                <button class="fechar-modal" id="fechar-modal">&times;</button>

                <div class="modal-header">
                    <h2>Bem-vindo(a)!</h2>
                    <p>Faça login para continuar</p>
                </div>

                <div class="input-group">
                    <label for="email">E-mail</label>
                    <input type="email" id="email" name="email_cliente" placeholder="Seu e-mail cadastrado" value="{{ old('email_cliente') }}" required>
                </div>

                <div class="input-group">
                    <label for="senha">Senha</label>
                    <input type="password" id="senha" name="password" placeholder="Sua senha" required>
                </div>

                <button type="submit" class="btn-entrar">Entrar</button>

                <div class="modal-footer">
                    <p>Ainda não tem conta? <a href="{{ route('site.cadastro') }}">Cadastre-se aqui</a></p>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", () => {

                // --- LÓGICA DO MODAL DE LOGIN ---
                const btnLogin = document.getElementById("btn-abrir-login");
                const modal = document.getElementById("modal-login");
                const btnFechar = document.getElementById("fechar-modal");

                if (btnLogin && modal) {
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
                }

                // --- LÓGICA DO SUBMENU MOBILE ---
                const itensComSubmenu = document.querySelectorAll('.menu-item-com-submenu');

                itensComSubmenu.forEach(item => {
                    const linkPai = item.querySelector('a');
                    const submenu = item.querySelector('.submenu');

                    if (linkPai && submenu) {
                        linkPai.addEventListener('click', (e) => {
                            if (window.innerWidth <= 992) {
                                e.preventDefault();
                                submenu.classList.toggle('aberto');
                            }
                        });
                    }
                });

                // --- LÓGICA DO BOTÃO MENU HAMBÚRGUER ---
                const btnMenu = document.getElementById('menu-toggle');
                const navMenu = document.getElementById('nav-menu');

                if (btnMenu && navMenu) {
                    const iconeMenu = btnMenu.querySelector('i');

                    btnMenu.addEventListener('click', () => {
                        navMenu.classList.toggle('ativo');

                        if (navMenu.classList.contains('ativo')) {
                            iconeMenu.classList.remove('ph-list');
                            iconeMenu.classList.add('ph-x');
                        } else {
                            iconeMenu.classList.remove('ph-x');
                            iconeMenu.classList.add('ph-list');
                        }
                    });
                }
            });
        </script>

    </div>
</header>
<style>
    /* --- ESTILOS EXCLUSIVOS DO MENU DO UTILIZADOR (DROPDOWN) --- */
    .wrapper-usuario { 
        position: relative; 
        display: flex; 
        align-items: center; 
        height: 100%; 
    }
    
    .btn-user { 
        display: flex; 
        flex-direction: column; 
        align-items: center; 
        text-decoration: none; 
        color: inherit; 
        cursor: pointer; 
        background: none; 
        border: none; 
    }
    
    .btn-user span { 
        font-size: 13px; 
        font-weight: 600; 
        margin-top: 2px; 
    }
    
    .dropdown-box { 
        visibility: hidden; 
        opacity: 0; 
        position: absolute; 
        top: 130%; 
        right: 50%; 
        transform: translateX(50%); 
        background: #fff; 
        min-width: 160px; 
        box-shadow: 0 10px 25px rgba(0,0,0,0.1); 
        border-radius: 8px; 
        padding: 10px 0; 
        transition: all 0.2s ease; 
        z-index: 9999; 
        border: 1px solid #eee; 
    }
    
    .wrapper-usuario:hover .dropdown-box { 
        visibility: visible; 
        opacity: 1; 
        top: 110%; 
    }
    
    .dropdown-box a, .dropdown-box button { 
        display: block; 
        width: 100%; 
        padding: 10px 20px; 
        text-align: left; 
        color: #333; 
        text-decoration: none; 
        background: transparent; 
        border: none; 
        font-size: 14px; 
        cursor: pointer; 
    }
    
    .dropdown-box a:hover { 
        background: #f8fbf9; 
        color: #2b4231; 
        font-weight: 600; 
    }
    
    .dropdown-box button:hover { 
        background: #fee2e2; 
        color: #dc2626; 
    }

    /* --- ESTILOS DA BOLINHA DO CARRINHO --- */
    .bolinha-carrinho {
        position: absolute; 
        top: -5px; 
        right: -10px; 
        background-color: #ef4444; 
        color: white; 
        border-radius: 50%; 
        padding: 2px 6px; 
        font-size: 11px; 
        font-weight: bold; 
        border: 2px solid white;
        transition: transform 0.2s ease;
        align-items: center; 
        justify-content: center;
    }

    .bolinha-carrinho.pular {
        transform: scale(1.4);
    }
</style>

<header class="header">
    <div class="container header-container">

        <a href="#" class="logo-link" aria-label="Página Inicial">
            <div class="logo-wrapper">
             <img src="{{ asset('fitbia/images/produto/FITBIA%20LOGO.svg') }}" alt="Logo Fit Bia" style="width: 140px; height: auto; display: block;">
            </div>
        </a>

        <nav class="nav-menu" id="nav-menu">
            <a href="{{ route('home') }}">Home</a>

            <div class="menu-item-com-submenu">
                <a href="{{ route('site.cardapio') }}">Cardápio <i class="ph ph-caret-down"></i></a>
                <div class="submenu">
                    @if(isset($categorias) && count($categorias) > 0)
                        <a href="{{ route('site.cardapio') }}">Todos</a>
                        @foreach($categorias as $categoria)
                            <a href="{{ route('site.cardapio') }}?cat={{ $categoria->id_categoria }}">
                                {{ $categoria->nome_categoria }}
                            </a>
                        @endforeach
                    @else
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
            
            <div class="wrapper-usuario">
                @guest
                    <a href="#" id="btn-abrir-login" class="btn-user" aria-label="Minha Conta" title="Fazer Login">
                        <i class="ph ph-user" style="font-size: 28px;"></i>
                        <span>Entrar</span>
                    </a>
                @endguest

                @auth
                    <a href="{{ route('site.painel') }}" class="btn-user">
                        <i class="ph ph-user" style="font-size: 28px;"></i>
                        <span>{{ explode(' ', auth()->user()->nome_cliente)[0] }}</span>
                    </a>
                    
                    <div class="dropdown-box">
                        <a href="{{ route('site.painel') }}">Meus Pedidos</a>
                        <a href="{{ route('site.painel') }}">Meus Dados</a>
                        <hr style="margin: 5px 0; border: none; border-top: 1px solid #eee;">
                        <form action="{{ route('cliente.logout') }}" method="POST" style="margin: 0;">
                            @csrf
                            <button type="submit" style="color: #dc2626; font-weight: 600;">Sair da conta</button>
                        </form>
                    </div>
                @endauth
            </div>

            <a href="{{ route('site.checkout') }}" style="position: relative; display: inline-block; text-decoration: none; color: inherit;">
                <i class="ph ph-shopping-cart" style="font-size: 28px;"></i>
                @php
                    $qtdCarrinho = session('carrinho') ? count(session('carrinho')) : 0;
                @endphp
                <span id="contador-carrinho" class="bolinha-carrinho" style="display: {{ $qtdCarrinho > 0 ? 'flex' : 'none' }};">
                    {{ $qtdCarrinho }}
                </span>
            </a>

            <button class="menu-toggle" id="menu-toggle" aria-label="Abrir Menu">
                <i class="ph ph-list"></i>
            </button>
        </div>

        <div class="modal-overlay" id="modal-login">
            <div class="modal-box">
                <button class="fechar-modal" id="fechar-modal" onclick="document.getElementById('modal-login').style.display='none'">&times;</button>

                <div class="modal-header">
                    <h2>Bem-vindo(a)!</h2>
                    <p>Faça login para continuar</p>
                </div>

                @error('email_cliente')
                    <div style="background-color: #fee2e2; border-left: 4px solid #ef4444; color: #991b1b; padding: 10px; margin-bottom: 15px; border-radius: 4px; font-size: 14px; text-align: center;">
                        <strong>{{ $message }}</strong>
                    </div>
                @enderror

                <form action="{{ route('cliente.autenticar') }}" method="POST">
                    @csrf
                    <div class="input-group">
                        <label for="email">E-mail</label>
                        <input type="email" id="email" name="email_cliente" placeholder="Seu e-mail cadastrado" value="{{ old('email_cliente') }}" required>
                    </div>

                    <div class="input-group">
                        <label for="senha">Senha</label>
                        <input type="password" id="senha" name="password" placeholder="Sua senha" required>
                    </div>

                    <button type="submit" class="btn-entrar" style="width: 100%; padding: 12px; background-color: #2b4231; color: white; border: none; border-radius: 6px; font-weight: bold; cursor: pointer;">Entrar</button>
                </form>

                <div class="modal-footer" style="margin-top: 15px; text-align: center; font-size: 14px;">
                    <p>Ainda não tem conta? <a href="{{ route('site.cadastro') }}" style="color: #4CAF50; font-weight: bold; text-decoration: none;">Cadastre-se aqui</a></p>
                </div>
            </div>
        </div>

        @if($errors->has('email_cliente'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                document.getElementById('modal-login').style.display = 'flex'; 
            });
        </script>
        @endif

        <script>
            document.addEventListener("DOMContentLoaded", () => {
                // LÓGICA DO MODAL DE LOGIN (ABRIR E FECHAR)
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

                // LÓGICA DO SUBMENU MOBILE
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

                // LÓGICA DO BOTÃO MENU HAMBÚRGUER
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
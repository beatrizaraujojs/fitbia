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
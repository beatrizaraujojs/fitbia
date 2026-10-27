<aside class="sidebar">
    <div class="sidebar-logo">
        <img src="{{ asset('fitbia/images/produto/FITBIA%20LOGO.svg') }}"
            alt="Logo Fit Bia"
            style="width: 140px; height: auto; display: block; filter: brightness(0) invert(1);">
        <button id="btn-fechar-menu" class="btn-fechar-menu" aria-label="Fechar Menu">
            <i class="ph ph-x"></i>
        </button>
    </div>
    
    <nav class="sidebar-nav">
        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="ph ph-squares-four"></i> Visão Geral</a>
        <a href="{{ route('admin.categoria.index') }}" class="{{ request()->routeIs('admin.categoria.*') ? 'active' : '' }}"><i class="ph ph-tag"></i> Categorias</a>
        <a href="{{ route('admin.produto.index') }}" class="{{ request()->routeIs('admin.produto.*') ? 'active' : '' }}"><i class="ph ph-package"></i> Produtos</a>
        <a href="{{ route('admin.grupoadicional.index') }}" class="{{ request()->routeIs('admin.grupoadicional.*') ? 'active' : '' }}"><i class="ph ph-plus-circle"></i> Grupos Adicionais</a>
        <a href="{{ route('admin.cupons.index') }}" class="{{ request()->routeIs('admin.cupons.*') ? 'active' : '' }}"><i class="ph ph-ticket"></i> Cupons</a>
        <a href="{{ route('admin.pedidos') }}" class="{{ request()->routeIs('admin.pedidos*') ? 'active' : '' }}"><i class="ph ph-receipt"></i> Pedidos</a>
        <a href="{{ route('admin.usuarios.index') }}" class="{{ request()->routeIs('admin.usuarios.*') ? 'active' : '' }}"><i class="ph ph-users"></i> Usuários</a>
    </nav>

    <div class="sidebar-footer" style="padding: 20px;">
        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
            style="display: flex; align-items: center; justify-content: center; gap: 8px; background-color: hsla(0, 73%, 33%, 1.00); color: #e4c2c2ff; padding: 12px; border-radius: 8px; text-decoration: none; font-weight: 600; transition: background-color 0.3s;">
            <i class="ph ph-sign-out" style="font-size: 20px;"></i> Sair do Sistema
        </a>

        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
</aside>
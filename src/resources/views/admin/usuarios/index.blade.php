<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Usuários - Fit Bia</title>
    
    {{-- CSS do Painel --}}
    <link rel="stylesheet" href="{{ asset('fitbia/css/dashboard.css') }}">

    {{-- Ícones --}}
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    <style>
        .topo-acoes {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            gap: 15px;
            flex-wrap: wrap;
        }
        .filtros-usuarios {
            display: flex;
            gap: 15px;
        }
        .btn-filtro {
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            color: #4b5563;
            background-color: #f3f4f6;
            border: 1px solid #d1d5db;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .btn-filtro.active {
            background-color: #2b4231;
            color: #ffffff;
            border-color: #2b4231;
        }
        .btn-filtro:hover:not(.active) {
            background-color: #e5e7eb;
        }
        .btn-novo-usuario {
            background-color: #2b4231;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: background-color 0.3s;
        }
        .btn-novo-usuario:hover {
            background-color: #1e2f23;
        }
        .badge {
            padding: 5px 10px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
        }
        .badge-admin { background-color: #fee2e2; color: #991b1b; }
        .badge-funcionario { background-color: #eff6ff; color: #1e40af; }
        .badge-cliente { background-color: #d1fae5; color: #065f46; }
        
        /* Estilização básica para a tabela ficar idêntica à de pedidos */
        .tabela-container {
            background: #fff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.03);
            overflow-x: auto;
        }
        .tabela-usuarios {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }
        .tabela-usuarios th {
            padding: 15px 10px;
            color: #6b7280;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .tabela-usuarios td {
            padding: 15px 10px;
            color: #111827;
            font-size: 14px;
        }
    </style>
</head>

<body>

    <div class="dash-container">

        {{-- MENU LATERAL --}}
        <aside class="sidebar">
            <div class="sidebar-logo">
                <img src="{{ asset('fitbia/images/FITBIA LOGO.svg') }}" alt="Logótipo Fit Bia" style="max-width: 120px; height: auto;">
                <button id="btn-fechar-menu" class="btn-fechar-menu" aria-label="Fechar Menu">
                    <i class="ph ph-x"></i>
                </button>
            </div>
            <nav class="sidebar-nav">
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="ph ph-squares-four"></i> Visão Geral</a>
                <a href="{{ route('admin.categoria.index') }}" class="{{ request()->routeIs('admin.categoria.index') ? 'active' : '' }}"><i class="ph ph-tag"></i> Categorias</a>
                <a href="{{ route('admin.produto.index') }}" class="{{ request()->routeIs('admin.produto.index') ? 'active' : '' }}"><i class="ph ph-package"></i> Produtos</a>
                <a href="{{ route('admin.grupoadicional.index') }}" class="{{ request()->routeIs('admin.grupoadicional.index') ? 'active' : '' }}"><i class="ph ph-plus-circle"></i> Grupos Adicionais</a>
                <a href="{{ route('admin.pedidos') }}" class="{{ request()->routeIs('admin.pedidos') ? 'active' : '' }}"><i class="ph ph-receipt"></i> Pedidos</a>
                <a href="{{ route('admin.usuarios.index') }}" class="{{ request()->routeIs('admin.usuarios.*') ? 'active' : '' }}"><i class="ph ph-users"></i> Usuários</a>
            </nav>
            <div class="sidebar-footer" style="padding: 20px;">
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    style="display: flex; align-items: center; justify-content: center; gap: 8px; background-color: hsla(0, 73%, 33%, 1.00); color: #e4c2c2ff; padding: 12px; border-radius: 8px; text-decoration: none; font-weight: 600; transition: background-color 0.3s;">
                    <i class="ph ph-sign-out" style="font-size: 20px;"></i> Sair do Sistema
                </a>

                {{-- Formulário invisível de segurança do Laravel para fazer o Logout --}}
                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </aside>

        {{-- CONTEÚDO PRINCIPAL --}}
        <main class="main-content">

            <header class="dash-header">
                <div class="header-left">
                    <button id="btn-menu-mobile" class="btn-menu-mobile" aria-label="Abrir Menu">
                        <i class="ph ph-list"></i>
                    </button>
                    <h1>Gestão de Usuários</h1>
                </div>

                 {{-- LADO DIREITO: Botão do Site + Perfil --}}
                <div style="display: flex; align-items: center; gap: 20px;">
                    
                    {{-- O NOVO BOTÃO DE VOLTAR PRO SITE --}}
                    <a href="{{ route('home') }}" style="display: flex; align-items: center; gap: 8px; color: #4b5563; text-decoration: none; font-weight: 600; font-size: 14px; background: #f3f4f6; padding: 8px 15px; border-radius: 8px; transition: background 0.3s;" onmouseover="this.style.background='#e5e7eb'" onmouseout="this.style.background='#f3f4f6'">
                        <i class="ph ph-storefront" style="font-size: 18px;"></i>
                        Ver o Site
                    </a>

                    <div class="user-profile" style="margin: 0;">
                        <span>Olá, {{ auth('admin')->user()->nome_usuario }}</span>
                        <i class="ph ph-user-circle"></i>
                    </div>
                </div>
            </header>

            {{-- ÁREA DE CONTEÚDO DAS ABAS --}}
            <section class="content-area">
                
                {{-- BLOCO SUPERIOR: FILTROS + BOTÃO CADASTRAR --}}
                <div class="topo-acoes">
                    
                    {{-- Alternador de Abas (Filtros) --}}
                    <div class="filtros-usuarios">
                        <a href="{{ route('admin.usuarios.index', ['tipo' => 'admins']) }}" 
                           class="btn-filtro {{ $tipo === 'admins' ? 'active' : '' }}">
                           <i class="ph ph-shield-check"></i> Equipe Interna
                        </a>
                        
                        <a href="{{ route('admin.usuarios.index', ['tipo' => 'clientes']) }}" 
                           class="btn-filtro {{ $tipo === 'clientes' ? 'active' : '' }}">
                           <i class="ph ph-users"></i> Clientes do Site
                        </a>
                    </div>

                    {{-- Botão criar novo: Só aparece visível se estiver listando a Equipe Interna --}}
                    @if($tipo === 'admins')
                        <a href="{{ route('admin.usuarios.create') }}" class="btn-novo-usuario">
                            <i class="ph ph-user-plus" style="font-size: 18px;"></i> Novo Usuário
                        </a>
                    @endif
                </div>

                {{-- TABELA DINÂMICA --}}
                <div class="tabela-container">
                    <table class="tabela-usuarios">
                        <thead>
                            <tr style="border-bottom: 2px solid #f3f4f6;">
                                <th style="width: 35%;">Nome</th>
                                <th style="width: 35%;">E-mail</th>
                                <th style="width: 15%;">Data de Cadastro</th>
                                <th style="width: 15%;">Nível / Tipo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($lista as $item)
                                <tr style="border-bottom: 1px solid #f3f4f6;">
                                    
                                    @if($tipo === 'clientes')
                                        {{-- Renderização dos dados estruturados da tbl_cliente --}}
                                        <td style="font-weight: 600; padding: 15px 10px;">{{ $item->nome_cliente }}</td>
                                        <td>{{ $item->email_cliente }}</td>
                                        <td>{{ date('d/m/Y H:i', strtotime($item->created_at)) }}</td>
                                        <td><span class="badge badge-cliente">Cliente</span></td>
                                    @else
                                        {{-- Renderização dos dados estruturados da tbl_usuario --}}
                                        <td style="font-weight: 600; padding: 15px 10px;">{{ $item->nome_usuario }}</td>
                                        <td>{{ $item->email_usuario }}</td>
                                        <td>{{ date('d/m/Y H:i', strtotime($item->created_at)) }}</td>
                                        <td>
                                            @if($item->nivel_acesso_usuario === 'ADMIN')
                                                <span class="badge badge-admin">Admin</span>
                                            @else
                                                <span class="badge badge-funcionario">Funcionário</span>
                                            @endif
                                        </td>
                                    @endif
                                    
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" style="padding: 30px; text-align: center; color: #6b7280; font-weight: 500;">
                                        Nenhum registro encontrado para esta seleção.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </section>
        </main>
    </div>

    {{-- SCRIPT COMPORTAMENTAL DO MENU MOBILE --}}
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const btnMenuMobile = document.getElementById("btn-menu-mobile");
            const btnFecharMenu = document.getElementById("btn-fechar-menu");
            const sidebar = document.querySelector(".sidebar");

            if(btnMenuMobile && sidebar) {
                btnMenuMobile.addEventListener("click", () => {
                    sidebar.classList.add("aberta");
                });
            }

            if(btnFecharMenu && sidebar) {
                btnFecharMenu.addEventListener("click", () => {
                    sidebar.classList.remove("aberta");
                });
            }
        });
    </script>

</body>
</html>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo Usuário - Fit Bia</title>
    
    <link rel="stylesheet" href="{{ asset('fitbia/css/dashboard.css') }}">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    
    <style>
        /* --- ESTILOS DO FORMULÁRIO --- */
        .form-card {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.03);
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #374151;
            font-weight: 600;
            font-size: 14px;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 12px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            box-sizing: border-box;
            font-size: 14px;
            outline: none;
        }
        .form-group input:focus, .form-group select:focus {
            border-color: #2b4231;
            box-shadow: 0 0 0 3px rgba(43, 66, 49, 0.2);
        }
        .btn-salvar {
            background-color: #2b4231;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .btn-salvar:hover { background-color: #1e2f23; }
        .btn-cancelar {
            background-color: #f3f4f6;
            color: #4b5563;
            padding: 12px 24px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            text-decoration: none;
            margin-right: 10px;
            transition: background-color 0.3s;
        }
        .btn-cancelar:hover { background-color: #e5e7eb; }
        .alert-error {
            background-color: #fee2e2;
            color: #991b1b;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }
    </style>
</head>
<body>

    <div class="dash-container">
        
        {{-- SEU MENU LATERAL OFICIAL DO PAINEL --}}
        <aside class="sidebar">
            <div class="sidebar-logo">
                <h2>Fit Bia</h2>
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
        {{-- CABEÇALHO DO PAINEL --}}
            <header class="dash-header">
                <div class="header-left">
                    <button id="btn-menu-mobile" class="btn-menu-mobile" aria-label="Abrir Menu">
                        <i class="ph ph-list"></i>
                    </button>
                    <h1>Cadastrar Novo Usuário</h1>
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

            {{-- ÁREA DO FORMULÁRIO --}}
            <section class="content-area">
                
                <div class="form-card">
                    <div style="margin-bottom: 25px;">
                        <h2 style="font-size: 20px; margin: 0; color: #2b4231;">Dados do Novo Usuário</h2>
                        <p style="color: #6b7280; margin: 5px 0 0 0; font-size: 14px;">Preencha os campos abaixo para adicionar ao sistema.</p>
                    </div>

                    @if($errors->any())
                        <div class="alert-error">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form action="{{ route('admin.usuarios.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="nome_usuario">Nome Completo</label>
                            <input type="text" id="nome_usuario" name="nome_usuario" required placeholder="Ex: João Silva" value="{{ old('nome_usuario') }}">
                        </div>

                        <div class="form-group">
                            <label for="email_usuario">E-mail de Acesso</label>
                            <input type="email" id="email_usuario" name="email_usuario" required placeholder="Ex: joao@fitbia.com.br" value="{{ old('email_usuario') }}">
                        </div>

                        <div class="form-group">
                            <label for="senha_usuario">Senha Inicial</label>
                            <input type="password" id="senha_usuario" name="senha_usuario" required placeholder="Mínimo 6 caracteres">
                        </div>

                        <div class="form-group">
                            <label for="nivel_acesso_usuario">Nível de Acesso</label>
                            <select id="nivel_acesso_usuario" name="nivel_acesso_usuario" required>
                                {{-- PADRÃO SELECIONADO COMO CLIENTE --}}
                                <option value="CLIENTE" selected>Cliente (Padrão)</option>
                                <option value="FUNCIONARIO">Funcionário / Cozinha</option>
                                <option value="ADMIN">Administrador (Acesso Total)</option>
                            </select>
                        </div>

                        <div style="margin-top: 30px; display: flex; justify-content: flex-end;">
                            <a href="{{ route('admin.usuarios.index') }}" class="btn-cancelar">Cancelar</a>
                            <button type="submit" class="btn-salvar">Salvar Usuário</button>
                        </div>
                    </form>
                </div>

            </section>
        </main>
    </div>

    {{-- SCRIPT PARA O MENU MOBILE DO PAINEL FUNCIONAR --}}
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
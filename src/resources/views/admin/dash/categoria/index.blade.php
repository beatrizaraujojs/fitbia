<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorias - Painel Admin</title>
    <link rel="stylesheet" href="{{ asset('fitbia/css/dashboard.css') }}">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>

<body>

    <div class="dash-container">
        <aside class="sidebar">
            <div class="sidebar-logo">
                <h2>Fit Bia</h2>
                <button id="btn-fechar-menu" class="btn-fechar-menu" aria-label="Fechar Menu"><i class="ph ph-x"></i></button>
            </div>
            <nav class="sidebar-nav">
                <a href="#"><i class="ph ph-squares-four"></i> Visão Geral</a>
                <a href="{{ route('admin.categoria.index') }}" class="active"><i class="ph ph-tag"></i> Categorias</a>
                <a href="{{ route('admin.produto.index') }}"><i class="ph ph-package"></i> Produtos</a>
                <a href="{{ route('admin.grupoadicional.index') }}"><i class="ph ph-plus-circle"></i> Grupos Adicionais</a>
                {{-- O botão de pedidos com a classe active dinâmica! --}}
                <a href="{{ route('admin.pedidos') }}" class="{{ request()->routeIs('admin.pedidos') }}"><i class="ph ph-receipt"></i> Pedidos</a>
            </nav>
            <div class="sidebar-footer">
                <a href="#"><i class="ph ph-sign-out"></i> Sair do Sistema</a>
            </div>
        </aside>

        <main class="main-content">
            <header class="dash-header">
                <div class="header-left">
                    <button id="btn-menu-mobile" class="btn-menu-mobile" aria-label="Abrir Menu"><i class="ph ph-list"></i></button>
                    <h1>Gerenciar Categorias</h1>
                </div>
                <div class="user-profile">
                    <span>Olá, Administrador</span>
                    <i class="ph ph-user-circle"></i>
                </div>
            </header>

            <section class="content-area">

                {{-- MENSAGEM DE SUCESSO --}}
                @if(session('sucesso'))
                <div style="background-color: #def7ec; color: #03543f; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem; font-weight: 500; border: 1px solid #31c48d;">
                    <i class="ph ph-check-circle" style="vertical-align: middle; margin-right: 0.5rem; font-size: 1.25rem;"></i>
                    {{ session('sucesso') }}
                </div>
                @endif

                <div class="admin-card">
                    <h2 class="card-title">Nova Categoria</h2>

                    <form action="{{ route('admin.categoria.store') }}" method="POST" class="admin-form">
                        @csrf

                        <div class="form-group">
                            <label for="nome_categoria">Nome da Categoria *</label>
                            <input type="text" id="nome_categoria" name="nome_categoria" placeholder="Ex: Marmitas Low Carb" required>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="ordem_exibicao_categoria">Ordem de Exibição</label>
                                <input type="number" id="ordem_exibicao_categoria" name="ordem_exibicao_categoria" value="0">
                            </div>

                            <div class="form-group">
                                <label for="ativa_categoria">Status</label>
                                <select id="ativa_categoria" name="ativa_categoria">
                                    <option value="ATIVO">Ativo</option>
                                    <option value="INATIVO">Inativo</option>
                                </select>
                            </div>
                        </div>

                        <button type="submit" class="btn-salvar">Salvar Categoria</button>
                    </form>
                </div>

                <div class="admin-card mt-4">
                    <h2 class="card-title">Categorias Cadastradas</h2>

                    <div class="table-responsive">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>Ordem</th>
                                    <th>Status</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($categorias as $categoria)
                                <tr>
                                    <td>{{ $categoria->id_categoria }}</td>
                                    <td>{{ $categoria->nome_categoria }}</td>
                                    <td>{{ $categoria->ordem_exibicao_categoria ?? 0 }}</td>

                                    <td>
                                        @if($categoria->ativa_categoria == 'ATIVO')
                                        <span style="background-color: #def7ec; color: #03543f; padding: 0.25rem 0.5rem; border-radius: 0.25rem; font-size: 0.875rem; font-weight: bold;">Ativo</span>
                                        @else
                                        <span style="background-color: #fde8e8; color: #9b1c1c; padding: 0.25rem 0.5rem; border-radius: 0.25rem; font-size: 0.875rem; font-weight: bold;">Inativo</span>
                                        @endif
                                    </td>

                                    <td>
                                        {{-- Botão Editar --}}
                                        <button type="button" class="btn-action edit" title="Editar"
                                            data-url="{{ route('admin.categoria.update', $categoria->id_categoria) }}"
                                            data-nome="{{ $categoria->nome_categoria }}"
                                            data-ordem="{{ $categoria->ordem_exibicao_categoria ?? 0 }}"
                                            data-status="{{ $categoria->ativa_categoria }}"
                                            onclick="abrirModalEditarCategoria(this)">
                                            <i class="ph ph-pencil-simple"></i>
                                        </button>

                                        {{-- Formulário de Desativar Categoria --}}
                                        <form action="{{ route('admin.categoria.destroy', $categoria->id_categoria) }}" method="POST" style="display:inline;" onsubmit="return confirm('Deseja realmente desativar esta categoria?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action delete" title="Desativar">
                                                <i class="ph ph-power"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </section>
        </main>
    </div>

    {{-- ========================================== --}}
    {{-- MODAL DE EDITAR CATEGORIA                  --}}
    {{-- ========================================== --}}
    <div class="admin-modal-overlay" id="modal-editar" style="display: none;">
        <div class="admin-modal-box">

            <div class="admin-modal-header">
                <h2>Editar Categoria</h2>
                <button type="button" class="fechar-modal" id="btn-fechar-editar">&times;</button>
            </div>

            <form action="#" method="POST" class="admin-form" id="form-editar">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="edit_nome_categoria">Nome da Categoria *</label>
                    <input type="text" id="edit_nome_categoria" name="nome_categoria" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="edit_ordem">Ordem de Exibição</label>
                        <input type="number" id="edit_ordem" name="ordem_exibicao_categoria">
                    </div>

                    <div class="form-group">
                        <label for="edit_status">Status</label>
                        <select id="edit_status" name="ativa_categoria">
                            <option value="ATIVO">Ativo</option>
                            <option value="INATIVO">Inativo</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn-salvar">Atualizar Categoria</button>
            </form>

        </div>
    </div>

    {{-- ========================================== --}}
    {{-- SCRIPTS                                    --}}
    {{-- ========================================== --}}
    <script>
        // Função para abrir o modal e preencher os dados
        function abrirModalEditarCategoria(botao) {
            let url = botao.getAttribute('data-url');
            let nome = botao.getAttribute('data-nome');
            let ordem = botao.getAttribute('data-ordem');
            let status = botao.getAttribute('data-status');

            // Preenche o formulário
            document.getElementById('form-editar').action = url;
            document.getElementById('edit_nome_categoria').value = nome;
            document.getElementById('edit_ordem').value = ordem;
            document.getElementById('edit_status').value = status;

            // Exibe o modal (pode mudar para 'flex' se ficar desalinhado)
            // Exibe o modal centralizado usando flex
            document.getElementById('modal-editar').style.display = 'flex';
        }

        // Lógica geral da página (Menu e Fechar Modal)
        document.addEventListener("DOMContentLoaded", () => {
            // -- Menu Mobile --
            const btnMenuMobile = document.getElementById("btn-menu-mobile");
            const btnFecharMenu = document.getElementById("btn-fechar-menu");
            const sidebar = document.querySelector(".sidebar");

            if (btnMenuMobile && sidebar) {
                btnMenuMobile.addEventListener("click", () => sidebar.classList.add("aberta"));
            }
            if (btnFecharMenu && sidebar) {
                btnFecharMenu.addEventListener("click", () => sidebar.classList.remove("aberta"));
            }

            // -- Fechar Modal --
            const modalEditar = document.getElementById("modal-editar");
            const btnFecharEditar = document.getElementById("btn-fechar-editar");

            if (btnFecharEditar) {
                btnFecharEditar.addEventListener("click", () => {
                    modalEditar.style.display = 'none';
                });
            }

            // Fecha clicando fora da caixa do modal
            window.addEventListener("click", (e) => {
                if (e.target === modalEditar) {
                    modalEditar.style.display = 'none';
                }
            });
        });
    </script>

</body>

</html>
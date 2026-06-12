<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos - Painel Admin</title>
    <link rel="stylesheet" href="{{ asset('fitbia/css/dashboard.css') }}">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    {{-- Estilos exclusivos da Barra de Filtros do Painel --}}
    <style>
        .admin-filtros-bar {
            display: flex;
            gap: 10px;
            margin: 20px 0;
            padding-bottom: 10px;
            overflow-x: auto;
            scrollbar-width: thin;
        }

        .admin-filtro-btn {
            background-color: #f3f4f6;
            color: #4b5563;
            border: 1px solid #d1d5db;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            white-space: nowrap;
        }

        .admin-filtro-btn:hover {
            background-color: #e5e7eb;
        }

        .admin-filtro-btn.active {
            background-color: #4b5563;
            color: #ffffff;
            border-color: #4b5563;
        }
    </style>
</head>

<body>

    <div class="dash-container">
        <aside class="sidebar">
            <div class="sidebar-logo">
                <h2>Fit Bia</h2>
                <button id="btn-fechar-menu" class="btn-fechar-menu" aria-label="Fechar Menu"><i class="ph ph-x"></i></button>
            </div>
            <nav class="sidebar-nav">
                <a href="#" class="active"><i class="ph ph-squares-four"></i> Visão Geral</a>
                <a href="{{ route('admin.categoria.index') }}"><i class="ph ph-tag"></i> Categorias</a>
                <a href="{{ route('admin.produto.index') }}"><i class="ph ph-package"></i> Produtos</a>
                <a href="#"><i class="ph ph-plus-circle"></i> Grupos Adicionais</a>
                <a href="#"><i class="ph ph-receipt"></i> Pedidos</a>
            </nav>
            <div class="sidebar-footer">
                <a href="#"><i class="ph ph-sign-out"></i> Sair do Sistema</a>
            </div>
        </aside>

        <main class="main-content">
            <header class="dash-header">
                <div class="header-left">
                    <button id="btn-menu-mobile" class="btn-menu-mobile" aria-label="Abrir Menu"><i class="ph ph-list"></i></button>
                    <h1>Gerenciar Produtos</h1>
                </div>
                <div class="user-profile">
                    <span>Olá, Administrador</span>
                    <i class="ph ph-user-circle"></i>
                </div>
            </header>

            <section class="content-area">

                <div class="admin-card">
                    <h2 class="card-title">Novo Produto</h2>

                    <form action="{{ route('admin.produto.store') }}" method="POST" enctype="multipart/form-data" class="admin-form">
                        @csrf

                        <div class="form-group">
                            <label for="nome_produto">Nome do Produto*</label>
                            <input type="text" id="nome_produto" name="nome_produto" placeholder="Ex: Combo Low Carb" required>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="id_categoria_fk">Categoria*</label>
                                <select id="id_categoria_fk" name="id_categoria_fk" required>
                                    <option value="">Selecione...</option>
                                    @foreach($categorias as $categoria)
                                    <option value="{{ $categoria->id_categoria }}">{{ $categoria->nome_categoria }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="preco_base_produto">Preço Base*</label>
                                <input type="number" id="preco_base_produto" name="preco_base_produto" step="0.01" placeholder="0.00" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="descricao_produto">Descrição do Produto</label>
                            <input type="text" id="descricao_produto" name="descricao_produto" placeholder="Ex: Acompanha 5 marmitas...">
                        </div>

                        <div class="form-group">
                            <label for="foto_produto">Foto do Produto</label>
                            <input type="file" id="foto_produto" name="foto_produto" accept="image/*">
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="status_produto">Status</label>
                                <select id="status_produto" name="status_produto">
                                    <option value="ATIVO">Ativo</option>
                                    <option value="INATIVO">Inativo</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="destaque_produto">Destaque</label>
                                <select id="destaque_produto" name="destaque_produto">
                                    <option value="NAO">Não</option>
                                    <option value="SIM">Sim</option>
                                </select>
                            </div>
                        </div>

                        <button type="submit" class="btn-salvar">Salvar Produto</button>
                    </form>
                </div>

                {{-- Barra de Filtros de Categorias --}}
                <div class="admin-filtros-bar">
                    <button type="button" class="admin-filtro-btn active" data-filter="todos">Todos</button>
                    @foreach($categorias as $categoria)
                    <button type="button" class="admin-filtro-btn" data-filter="{{ $categoria->id_categoria }}">
                        {{ $categoria->nome_categoria }}
                    </button>
                    @endforeach
                </div>

                <div class="admin-card">
                    <h2 class="card-title">Produtos Cadastrados</h2>

                    <div class="table-responsive">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>Descrição</th>
                                    <th>Foto</th>
                                    <th>Preço</th>
                                    <th>Status</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($produtos as $produto)
                                {{-- A classe produto-row e o data-categoria são usados pelo JS do filtro --}}
                                <tr class="produto-row" data-categoria="{{ $produto->id_categoria_fk }}">

                                    <td>{{ $produto->id_produto }}</td>

                                    <td>{{ $produto->nome_produto }}</td>

                                    <td>{{ Str::limit($produto->descricao_produto, 40) }}</td>

                                    <td>
                                        @if($produto->foto_produto)
                                        <img src="{{ asset('fitbia/images/produto/' . $produto->foto_produto) }}"
                                            alt="{{ $produto->nome_produto }}"
                                            style="width: 60px; height: 60px; object-fit: cover; border-radius: 6px;">
                                        @else
                                        <span style="color: #999; font-style: italic;">Sem foto</span>
                                        @endif
                                    </td>

                                    <td>R$ {{ number_format($produto->preco_base_produto, 2, ',', '.') }}</td>

                                    <td>
                                        @if($produto->status_produto == 'ATIVO')
                                        <span style="background-color: #def7ec; color: #03543f; padding: 0.25rem 0.5rem; border-radius: 0.25rem; font-size: 0.875rem; font-weight: bold;">Ativo</span>
                                        @else
                                        <span style="background-color: #fde8e8; color: #9b1c1c; padding: 0.25rem 0.5rem; border-radius: 0.25rem; font-size: 0.875rem; font-weight: bold;">Inativo</span>
                                        @endif
                                    </td>

                                    <td>
                                        <button type="button" class="btn-action edit" title="Editar"
                                            data-url="{{ route('admin.produto.update', $produto->id_produto) }}"
                                            data-nome="{{ $produto->nome_produto }}"
                                            data-descricao="{{ $produto->descricao_produto }}"
                                            data-preco="{{ $produto->preco_base_produto }}"
                                            data-status="{{ $produto->status_produto }}"
                                            data-destaque="{{ $produto->destaque_produto }}"
                                            data-categoria="{{ $produto->id_categoria_fk }}"
                                            onclick="abrirModalEditar(this)">
                                            <i class="ph ph-pencil-simple"></i>
                                        </button>

                                        <form action="{{ route('admin.produto.destroy', $produto->id_produto) }}" method="POST" style="display:inline;" onsubmit="return confirm('Deseja realmente desativar/excluir este produto?')">
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

    {{-- === MODAL DE EDITAR === --}}
    <div id="modalEditarProduto" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); z-index: 1000; overflow-y: auto;">
        <div class="admin-card" style="margin: 5% auto; width: 90%; max-width: 600px; position: relative;">

            <button type="button" onclick="document.getElementById('modalEditarProduto').style.display='none'" style="position: absolute; top: 15px; right: 20px; background: none; border: none; font-size: 24px; cursor: pointer; color: #4b5563;">
                <i class="ph ph-x"></i>
            </button>

            <h2 class="card-title">Editar Produto</h2>

            <form id="formEditarProduto" action="" method="POST" enctype="multipart/form-data" class="admin-form">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="edit_nome_produto">Nome do Produto*</label>
                    <input type="text" name="nome_produto" id="edit_nome_produto" required>
                </div>

                <div class="form-group">
                    <label for="edit_preco_base_produto">Preço Base*</label>
                    <input type="number" step="0.01" name="preco_base_produto" id="edit_preco_base_produto" required>
                </div>

                <div class="form-group">
                    <label for="edit_descricao_produto">Descrição do Produto</label>
                    <input type="text" name="descricao_produto" id="edit_descricao_produto">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="edit_id_categoria_fk">Categoria*</label>
                        <select id="edit_id_categoria_fk" name="id_categoria_fk" required>
                            <option value="">Selecione...</option>
                            @foreach($categorias as $categoria)
                            <option value="{{ $categoria->id_categoria }}">{{ $categoria->nome_categoria }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="edit_status_produto">Status</label>
                        <select id="edit_status_produto" name="status_produto">
                            <option value="ATIVO">Ativo</option>
                            <option value="INATIVO">Inativo</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="edit_destaque_produto">Destaque</label>
                        <select id="edit_destaque_produto" name="destaque_produto">
                            <option value="NAO">Não</option>
                            <option value="SIM">Sim</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="foto_produto">Nova Foto do Produto (Deixe vazio para manter a atual)</label>
                    <input type="file" name="foto_produto" accept="image/*">
                </div>

                <div style="display: flex; gap: 10px; margin-top: 20px;">
                    <button type="button" onclick="document.getElementById('modalEditarProduto').style.display='none'" class="admin-filtro-btn" style="flex: 1; text-align: center;">Cancelar</button>
                    <button type="submit" class="btn-salvar" style="flex: 2;">Guardar Alterações</button>
                </div>


                
            </form>
        </div>
    </div>


    {{-- === SISTEMA DE ALERTAS POP-UP === --}}
    @if(session('success'))
    <script>
        alert("Sucesso: {{ session('success') }}");
    </script>
    @endif

    <!-- @if($errors->any())
        <script>
            let erros = "Oops! Ocorreu um erro na validação:\n\n";
            @foreach ($errors->all() as $error)
                erros += "❌ {{ $error }}\n";
            @endforeach
            alert(erros);
        </script>
    @endif -->


    {{-- === SCRIPTS DO MODAL E DO FILTRO === --}}
    <script>
        function abrirModalEditar(botao) {
            // Pega a URL da rota e altera no form
            let url = botao.getAttribute('data-url');
            document.getElementById('formEditarProduto').action = url;

            // Preenche os inputs de texto e número
            document.getElementById('edit_nome_produto').value = botao.getAttribute('data-nome');
            document.getElementById('edit_preco_base_produto').value = botao.getAttribute('data-preco');
            document.getElementById('edit_descricao_produto').value = botao.getAttribute('data-descricao');

            // Preenche os selects
            document.getElementById('edit_status_produto').value = botao.getAttribute('data-status');
            document.getElementById('edit_destaque_produto').value = botao.getAttribute('data-destaque');
            document.getElementById('edit_id_categoria_fk').value = botao.getAttribute('data-categoria');

            // Abre o modal
            document.getElementById('modalEditarProduto').style.display = 'block';
        }

        document.addEventListener("DOMContentLoaded", () => {
            // --- Menu Mobile ---
            const btnMenuMobile = document.getElementById("btn-menu-mobile");
            const btnFecharMenu = document.getElementById("btn-fechar-menu");
            const sidebar = document.querySelector(".sidebar");

            if (btnMenuMobile && sidebar) {
                btnMenuMobile.addEventListener("click", () => sidebar.classList.add("aberta"));
            }
            if (btnFecharMenu && sidebar) {
                btnFecharMenu.addEventListener("click", () => sidebar.classList.remove("aberta"));
            }

            // --- Filtro da Tabela com Memória (sessionStorage) ---
            const filterBtns = document.querySelectorAll('.admin-filtro-btn');
            const productRows = document.querySelectorAll('.produto-row');

            // 1. Verifica se tem algum filtro salvo
            const filtroSalvo = sessionStorage.getItem('filtroProdutoAtivo') || 'todos';

            // 2. Função que aplica o filtro
            function aplicarFiltro(categoriaId) {
                filterBtns.forEach(b => b.classList.remove('active'));

                const btnAtivo = document.querySelector(`.admin-filtro-btn[data-filter="${categoriaId}"]`);
                if (btnAtivo) btnAtivo.classList.add('active');

                productRows.forEach(row => {
                    const rowCategory = row.getAttribute('data-categoria');
                    if (categoriaId === 'todos' || categoriaId === rowCategory) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            }

            // 3. Ao carregar, aplica o filtro salvo
            aplicarFiltro(filtroSalvo);

            // 4. Ao clicar, salva e aplica
            filterBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const selectedCategory = this.getAttribute('data-filter');
                    sessionStorage.setItem('filtroProdutoAtivo', selectedCategory);
                    aplicarFiltro(selectedCategory);
                });
            });
        });
    </script>

</body>

</html>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo - Fit Bia</title>
    <link rel="stylesheet" href="{{ asset('fitbia/css/dashboard.css') }}">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>

<body>

    <div class="dash-container">
        <aside class="sidebar">
            <div class="sidebar-logo">
                <h2>Fit Bia</h2>
                <button id="btn-fechar-menu" class="btn-fechar-menu" aria-label="Fechar Menu">
                    <i class="ph ph-x"></i>
                </button>
            </div>

            <nav class="sidebar-nav">
                <a href="#"><i class="ph ph-squares-four"></i> Visão Geral</a>
                <a href="{{ route('admin.categoria.index') }}"><i class="ph ph-tag"></i> Categorias</a>
                <a href="{{ route('admin.produto.index') }}"><i class="ph ph-package"></i> Produtos</a>
                <a href="{{ route('admin.grupoadicional.index') }}" class="active"><i class="ph ph-plus-circle"></i> Grupos Adicionais</a>
            </nav>
            <div class="sidebar-footer">
                <a href="#"><i class="ph ph-sign-out"></i> Sair do Sistema</a>
            </div>
        </aside>

        <main class="main-content">
            <header class="dash-header">
                <div class="header-left">
                    <button id="btn-menu-mobile" class="btn-menu-mobile" aria-label="Abrir Menu">
                        <i class="ph ph-list"></i>
                    </button>
                    <h1>Dashboard</h1>
                </div>
                <div class="user-profile">
                    <span>Olá, Administrador</span>
                    <i class="ph ph-user-circle"></i>
                </div>
            </header>

            {{-- === SISTEMA DE ALERTAS EM HTML === --}}
            @if(session('success'))
            <div style="background-color: #def7ec; color: #03543f; padding: 15px; border-radius: 6px; margin-bottom: 20px; border: 1px solid #bcdecb; font-weight: bold;">
                ✅ {{ session('success') }}
            </div>
            @endif

            @if($errors->any())
            <div style="background-color: #fde8e8; color: #9b1c1c; padding: 15px; border-radius: 6px; margin-bottom: 20px; border: 1px solid #f8b4b4;">
                <strong style="display: block; margin-bottom: 5px;">❌ Erro ao salvar:</strong>
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            {{-- ======================================= --}}

            <div class="admin-card">
                <h2 class="card-title">Novo Grupo de Adicionais</h2>

                <form action="{{ route('admin.grupo.store') }}" method="POST" class="admin-form">
                    @csrf
                    <div class="form-group">
                        <label for="nome_grupo_adicional">Nome do Grupo*</label>
                        <input type="text" id="nome_grupo_adicional" name="nome_grupo_adicional" placeholder="Ex: Escolha o seu molho" required>
                    </div>

                    <div class="form-row" style="display: flex; gap: 15px;">
                        <div class="form-group" style="flex: 1;">
                            <label for="qtd_min_grupo">Quantidade Mínima*</label>
                            <input type="number" id="qtd_min_grupo" name="qtd_min_grupo" min="0" value="0" required>
                        </div>
                        <div class="form-group" style="flex: 1;">
                            <label for="qtd_max_grupo">Quantidade Máxima*</label>
                            <input type="number" id="qtd_max_grupo" name="qtd_max_grupo" min="1" value="1" required>
                        </div>
                        <div class="form-group" style="flex: 1;">
                            <label for="status_grupo">Status</label>
                            <select id="status_grupo" name="status_grupo">
                                <option value="ATIVO">Ativo</option>
                                <option value="INATIVO">Inativo</option>
                            </select>
                        </div>
                    </div>

                    <hr style="margin: 25px 0; border: 0; border-top: 1px solid #e5e7eb;">
                    <h3 style="font-size: 16px; margin-bottom: 15px; color: #374151;">Componentes / Opções deste Grupo</h3>

                    <div id="container-itens">
                        <div class="linha-item-cadastro" style="display: flex; gap: 15px; margin-bottom: 10px; align-items: center;">
                            <div class="form-group" style="flex: 3; margin: 0;">
                                <input type="text" name="itens[0][nome]" placeholder="Nome do item (Ex: Ketchup)" required style="width: 100%;">
                            </div>
                            <div class="form-group" style="flex: 1; margin: 0;">
                                <input type="number" name="itens[0][preco]" step="0.01" placeholder="Preço (Ex: 1.50 ou 0)" required style="width: 100%;">
                            </div>
                            <button type="button" onclick="removerLinha(this)" style="background: #ef4444; color: white; border: none; padding: 8px 12px; border-radius: 4px; cursor: pointer;">X</button>
                        </div>
                    </div>

                    <button type="button" id="btn-add-item" style="background: #4b5563; color: white; border: none; padding: 8px 15px; border-radius: 4px; cursor: pointer; font-size: 14px; margin-top: 10px;">
                        + Adicionar Opção
                    </button>

                    <div style="margin-top: 30px;">
                        <button type="submit" class="btn-salvar" style="width: 100%; background: #4CAF50; padding: 12px; color: white; font-weight: bold; border: none; border-radius: 6px; cursor: pointer;">
                            Salvar Grupo e Componentes
                        </button>
                    </div>
                </form>
            </div>

            {{-- TABELA DE GRUPOS CADASTRADOS --}}
            <div class="admin-card" style="margin-top: 30px;">
                <h2 class="card-title">Grupos Adicionais Cadastrados</h2>
                <div class="table-responsive">
                    <table class="admin-table" style="width: 100%; text-align: left; border-collapse: collapse;">
                        <thead>
                            <tr style="border-bottom: 2px solid #e5e7eb;">
                                <th style="padding: 12px; color: #4b5563;">ID</th>
                                <th style="padding: 12px; color: #4b5563;">Nome do Grupo</th>
                                <th style="padding: 12px; color: #4b5563;">Regras</th>
                                <th style="padding: 12px; color: #4b5563;">Componentes (Itens)</th>
                                <th style="padding: 12px; color: #4b5563;">Status</th>
                                <th style="padding: 12px; color: #4b5563;">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($grupos as $grupo)
                            <tr style="border-bottom: 1px solid #e5e7eb;">
                                <td style="padding: 12px;">{{ $grupo->id_grupo_adicional }}</td>
                                <td style="padding: 12px; font-weight: bold;">{{ $grupo->nome_grupo_adicional }}</td>
                                <td style="padding: 12px; font-size: 14px;">
                                    Mín: {{ $grupo->qtd_min_grupo }} <br>
                                    Máx: {{ $grupo->qtd_max_grupo }}
                                </td>
                                <td style="padding: 12px;">
                                    <ul style="margin: 0; padding-left: 15px; font-size: 13px; color: #4b5563;">
                                        @forelse($grupo->adicionais as $item)
                                        <li>{{ $item->nome_adicional }} (R$ {{ number_format($item->preco_adicional, 2, ',', '.') }})</li>
                                        @empty
                                        <li style="color: #ef4444; list-style: none;">Sem itens</li>
                                        @endforelse
                                    </ul>
                                </td>
                                <td style="padding: 12px;">
                                    @if($grupo->status_grupo == 'ATIVO')
                                    <span style="background-color: #def7ec; color: #03543f; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: bold;">Ativo</span>
                                    @else
                                    <span style="background-color: #fde8e8; color: #9b1c1c; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: bold;">Inativo</span>
                                    @endif
                                </td>
                                <td style="padding: 12px;">
                                    {{-- BOTÃO EDITAR --}}
                                    <button type="button" class="btn-action edit" title="Editar"
                                        data-url="{{ route('admin.grupo.update', $grupo->id_grupo_adicional) }}"
                                        data-nome="{{ $grupo->nome_grupo_adicional }}"
                                        data-min="{{ $grupo->qtd_min_grupo }}"
                                        data-max="{{ $grupo->qtd_max_grupo }}"
                                        data-status="{{ $grupo->status_grupo }}"
                                        data-itens="{{ $grupo->adicionais->toJson() }}"
                                        onclick="abrirModalEditar(this)">
                                        <i class="ph ph-pencil-simple"></i>
                                    </button>
                                    {{-- BOTÃO DESATIVAR --}}
                                    <form action="{{ route('admin.grupo.destroy', $grupo->id_grupo_adicional) }}" method="POST" style="display:inline;" onsubmit="return confirm('Deseja desativar este grupo? Ele ficará INATIVO no banco de dados e deixará de aparecer para os clientes.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action delete" title="Desativar">
                                            <i class="ph ph-power"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" style="padding: 20px; text-align: center; color: #6b7280; font-style: italic;">
                                    Nenhum grupo cadastrado ainda. Use o formulário acima para criar o primeiro!
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    {{-- === MODAL DE EDITAR GRUPO === --}}
    <div id="modalEditar" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); z-index: 1000; overflow-y: auto;">
        <div class="admin-card" style="margin: 5% auto; width: 90%; max-width: 600px; position: relative;">

            <button type="button" onclick="document.getElementById('modalEditar').style.display='none'" style="position: absolute; top: 15px; right: 20px; background: none; border: none; font-size: 24px; cursor: pointer; color: #4b5563;">
                <i class="ph ph-x"></i>
            </button>

            <h2 class="card-title">Editar Grupo de Adicionais</h2>

            <form id="formEditarGrupo" action="" method="POST" class="admin-form">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="edit_nome_grupo">Nome do Grupo*</label>
                    <input type="text" id="edit_nome_grupo" name="nome_grupo_adicional" required>
                </div>

                <div class="form-row" style="display: flex; gap: 15px;">
                    <div class="form-group" style="flex: 1;">
                        <label for="edit_qtd_min">Qtd Mínima*</label>
                        <input type="number" id="edit_qtd_min" name="qtd_min_grupo" min="0" required>
                    </div>
                    <div class="form-group" style="flex: 1;">
                        <label for="edit_qtd_max">Qtd Máxima*</label>
                        <input type="number" id="edit_qtd_max" name="qtd_max_grupo" min="1" required>
                    </div>
                    <div class="form-group" style="flex: 1;">
                        <label for="edit_status">Status</label>
                        <select id="edit_status" name="status_grupo">
                            <option value="ATIVO">Ativo</option>
                            <option value="INATIVO">Inativo</option>
                        </select>
                    </div>
                </div>

                <hr style="margin: 25px 0; border: 0; border-top: 1px solid #e5e7eb;">
                <h3 style="font-size: 16px; margin-bottom: 15px;">Componentes deste Grupo</h3>

                <div id="container-itens-edit">
                </div>

                <button type="button" id="btn-add-item-edit" style="background: #4b5563; color: white; border: none; padding: 8px 15px; border-radius: 4px; cursor: pointer; font-size: 14px; margin-top: 10px;">
                    + Adicionar Opção
                </button>

                <div style="display: flex; gap: 10px; margin-top: 30px;">
                    <button type="button" onclick="document.getElementById('modalEditar').style.display='none'" class="admin-filtro-btn" style="flex: 1;">Cancelar</button>
                    <button type="submit" class="btn-salvar" style="flex: 2; background: #4CAF50; color: white; border: none; border-radius: 6px; font-weight: bold; cursor: pointer;">Guardar Alterações</button>
                </div>
            </form>
        </div>
    </div>

    {{-- SCRIPTS GERAIS --}}
    <script>
        // Lógica do Menu Mobile
        document.addEventListener("DOMContentLoaded", () => {
            const btnMenuMobile = document.getElementById("btn-menu-mobile");
            const btnFecharMenu = document.getElementById("btn-fechar-menu");
            const sidebar = document.querySelector(".sidebar");

            if (btnMenuMobile && sidebar) btnMenuMobile.addEventListener("click", () => sidebar.classList.add("aberta"));
            if (btnFecharMenu && sidebar) btnFecharMenu.addEventListener("click", () => sidebar.classList.remove("aberta"));
        });

        // ==========================================
        // LÓGICA DE ITENS NO FORMULÁRIO DE CADASTRO
        // ==========================================
        let contadorItens = 1;
        document.getElementById('btn-add-item').addEventListener('click', () => {
            const container = document.getElementById('container-itens');
            const novaLinha = document.createElement('div');
            novaLinha.className = 'linha-item-cadastro';
            novaLinha.style = 'display: flex; gap: 15px; margin-bottom: 10px; align-items: center;';
            novaLinha.innerHTML = `
                <div class="form-group" style="flex: 3; margin: 0;">
                    <input type="text" name="itens[${contadorItens}][nome]" placeholder="Nome do item" required style="width: 100%;">
                </div>
                <div class="form-group" style="flex: 1; margin: 0;">
                    <input type="number" name="itens[${contadorItens}][preco]" step="0.01" placeholder="Preço" required style="width: 100%;">
                </div>
                <button type="button" onclick="removerLinha(this, '.linha-item-cadastro')" style="background: #ef4444; color: white; border: none; padding: 8px 12px; border-radius: 4px; cursor: pointer;">X</button>
            `;
            container.appendChild(novaLinha);
            contadorItens++;
        });

        // ==========================================
        // LÓGICA DE ITENS NO MODAL DE EDIÇÃO
        // ==========================================
        let contadorEditItens = 0;

        function abrirModalEditar(botao) {
            // Preenche os dados básicos do grupo
            document.getElementById('formEditarGrupo').action = botao.getAttribute('data-url');
            document.getElementById('edit_nome_grupo').value = botao.getAttribute('data-nome');
            document.getElementById('edit_qtd_min').value = botao.getAttribute('data-min');
            document.getElementById('edit_qtd_max').value = botao.getAttribute('data-max');
            document.getElementById('edit_status').value = botao.getAttribute('data-status');

            // Limpa o container de itens
            const containerEdit = document.getElementById('container-itens-edit');
            containerEdit.innerHTML = "";
            contadorEditItens = 0;

            // Transforma os itens em JSON e cria as linhas
            const itens = JSON.parse(botao.getAttribute('data-itens') || '[]');

            if (itens.length > 0) {
                itens.forEach(item => adicionarLinhaEdit(item.nome_adicional, item.preco_adicional));
            } else {
                adicionarLinhaEdit("", ""); // Se não tiver itens, cria 1 linha vazia
            }

            document.getElementById('modalEditar').style.display = 'block';
        }

        document.getElementById('btn-add-item-edit').addEventListener('click', () => {
            adicionarLinhaEdit("", "");
        });

        function adicionarLinhaEdit(nomeVal, precoVal) {
            const container = document.getElementById('container-itens-edit');
            const novaLinha = document.createElement('div');
            novaLinha.className = 'linha-item-editar';
            novaLinha.style = 'display: flex; gap: 15px; margin-bottom: 10px; align-items: center;';
            novaLinha.innerHTML = `
                <div class="form-group" style="flex: 3; margin: 0;">
                    <input type="text" name="itens[${contadorEditItens}][nome]" value="${nomeVal}" placeholder="Nome do item" required style="width: 100%;">
                </div>
                <div class="form-group" style="flex: 1; margin: 0;">
                    <input type="number" name="itens[${contadorEditItens}][preco]" value="${precoVal}" step="0.01" placeholder="Preço" required style="width: 100%;">
                </div>
                <button type="button" onclick="removerLinha(this, '.linha-item-editar')" style="background: #ef4444; color: white; border: none; padding: 8px 12px; border-radius: 4px; cursor: pointer;">X</button>
            `;
            container.appendChild(novaLinha);
            contadorEditItens++;
        }

        // ==========================================
        // FUNÇÃO DELETAR LINHA DE ITEM
        // ==========================================
        function removerLinha(botao, classeAlvo) {
            const linhas = document.querySelectorAll(classeAlvo);
            if (linhas.length > 1) {
                botao.parentElement.remove();
            } else {
                alert("O grupo precisa ter pelo menos um componente!");
            }
        }
    </script>
</body>

</html>
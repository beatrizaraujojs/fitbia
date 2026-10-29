<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cupons - Painel Admin</title>
    <link rel="stylesheet" href="{{ asset('fitbia/css/dashboard.css') }}">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>

<body>

    <div class="dash-container">
        
        {{-- MENU LATERAL CENTRALIZADO --}}
        @include('admin.dash.partials.side-bar')

        <main class="main-content">
            <header class="dash-header">
                <div class="header-left">
                    <button id="btn-menu-mobile" class="btn-menu-mobile" aria-label="Abrir Menu"><i class="ph ph-list"></i></button>
                    <h1>Gerenciar Cupons</h1>
                </div>

                <div style="display: flex; align-items: center; gap: 20px;">
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

            <section class="content-area" style="padding: 30px;">

                {{-- MENSAGEM DE SUCESSO (VERDE) --}}
                @if(session('sucesso'))
                <div style="background-color: #def7ec; color: #03543f; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem; font-weight: 500; border: 1px solid #31c48d; display: flex; align-items: center;">
                    <i class="ph ph-check-circle" style="margin-right: 0.5rem; font-size: 1.25rem;"></i>
                    {{ session('sucesso') }}
                </div>
                @endif

                {{-- MENSAGEM DE ALERTA / ERRO (VERMELHO) --}}
                @if(session('alerta') || $errors->any())
                <div style="background-color: #fde8e8; color: #9b1c1c; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem; font-weight: 500; border: 1px solid #f8b4b4;">
                    <div style="display: flex; align-items: center; margin-bottom: 0.25rem;">
                        <i class="ph ph-warning-circle" style="margin-right: 0.5rem; font-size: 1.25rem;"></i>
                        <span>{{ session('alerta') ?? 'Verifique os erros abaixo:' }}</span>
                    </div>
                    @if($errors->any())
                    <ul style="margin-left: 1.5rem; font-size: 0.9rem;">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    @endif
                </div>
                @endif

                <div class="admin-card">
                    <h2 class="card-title">Novo Cupom</h2>

                    <form action="{{ route('admin.cupons.store') }}" method="POST" class="admin-form">
                        @csrf

                        <div class="form-group">
                            <label for="codigo_cupom">Código do Cupom *</label>
                            <input type="text" id="codigo_cupom" name="codigo_cupom" placeholder="Ex: PRIMEPIEDIDO" style="text-transform: uppercase;" required>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="porcentagem_desconto">Desconto (%) *</label>
                                <input type="number" step="0.01" min="0.01" max="100" id="porcentagem_desconto" name="porcentagem_desconto" placeholder="Ex: 10.00" required>
                            </div>

                            <div class="form-group">
                                <label for="status_cupom">Status</label>
                                <select id="status_cupom" name="status_cupom">
                                    <option value="ATIVO">Ativo</option>
                                    <option value="INATIVO">Inativo</option>
                                </select>
                            </div>
                        </div>

                        <button type="submit" class="btn-salvar">Salvar Cupom</button>
                    </form>
                </div>

                <div class="admin-card mt-4" style="margin-top: 30px;">
                    <h2 class="card-title">Cupons Cadastrados</h2>

                    <div class="table-responsive">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Código</th>
                                    <th>Desconto</th>
                                    <th>Status</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($cupons as $cupom)
                                <tr>
                                    <td>{{ $cupom->id_cupom }}</td>
                                    <td><strong>{{ $cupom->codigo_cupom }}</strong></td>
                                    <td>{{ number_format($cupom->porcentagem_desconto, 2, ',', '.') }}%</td>

                                    <td>
                                        @if($cupom->status_cupom == 'ATIVO')
                                        <span style="background-color: #def7ec; color: #03543f; padding: 0.25rem 0.5rem; border-radius: 0.25rem; font-size: 0.875rem; font-weight: bold;">Ativo</span>
                                        @else
                                        <span style="background-color: #fde8e8; color: #9b1c1c; padding: 0.25rem 0.5rem; border-radius: 0.25rem; font-size: 0.875rem; font-weight: bold;">Inativo</span>
                                        @endif
                                    </td>

                                    <td>
                                        {{-- Botão Editar --}}
                                        <button type="button" class="btn-action edit" title="Editar"
                                            data-url="{{ route('admin.cupons.update', $cupom->id_cupom) }}"
                                            data-codigo="{{ $cupom->codigo_cupom }}"
                                            data-desconto="{{ $cupom->porcentagem_desconto }}"
                                            data-status="{{ $cupom->status_cupom }}"
                                            onclick="abrirModalEditarCupom(this)">
                                            <i class="ph ph-pencil-simple"></i>
                                        </button>

                                        {{-- Botão Excluir / Desativar --}}
                                        <form action="{{ route('admin.cupons.destroy', $cupom->id_cupom) }}" method="POST" style="display:inline;" onsubmit="return confirm('Deseja realmente excluir este cupom?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action delete" title="Excluir">
                                                <i class="ph ph-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" style="text-align: center; color: #6b7280; padding: 20px;">Nenhum cupom cadastrado.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </section>
        </main>
    </div>

    {{-- INCLUIR O MODAL DE EDITAR --}}
    @include('admin.dash.cupons.modal.editar')

    {{-- SCRIPTS --}}
    <script>
        function abrirModalEditarCupom(botao) {
            let url = botao.getAttribute('data-url');
            let codigo = botao.getAttribute('data-codigo');
            let desconto = botao.getAttribute('data-desconto');
            let status = botao.getAttribute('data-status');

            document.getElementById('form-editar-cupom').action = url;
            document.getElementById('edit_codigo_cupom').value = codigo;
            document.getElementById('edit_porcentagem_desconto').value = desconto;
            document.getElementById('edit_status_cupom').value = status;

            let modal = document.getElementById('modal-editar-cupom');
            modal.style.display = 'flex';
            modal.classList.add('ativo');
        }

        document.addEventListener("DOMContentLoaded", () => {
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
            const modalEditar = document.getElementById("modal-editar-cupom");
            const btnFecharEditar = document.getElementById("btn-fechar-editar-cupom");

            if (btnFecharEditar) {
                btnFecharEditar.addEventListener("click", () => {
                    modalEditar.style.display = 'none';
                    modalEditar.classList.remove('ativo');
                });
            }

            // Fecha clicando fora da caixa do modal
            window.addEventListener("click", (e) => {
                if (e.target === modalEditar) {
                    modalEditar.style.display = 'none';
                    modalEditar.classList.remove('ativo');
                }
            });
        });
    </script>

</body>

</html>
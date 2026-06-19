@extends('layout.site')

@section('content')
<style>
    /* --- Estilos Gerais do Painel --- */
    .painel-container { max-width: 1200px; margin: 40px auto; padding: 0 20px; font-family: 'Inter', sans-serif; }
    .painel-header { margin-bottom: 30px; border-bottom: 2px solid #eaeaea; padding-bottom: 20px; }
    .painel-header h1 { color: #2b4231; font-size: 28px; margin-bottom: 5px; }
    .painel-header p { color: #666; font-size: 16px; }
    .painel-grid { display: flex; gap: 30px; align-items: flex-start; }
    
    /* --- Menu Lateral --- */
    .painel-sidebar { width: 250px; background: #fff; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); overflow: hidden; flex-shrink: 0; }
    .painel-sidebar nav a { display: block; padding: 15px 20px; color: #444; text-decoration: none; border-left: 4px solid transparent; transition: all 0.3s ease; border-bottom: 1px solid #f5f5f5; cursor: pointer; }
    .painel-sidebar nav a:hover, .painel-sidebar nav a.active { background-color: #f8fbf9; color: #2b4231; border-left-color: #2b4231; font-weight: bold; }
    .btn-sair { width: 100%; padding: 15px 20px; background-color: transparent; border: none; color: #ff4d4f; cursor: pointer; font-weight: bold; text-align: left; transition: 0.3s; }
    .btn-sair:hover { background-color: #ffefef; }

    /* --- Área Principal e Formulários --- */
    .painel-content { flex: 1; width: 100%; }
    .card { background: #fff; border-radius: 8px; padding: 30px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); margin-bottom: 20px; }
    .card h2 { color: #2b4231; margin-bottom: 20px; font-size: 22px; border-bottom: 1px solid #eee; padding-bottom: 10px; }
    
    .form-group { margin-bottom: 15px; }
    .form-group label { display: block; margin-bottom: 5px; font-weight: bold; color: #333; font-size: 14px;}
    .form-group input { width: 100%; padding: 12px 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 16px; box-sizing: border-box; }
    .form-group input[readonly] { background-color: #f9f9f9; color: #888; cursor: not-allowed; }
    
    .form-row { display: flex; gap: 15px; }
    .form-row .form-group { flex: 1; }

    .btn-primary { background-color: #2b4231; color: #fff; padding: 12px 24px; border: none; border-radius: 6px; font-weight: bold; cursor: pointer; transition: 0.3s; }
    .btn-primary:hover { background-color: #3f5e47; }
    .alerta-sucesso { background-color: #d4edda; color: #155724; padding: 15px; border-radius: 4px; margin-bottom: 20px; border: 1px solid #c3e6cb; }
    .secao-oculta { display: none; }

    /* RESPONSIVO */
    @media (max-width: 768px) {
        .painel-container { margin: 20px auto; padding: 0 15px; }
        .painel-header h1 { font-size: 24px; }
        .painel-grid { flex-direction: column; gap: 20px; }
        .painel-sidebar { width: 100%; }
        .painel-sidebar nav { display: flex; border-bottom: 1px solid #eee; }
        .painel-sidebar nav a { flex: 1; text-align: center; padding: 12px 5px; font-size: 13px; border-left: none; border-bottom: 3px solid transparent; }
        .painel-sidebar nav a.active { border-left-color: transparent; border-bottom-color: #2b4231; background-color: #fff; }
        .btn-sair { text-align: center; border-top: 1px solid #eee; padding: 12px; }
        .card { padding: 20px; }
        .btn-primary { width: 100%; text-align: center; }
        .form-row { flex-direction: column; gap: 0; }
    }
</style>

<div class="painel-container">
    <header class="painel-header">
        <h1>Olá, {{ explode(' ', auth()->user()->nome_cliente)[0] }}!</h1>
        <p>Acompanhe seus pedidos e gerencie sua conta Fit Bia.</p>
    </header>

    @if(session('success'))
        <div class="alerta-sucesso">{{ session('success') }}</div>
    @endif
    {{-- MENSAGENS DE ERRO DE VALIDAÇÃO (Ex: CPF repetido) --}}
    @if($errors->any())
        <div style="background-color: #f8d7da; color: #721c24; padding: 15px; border-radius: 4px; margin-bottom: 20px; border: 1px solid #f5c6cb;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach($errors->all() as $error)
                    <li style="margin-bottom: 5px;">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        
        {{-- Script para forçar a abertura da aba de Perfil caso dê erro lá --}}
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                mudarAba('perfil');
            });
        </script>
    @endif
    <div class="painel-grid">
        <aside class="painel-sidebar">
            <nav>
                <a onclick="mudarAba('pedidos')" id="aba-pedidos" class="active">Meus Pedidos</a>
                <a onclick="mudarAba('perfil')" id="aba-perfil">Meu Perfil</a>
                <a onclick="mudarAba('enderecos')" id="aba-enderecos">Endereços</a>
            </nav>
            <form action="{{ route('cliente.logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-sair"> Sair da conta</button>
            </form>
        </aside>

        <main class="painel-content">
            
           <div id="secao-pedidos" class="card">
                <h2>Histórico de Pedidos</h2>

                @php
                    $pedidos = \App\Models\Pedido::where('id_cliente_fk', auth()->user()->id_cliente)
                                ->orderBy('created_at', 'desc')
                                ->get();
                @endphp

                @if($pedidos->count() > 0)
                    <div style="overflow-x: auto;">
                        <table style="width: 100%; border-collapse: collapse; text-align: left; margin-top: 10px; font-size: 14px;">
                            <thead>
                                <tr style="border-bottom: 2px solid #eaeaea; color: #666;">
                                    <th style="padding: 12px 10px;">Nº Pedido</th>
                                    <th style="padding: 12px 10px;">Data</th>
                                    <th style="padding: 12px 10px;">Valor Total</th>
                                    <th style="padding: 12px 10px;">Pagamento</th>
                                    <th style="padding: 12px 10px;">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pedidos as $ped)
                                    <tr style="border-bottom: 1px solid #f5f5f5;">
                                        <td style="padding: 15px 10px; font-weight: bold; color: #2b4231;">
                                            #{{ str_pad($ped->id_pedido, 4, '0', STR_PAD_LEFT) }}
                                        </td>
                                        <td style="padding: 15px 10px;">
                                            {{ date('d/m/Y H:i', strtotime($ped->created_at)) }}
                                        </td>
                                        <td style="padding: 15px 10px; font-weight: 600;">
                                            R$ {{ number_format($ped->valor_total_pedido, 2, ',', '.') }}
                                        </td>
                                        <td style="padding: 15px 10px; text-transform: capitalize;">
                                            {{ $ped->forma_pagamento_pedido }}
                                        </td>
                                        <td style="padding: 15px 10px;">
                                            @php
                                                $corFundo = $ped->status_pedido == 'PENDENTE' ? '#fff3cd' : '#e8f5e9';
                                                $corTexto = $ped->status_pedido == 'PENDENTE' ? '#856404' : '#2e7d32';
                                            @endphp
                                            <span style="background-color: {{ $corFundo }}; color: {{ $corTexto }}; padding: 5px 10px; border-radius: 20px; font-size: 12px; font-weight: bold;">
                                                {{ $ped->status_pedido }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div style="text-align: center; padding: 40px 20px; color: #777;">
                        <i class="ph ph-receipt" style="font-size: 48px; color: #ccc; margin-bottom: 15px;"></i>
                        <p>Você ainda não fez nenhum pedido com a gente.</p>
                        <br>
                        <a href="{{ route('site.cardapio') }}" class="btn-primary" style="text-decoration: none;">Ver Cardápio</a>
                    </div>
                @endif
            </div>

            <div id="secao-perfil" class="card secao-oculta">
                <h2>Editar Perfil</h2>
                <form action="{{ route('cliente.atualizar') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Nome Completo</label>
                        <input type="text" name="nome_cliente" value="{{ auth()->user()->nome_cliente }}" required>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>E-mail (Fixo)</label>
                            <input type="email" value="{{ auth()->user()->email_cliente }}" readonly>
                        </div>
                        <div class="form-group">
                            <label>WhatsApp</label>
                            <input type="text" name="whatsapp_cliente" value="{{ auth()->user()->whatsapp_cliente }}" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>CPF</label>
                            <input type="text" name="cpf_cliente" value="{{ auth()->user()->cpf_cliente }}" placeholder="000.000.000-00">
                        </div>
                        <div class="form-group">
                            <label>Data de Nascimento</label>
                            <input type="date" name="data_nascimento" value="{{ auth()->user()->data_nascimento }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Nova Senha (deixe em branco para não alterar)</label>
                        <input type="password" name="senha_cliente" placeholder="Digite apenas se quiser mudar a senha atual">
                    </div>
                    <button type="submit" class="btn-primary">Salvar Alterações</button>
                </form>
            </div>

            <div id="secao-enderecos" class="card secao-oculta">
                <h2>Meu Endereço de Entrega</h2>
                @php
                    $endereco = \App\Models\Endereco::where('id_cliente_fk', auth()->user()->id_cliente)->first();
                @endphp
                <form action="{{ route('cliente.endereco.salvar') }}" method="POST">
                    @csrf
                    <div class="form-row">
                        <div class="form-group" style="flex: 1;">
                            <label>CEP</label>
                            <input type="text" name="cep_endereco" value="{{ $endereco->cep_endereco ?? '' }}" required>
                        </div>
                        <div class="form-group" style="flex: 2;">
                            <label>Rua</label>
                            <input type="text" name="rua_endereco" value="{{ $endereco->rua_endereco ?? '' }}" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Número</label>
                            <input type="text" name="numero_endereco" value="{{ $endereco->numero_endereco ?? '' }}" required>
                        </div>
                        <div class="form-group">
                            <label>Complemento</label>
                            <input type="text" name="complemento_endereco" value="{{ $endereco->complemento_endereco ?? '' }}">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Bairro</label>
                            <input type="text" name="bairro_endereco" value="{{ $endereco->bairro_endereco ?? '' }}" required>
                        </div>
                        <div class="form-group">
                            <label>Cidade</label>
                            <input type="text" name="cidade_endereco" value="{{ $endereco->cidade_endereco ?? '' }}" required>
                        </div>
                    </div>
                    <button type="submit" class="btn-primary">Salvar Endereço</button>
                </form>
            </div>

        </main>
    </div>
</div>

<script>
    function mudarAba(aba) {
        document.getElementById('secao-pedidos').classList.add('secao-oculta');
        document.getElementById('secao-perfil').classList.add('secao-oculta');
        document.getElementById('secao-enderecos').classList.add('secao-oculta');
        
        document.getElementById('aba-pedidos').classList.remove('active');
        document.getElementById('aba-perfil').classList.remove('active');
        document.getElementById('aba-enderecos').classList.remove('active');

        document.getElementById('secao-' + aba).classList.remove('secao-oculta');
        document.getElementById('aba-' + aba).classList.add('active');
    }
</script>
@endsection
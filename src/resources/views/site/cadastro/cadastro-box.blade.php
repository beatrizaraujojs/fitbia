<div class="cadastro-box">
    <div class="cadastro-header">
        <h2>Crie sua conta</h2>
        <p>Faça parte da família Fit Bia e peça suas marmitas!</p>
    </div>

    {{-- BLOCO DE ERROS DE VALIDAÇÃO --}}
    @if ($errors->any())
    <div style="background-color: #fee2e2; border-left: 4px solid #ef4444; color: #991b1b; padding: 15px; margin-bottom: 20px; border-radius: 4px;">
        <strong style="display: block; margin-bottom: 5px;">Ops! Verifique os dados abaixo:</strong>
        <ul style="margin: 0; padding-left: 20px; font-size: 14px;">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- ADICIONADO: form com action, method e csrf --}}
    <form action="{{ route('cliente.registrar') }}" method="POST" class="cadastro-form">
        @csrf

        <div class="input-group">
            <label for="nome">Nome Completo</label>
            {{-- ADICIONADO: name="nome_cliente" --}}
            <input type="text" name="nome_cliente" value="{{ old('nome_cliente') }}" required>
        </div>

        <div class="input-group">
            <label for="telefone">WhatsApp</label>
            {{-- ADICIONADO: name="whatsapp_cliente" --}}


            <input type="text" name="whatsapp_cliente" value="{{ old('whatsapp_cliente') }}" required>
        </div>

        <div class="input-group">
            <label for="email">E-mail</label>
            {{-- ADICIONADO: name="email_cliente" --}}
            <input type="email" name="email_cliente" value="{{ old('email_cliente') }}" required>
        </div>

        <div class="input-group">
            <label for="senha">Crie uma Senha</label>
            {{-- ADICIONADO: name="senha_cliente" --}}
            <input type="password" id="senha" name="senha_cliente" placeholder="Mínimo de 6 caracteres" required>
        </div>

        <button type="submit" class="btn-cadastrar">Finalizar Cadastro</button>
    </form>

    <div class="cadastro-footer">
        <p>Já tem uma conta? <a href="{{ route('site.login') }}">Faça login aqui</a></p>
    </div>
</div>
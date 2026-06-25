<div class="cadastro-pagina-container">
    <div class="cadastro-box">
        <div class="cadastro-header">
            <h2>Crie sua conta</h2>
            <p>Faça parte da família Fit Bia e peça suas marmitas!</p>
        </div>

        {{-- BLOCO DE ERROS DE VALIDAÇÃO --}}
        @if ($errors->any())
            <div class="erro-validacao-box">
                <strong>Ops! Verifique os dados abaixo:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('cliente.registrar') }}" method="POST" class="cadastro-form">
            @csrf

            <div class="input-group">
                <label for="nome">Nome Completo</label>
                <input type="text" id="nome" name="nome_cliente" value="{{ old('nome_cliente') }}" placeholder="Seu nome completo" required>
            </div>

            <div class="input-group">
                <label for="telefone">WhatsApp</label>
                <input type="text" id="telefone" name="whatsapp_cliente" value="{{ old('whatsapp_cliente') }}" placeholder="(11) 99999-9999" required>
            </div>

            <div class="input-group">
                <label for="email">E-mail</label>
                <input type="email" id="email" name="email_cliente" value="{{ old('email_cliente') }}" placeholder="seuemail@exemplo.com" required>
            </div>

            <div class="input-group">
                <label for="senha">Crie uma Senha</label>
                <input type="password" id="senha" name="senha_cliente" placeholder="Mínimo de 6 caracteres" required>
            </div>

            <button type="submit" class="btn-cadastrar">Finalizar Cadastro</button>
        </form>

        <div class="cadastro-footer">
            <p>Já tem uma conta? <a href="#" id="link-ir-login-cadastro">Faça login aqui</a></p>
        </div>
    </div>
</div>

{{-- ======================================================== --}}
{{-- CSS DE CENTRALIZAÇÃO PREMIUM                             --}}
{{-- ======================================================== --}}
<style>
    /* O Segredo: Ocupa o meio da tela e distribui as laterais igualmente */
    .cadastro-pagina-container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 75vh; /* Perfeito para dar respiro entre o topo e o rodapé */
        width: 100%;
        background-color: var(--bg-principal, #FAF9F6);
        padding: 60px 20px;
        box-sizing: border-box;
    }

    .cadastro-box {
        background: #ffffff;
        width: 100%;
        max-width: 440px; /* Largura ideal de tela de autenticação */
        padding: 40px;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
        border: 1px solid rgba(0, 0, 0, 0.01);
        box-sizing: border-box;
    }

    .cadastro-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .cadastro-header h2 {
        font-family: 'Montserrat', sans-serif;
        font-size: 26px;
        font-weight: 700;
        color: var(--verde-escuro, #2b4230);
        margin: 0 0 8px 0;
    }

    .cadastro-header p {
        font-size: 14px;
        color: #6b7280;
        margin: 0;
    }

    /* Inputs Alinhados */
    .input-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
        margin-bottom: 20px;
    }

    .input-group label {
        font-size: 13px;
        font-weight: 600;
        color: #374151;
        text-align: left;
    }

    .input-group input {
        width: 100%;
        height: 46px;
        padding: 0 16px;
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        font-size: 14px;
        font-family: 'Inter', sans-serif;
        color: #111827;
        box-sizing: border-box;
        transition: all 0.3s ease;
    }

    .input-group input:focus {
        background: #ffffff;
        border-color: var(--verde-folha, #3C8A4B);
        box-shadow: 0 4px 12px rgba(60, 138, 75, 0.08);
        outline: none;
    }

    /* Botão de Envio */
    .btn-cadastrar {
        width: 100%;
        height: 48px;
        background-color: var(--verde-escuro, #2b4230);
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 15px;
        font-weight: 700;
        cursor: pointer;
        transition: background 0.3s;
        margin-top: 10px;
    }

    .btn-cadastrar:hover {
        background-color: var(--verde-folha, #3C8A4B);
    }

    .cadastro-footer {
        margin-top: 25px;
        text-align: center;
        font-size: 14px;
        color: #4b5563;
    }

    .cadastro-footer a {
        color: var(--verde-folha, #3C8A4B);
        font-weight: 700;
        text-decoration: none;
    }

    .cadastro-footer a:hover {
        text-decoration: underline;
    }

    /* Box de Erros */
    .erro-validacao-box {
        background-color: #fee2e2;
        border-left: 4px solid #ef4444;
        color: #991b1b;
        padding: 15px;
        margin-bottom: 25px;
        border-radius: 6px;
        font-size: 14px;
        text-align: left;
    }
    .erro-validacao-box ul {
        margin: 5px 0 0 0;
        padding-left: 20px;
    }
</style>

{{-- ======================================================== --}}
{{-- JAVASCRIPT: ACIONA O MODAL DO HEADER AUTOMATICAMENTE     --}}
{{-- ======================================================== --}}
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const linkLogin = document.getElementById('link-ir-login-cadastro');
        if (linkLogin) {
            linkLogin.addEventListener('click', (e) => {
                e.preventDefault();
                
                // Como o header está impresso na página, achamos o modal de login dele e abrimos direto!
                const modalLogin = document.getElementById('modal-login');
                if (modalLogin) {
                    modalLogin.style.display = 'flex';
                }
            });
        }
    });
</script>
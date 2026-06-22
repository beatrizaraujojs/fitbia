<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Administrativo - Fit Bia</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #f3f4f6;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-container {
            background-color: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
        }
        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .login-header h1 {
            margin: 0;
            color: #2b4231;
            font-size: 24px;
        }
        .login-header p {
            color: #6b7280;
            font-size: 14px;
            margin-top: 5px;
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
        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            box-sizing: border-box;
            font-size: 14px;
            outline: none;
        }
        .form-group input:focus {
            border-color: #10b981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2);
        }
        .btn-login {
            width: 100%;
            padding: 12px;
            background-color: #2b4231;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .btn-login:hover {
            background-color: #1e2f23;
        }
        .alert {
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            text-align: center;
        }
        .alert-error {
            background-color: #fee2e2;
            color: #991b1b;
            border: 1px solid #f87171;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <div class="login-header">
            <h1>🔒 Área Restrita</h1>
            <p>Painel de Controle - Fit Bia</p>
        </div>

        {{-- Exibe mensagens de erro caso o Laravel bloqueie a entrada ou a senha esteja errada --}}
        @if(session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-error">
                {{ $errors->first() }}
            </div>
        @endif

        {{-- O formulário apontando para a rota POST que criamos no web.php --}}
        <form action="{{ route('admin.login.post') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="email_usuario">E-mail Administrativo</label>
                <input type="email" id="email_usuario" name="email_usuario" value="{{ old('email_usuario') }}" required placeholder="exemplo@fitbia.com.br" autofocus>
            </div>

            <div class="form-group">
                <label for="senha_usuario">Senha</label>
                <input type="password" id="senha_usuario" name="senha_usuario" required placeholder="••••••••">
            </div>

            <button type="submit" class="btn-login">Entrar no Painel</button>
        </form>
    </div>

</body>
</html>
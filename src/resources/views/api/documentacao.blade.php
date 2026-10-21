<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documentação da API - FitBia</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; line-height: 1.6; margin: 0; padding: 20px; background-color: #fff0f3; color: #4a4a4a; }
        .container { max-width: 900px; margin: auto; background: #ffffff; padding: 35px; border-radius: 12px; box-shadow: 0 4px 15px rgba(219, 112, 147, 0.15); border: 1px solid #ffd1dc; }
        h1 { color: #d81b60; border-bottom: 2px solid #ffb6c1; padding-bottom: 12px; margin-top: 0; }
        h2 { color: #880e4f; margin-top: 35px; border-bottom: 1px solid #fce4ec; padding-bottom: 8px; }
        .info-box { background: #fff5f8; padding: 20px; border-radius: 8px; margin-bottom: 25px; border-left: 4px solid #d81b60; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; margin-bottom: 25px; }
        th, td { border: 1px solid #f8bbd0; padding: 12px; text-align: left; }
        th { background-color: #f8bbd0; color: #880e4f; font-weight: 600; }
        tr:nth-child(even) { background-color: #fff9fb; }
        tr:hover { background-color: #fff0f3; }
        .badge { padding: 5px 10px; border-radius: 6px; font-size: 11px; font-weight: bold; color: white; text-transform: uppercase; letter-spacing: 0.5px; }
        .get { background-color: #4db6ac; }
        .post { background-color: #ec407a; }
        .auth-req { color: #c2185b; font-weight: bold; }
        .auth-pub { color: #00897b; font-weight: bold; }
        code { background-color: #fce4ec; padding: 2px 6px; border-radius: 4px; color: #c2185b; font-family: Consolas, monospace; font-size: 0.9em; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Documentação da API - FitBia</h1>
        
        <div class="info-box">
            <p><strong>Nome da API:</strong> FitBia Backend API</p>
            <p><strong>URL Base:</strong> <code>https://colegasdev.tipi5.smpsistema.br/bia/api/v1</code></p>
            <p><strong>Versão:</strong> <code>v1</code></p>
            <p><strong>Descrição:</strong> Documentação oficial dos endpoints RESTful desenvolvidos para o sistema FitBia e integrados com o aplicativo mobile.</p>
        </div>

        <h2>Endpoints Disponíveis</h2>
        <table>
            <thead>
                <tr>
                    <th>Rota</th>
                    <th>Método</th>
                    <th>Acesso</th>
                    <th>Descrição & Parâmetros</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><code>/status</code></td>
                    <td><span class="badge get">GET</span></td>
                    <td><span class="auth-pub">Pública</span></td>
                    <td>Verifica o estado de funcionamento da API.</td>
                </tr>
                <tr>
                    <td><code>/categorias</code></td>
                    <td><span class="badge get">GET</span></td>
                    <td><span class="auth-pub">Pública</span></td>
                    <td>Lista todas as categorias de produtos disponíveis.</td>
                </tr>
                <tr>
                    <td><code>/categorias/{id}/produtos</code></td>
                    <td><span class="badge get">GET</span></td>
                    <td><span class="auth-pub">Pública</span></td>
                    <td>Lista os produtos associados a uma categoria específica.</td>
                </tr>
                <tr>
                    <td><code>/produtos</code></td>
                    <td><span class="badge get">GET</span></td>
                    <td><span class="auth-pub">Pública</span></td>
                    <td>Lista todos os produtos registados.</td>
                </tr>
                <tr>
                    <td><code>/produtos/{slug}</code></td>
                    <td><span class="badge get">GET</span></td>
                    <td><span class="auth-pub">Pública</span></td>
                    <td>Retorna os detalhes de um produto através do seu slug.</td>
                </tr>
                <tr>
                    <td><code>/auth/login</code></td>
                    <td><span class="badge post">POST</span></td>
                    <td><span class="auth-pub">Pública</span></td>
                    <td>Autentica o cliente e gera o token de acesso (Sanctum).<br><br><strong>Parâmetros (JSON):</strong> <code>email_cliente</code>, <code>senha_cliente</code>.</td>
                </tr>
                <tr>
                    <td><code>/cliente</code></td>
                    <td><span class="badge get">GET</span></td>
                    <td><span class="auth-req">Autenticada</span></td>
                    <td>Retorna os dados detalhados do cliente autenticado (incluindo foto de perfil).<br><br><strong>Headers:</strong> <code>Authorization: Bearer {token}</code>.</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>
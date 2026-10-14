<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documentação da API - FitBia</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; margin: 0; padding: 20px; background-color: #f4f6f9; color: #333; }
        .container { max-width: 900px; margin: auto; background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { color: #4B5320; border-bottom: 2px solid #4B5320; padding-bottom: 10px; }
        h2 { color: #333; margin-top: 30px; border-bottom: 1px solid #ddd; padding-bottom: 5px; }
        .info-box { background: #e9ecef; padding: 15px; border-radius: 5px; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; margin-bottom: 25px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #4B5320; color: white; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .badge { padding: 5px 10px; border-radius: 4px; font-size: 12px; font-weight: bold; color: white; }
        .get { background-color: #28a745; }
        .post { background-color: #007bff; }
        .auth-req { color: #dc3545; font-weight: bold; }
        .auth-pub { color: #28a745; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Documentação da API - FitBia</h1>
        
        <div class="info-box">
            <p><strong>Nome da API:</strong> FitBia Backend API</p>
            <p><strong>URL Base:</strong> <code>https://colegasdev.tipi5.smpsistema.br/bia/api/v1</code></p>
            <p><strong>Versão:</strong> <code>v1</code>[cite: 3, 8]</p>
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
                    <td>Verifica o estado de funcionamento da API[cite: 8].</td>
                </tr>
                <tr>
                    <td><code>/categorias</code></td>
                    <td><span class="badge get">GET</span></td>
                    <td><span class="auth-pub">Pública</span></td>
                    <td>Lista todas as categorias de produtos disponíveis[cite: 8, 9].</td>
                </tr>
                <tr>
                    <td><code>/categorias/{id}/produtos</code></td>
                    <td><span class="badge get">GET</span></td>
                    <td><span class="auth-pub">Pública</span></td>
                    <td>Lista os produtos associados a uma categoria específica[cite: 8].</td>
                </tr>
                <tr>
                    <td><code>/produtos</code></td>
                    <td><span class="badge get">GET</span></td>
                    <td><span class="auth-pub">Pública</span></td>
                    <td>Lista todos os produtos registados[cite: 8, 10].</td>
                </tr>
                <tr>
                    <td><code>/produtos/{slug}</code></td>
                    <td><span class="badge get">GET</span></td>
                    <td><span class="auth-pub">Pública</span></td>
                    <td>Retorna os detalhes de um produto através do seu slug[cite: 8].</td>
                </tr>
                <tr>
                    <td><code>/auth/login</code></td>
                    <td><span class="badge post">POST</span></td>
                    <td><span class="auth-pub">Pública</span></td>
                    <td>Autentica o cliente e gera o token de acesso (Sanctum).<br><strong>Parâmetros (JSON):</strong> <code>email_cliente</code>, <code>senha_cliente</code>[cite: 8].</td>
                </tr>
                <tr>
                    <td><code>/cliente</code></td>
                    <td><span class="badge get">GET</span></td>
                    <td><span class="auth-req">Autenticada</span></td>
                    <td>Retorna os dados detalhados do cliente autenticado (incluindo foto de perfil).<br><strong>Headers:</strong> <code>Authorization: Bearer {token}</code>[cite: 3, 8].</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>
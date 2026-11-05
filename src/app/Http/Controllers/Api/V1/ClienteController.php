<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\Cliente;

class ClienteController extends Controller
{
    // Buscar dados do cliente
    public function show(Request $request)
    {
        $cliente = $request->user();

        return response()->json([
            'success' => true,
            'data' => $cliente
        ]);
    }

    // Atualizar perfil e foto
    public function update(Request $request)
    {
        /** @var \App\Models\Cliente $cliente */
        $cliente = $request->user();

        $dados = $request->validate([
            'nome_cliente' => 'required|string|max:100',

            'email_cliente' =>
                'required|email|max:100|unique:tbl_cliente,email_cliente,'
                . $cliente->id_cliente . ',id_cliente',

            'whatsapp_cliente' => 'nullable|string|max:20',

            'cpf_cliente' =>
                'nullable|string|max:14|unique:tbl_cliente,cpf_cliente,'
                . $cliente->id_cliente . ',id_cliente',

            'data_nascimento' => 'nullable|date',

            // Agora recebe arquivo de imagem
            'foto_cliente' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        // Processar upload da foto
        if ($request->hasFile('foto_cliente')) {

            $foto = $request->file('foto_cliente');

            $nomeFoto = 'cliente_'
                . $cliente->id_cliente
                . '_'
                . time()
                . '.'
                . $foto->extension();

            $destino = public_path('clientes');

            // Criar pasta caso não exista
            if (!is_dir($destino)) {
                mkdir($destino, 0755, true);
            }

            // Salvar imagem na pasta public/clientes
            $foto->move($destino, $nomeFoto);

            // Salvar nome da foto no banco
            $dados['foto_cliente'] = $nomeFoto;
        } else {
            // Preservar foto atual
            unset($dados['foto_cliente']);
        }

        // Atualizar dados do cliente
        $cliente->update($dados);

        $cliente->refresh();

        return response()->json([
            'success' => true,
            'message' => 'Dados atualizados com sucesso.',
            'data' => $cliente
        ]);
    }

    // Atualizar senha do cliente
    public function updateSenha(Request $request)
    {
        /** @var \App\Models\Cliente $cliente */
        $cliente = $request->user();

        $request->validate([
            'senha_atual' => 'required|string',
            'nova_senha' => 'required|string|min:6|confirmed',
        ]);

        if (!Hash::check(
            $request->senha_atual,
            $cliente->senha_cliente
        )) {
            throw ValidationException::withMessages([
                'senha_atual' => [
                    'A senha atual está incorreta.'
                ],
            ]);
        }

        $cliente->update([
            'senha_cliente' => Hash::make(
                $request->nova_senha
            )
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Senha atualizada com sucesso.'
        ]);
    }
}

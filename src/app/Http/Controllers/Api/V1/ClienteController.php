<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ClienteController extends Controller
{
    /**
     * Retorna os dados do cliente autenticado.
     */
    public function show(Request $request)
    {
        return response()->json([
            'success' => true,
            'data' => $request->user()
        ]);
    }

    /**
     * Atualiza os dados cadastrais do cliente autenticado (suporta PUT e PATCH).
     */
    public function update(Request $request)
    {
        /** @var \App\Models\Cliente $cliente */
        $cliente = $request->user();

        $dados = $request->validate([
            'nome_cliente' => 'required|string|max:100',
            'email_cliente' => 'required|email|max:100|unique:tbl_cliente,email_cliente,' . $cliente->id_cliente . ',id_cliente',
            'whatsapp_cliente' => 'nullable|string|max:20',
            'cpf_cliente' => 'nullable|string|max:14|unique:tbl_cliente,cpf_cliente,' . $cliente->id_cliente . ',id_cliente',
            'data_nascimento' => 'nullable|date',
        ]);

        $cliente->update($dados);

        return response()->json([
            'success' => true,
            'message' => 'Dados atualizados com sucesso.',
            'data' => $cliente
        ]);
    }

    /**
     * Atualiza a senha do cliente autenticado.
     */
    public function updateSenha(Request $request)
    {
        /** @var \App\Models\Cliente $cliente */
        $cliente = $request->user();

        $request->validate([
            'senha_atual' => 'required|string',
            'nova_senha' => 'required|string|min:6|confirmed', // requer nova_senha_confirmation
        ]);

        // Verifica se a senha atual está correta
        if (!Hash::check($request->senha_atual, $cliente->senha_cliente)) {
            throw ValidationException::withMessages([
                'senha_atual' => ['A senha atual está incorreta.'],
            ]);
        }

        // Atualiza com a nova senha criptografada
        $cliente->update([
            'senha_cliente' => Hash::make($request->nova_senha)
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Senha atualizada com sucesso.'
        ]);
    }
}
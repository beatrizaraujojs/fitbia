<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // 1. Validar e-mail e senha recebidos
        $request->validate([
            'email_cliente' => 'required|email',
            'senha_cliente' => 'required',
        ]);

        // 2. Localizar o cliente pelo e-mail
        $cliente = Cliente::where('email_cliente', $request->email_cliente)->first();

        // 3. Validar se o cliente existe e se a senha está correta
        if (! $cliente || ! Hash::check($request->senha_cliente, $cliente->senha_cliente)) {
            return response()->json([
                'success' => false,
                'message' => 'Credenciais inválidas.'
            ], 401);
        }

        // 4. Confirmar que o cliente está ATIVO
        if ($cliente->status_cliente !== 'ATIVO') {
            return response()->json([
                'success' => false,
                'message' => 'Conta inativa.'
            ], 403);
        }

        // 5. Gerar o token usando o Sanctum
        $token = $cliente->createToken('auth_token')->plainTextToken;

        // 6. Retornar o token e os dados básicos em JSON
        return response()->json([
            'success' => true,
            'message' => 'Login realizado com sucesso.',
            'data' => [
                'token' => $token,
                'cliente' => [
                    'id_cliente' => $cliente->id_cliente,
                    'nome_cliente' => $cliente->nome_cliente,
                    'email_cliente' => $cliente->email_cliente,
                    'telefone_cliente' => $cliente->whatsapp_cliente,
                ]
            ]
        ]);
    }
}
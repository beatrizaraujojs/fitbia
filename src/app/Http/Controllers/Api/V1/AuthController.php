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
        $request->validate([
            'email_cliente' => 'required|email',
            'senha_cliente' => 'required',
        ]);

        $cliente = Cliente::where('email_cliente', $request->email_cliente)->first();

        if (! $cliente || ! Hash::check($request->senha_cliente, $cliente->senha_cliente)) {
            return response()->json([
                'success' => false,
                'message' => 'Credenciais inválidas.'
            ], 401);
        }

        if ($cliente->status_cliente !== 'ATIVO') {
            return response()->json([
                'success' => false,
                'message' => 'Conta inativa.'
            ], 403);
        }

        $token = $cliente->createToken('auth_token')->plainTextToken;

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

    public function register(Request $request)
    {
       
        $request->validate([
            'name' => 'required|string|max:100',
            'email_cliente' => 'required|email|max:100|unique:tbl_cliente,email_cliente',
            'telefone' => 'nullable|string|max:20',
            'password' => 'required|string|min:6',
        ]);

      
        $cliente = Cliente::create([
            'nome_cliente' => $request->name,
            'email_cliente' => $request->email_cliente,
            'whatsapp_cliente' => $request->telefone,
            'senha_cliente' => Hash::make($request->password),
            'status_cliente' => 'ATIVO',
        ]);

        $token = $cliente->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Conta criada com sucesso.',
            'data' => [
                'token' => $token,
                'cliente' => [
                    'id_cliente' => $cliente->id_cliente,
                    'nome_cliente' => $cliente->nome_cliente,
                    'email_cliente' => $cliente->email_cliente,
                    'telefone_cliente' => $cliente->whatsapp_cliente,
                ]
            ]
        ], 201);
    }
}
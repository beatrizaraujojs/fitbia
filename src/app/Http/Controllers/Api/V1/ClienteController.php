<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ClienteController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'nome_cliente' => 'required|string|max:100',
            'email_cliente' => 'required|email|unique:tbl_cliente,email_cliente',
            'senha_cliente' => 'required|string|min:6',
        ]);

        $cliente = Cliente::create([
            'nome_cliente' => $request->nome_cliente,
            'email_cliente' => $request->email_cliente,
            'senha_cliente' => Hash::make($request->senha_cliente),
            'telefone_cliente' => $request->telefone_cliente ?? null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Cliente cadastrado com sucesso!',
            'data' => $cliente
        ], 201);
    }

    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email_cliente' => 'required|email',
            'senha_cliente' => 'required|string',
        ]);

        $cliente = Cliente::where('email_cliente', $request->email_cliente)->first();

        if (!$cliente || !Hash::check($request->senha_cliente, $cliente->senha_cliente)) {
            return response()->json([
                'success' => false,
                'message' => 'Credenciais inválidas.'
            ], 401);
        }

        return response()->json([
            'success' => true,
            'message' => 'Login efetuado com sucesso!',
            'data' => $cliente
        ]);
    }

    public function show(int $id): JsonResponse
    {
        $cliente = Cliente::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $cliente
        ]);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $cliente = Cliente::findOrFail($id);

        $cliente->update($request->only([
            'nome_cliente',
            'telefone_cliente'
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Perfil atualizado com sucesso!',
            'data' => $cliente
        ]);
    }
}
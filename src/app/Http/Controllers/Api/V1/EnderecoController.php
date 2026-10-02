<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Endereco;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EnderecoController extends Controller
{
    public function index(int $cliente_id): JsonResponse
    {
        $enderecos = Endereco::where('id_cliente_fk', $cliente_id)->get();

        return response()->json([
            'success' => true,
            'data' => $enderecos
        ]);
    }

    public function store(Request $request, int $cliente_id): JsonResponse
    {
        $request->validate([
            'cep_endereco' => 'required|string',
            'logradouro_endereco' => 'required|string',
            'numero_endereco' => 'required|string',
            'bairro_endereco' => 'required|string',
            'cidade_endereco' => 'required|string',
            'estado_endereco' => 'required|string|size:2',
        ]);

        $endereco = Endereco::create([
            'id_cliente_fk' => $cliente_id,
            'cep_endereco' => $request->cep_endereco,
            'logradouro_endereco' => $request->logradouro_endereco,
            'numero_endereco' => $request->numero_endereco,
            'complemento_endereco' => $request->complemento_endereco ?? null,
            'bairro_endereco' => $request->bairro_endereco,
            'cidade_endereco' => $request->cidade_endereco,
            'estado_endereco' => $request->estado_endereco,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Endereço cadastrado com sucesso!',
            'data' => $endereco
        ], 201);
    }

    public function destroy(int $id): JsonResponse
    {
        $endereco = Endereco::findOrFail($id);
        $endereco->delete();

        return response()->json([
            'success' => true,
            'message' => 'Endereço removido com sucesso!'
        ]);
    }
}
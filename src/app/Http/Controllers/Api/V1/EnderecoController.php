<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Endereco;

class EnderecoController extends Controller
{
    public function index(Request $request)
    {
        $cliente = $request->user();
        $enderecos = Endereco::where('id_cliente_fk', $cliente->id_cliente)->get();

        return response()->json([
            'success' => true,
            'data' => $enderecos
        ], 200);
    }

    public function store(Request $request)
    {
        $cliente = $request->user();

        $validated = $request->validate([
            'nome_endereco'             => 'nullable|string|max:100',
            'cep_endereco'              => 'required|string|max:9',
            'rua_endereco'              => 'required|string|max:100',
            'numero_endereco'           => 'nullable|string|max:10',
            'complemento_endereco'      => 'nullable|string|max:100',
            'ponto_referencia_endereco' => 'nullable|string|max:100',
            'bairro_endereco'           => 'nullable|string|max:50',
            'cidade_endereco'           => 'nullable|string|max:50',
        ]);

        $validated['id_cliente_fk'] = $cliente->id_cliente;

        $endereco = Endereco::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Endereço cadastrado com sucesso!',
            'data'    => $endereco
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $cliente = $request->user();

        $endereco = Endereco::where('id_endereco', $id)
            ->where('id_cliente_fk', $cliente->id_cliente)
            ->firstOrFail();

        $validated = $request->validate([
            'nome_endereco'             => 'nullable|string|max:100',
            'cep_endereco'              => 'required|string|max:9',
            'rua_endereco'              => 'required|string|max:100',
            'numero_endereco'           => 'nullable|string|max:10',
            'complemento_endereco'      => 'nullable|string|max:100',
            'ponto_referencia_endereco' => 'nullable|string|max:100',
            'bairro_endereco'           => 'nullable|string|max:50',
            'cidade_endereco'           => 'nullable|string|max:50',
        ]);

        $endereco->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Endereço atualizado com sucesso!',
            'data'    => $endereco
        ], 200);
    }

    public function destroy(Request $request, $id)
    {
        $cliente = $request->user();

        $endereco = Endereco::where('id_endereco', $id)
            ->where('id_cliente_fk', $cliente->id_cliente)
            ->firstOrFail();

        $endereco->delete();

        return response()->json([
            'success' => true,
            'message' => 'Endereço excluído com sucesso!'
        ], 200);
    }
}
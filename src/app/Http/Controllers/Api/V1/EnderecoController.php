<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Endereco;
use Illuminate\Http\Request;

class EnderecoController extends Controller
{
    // Listar endereços do cliente
    public function index(Request $request)
    {
        $cliente = $request->user();

        $enderecos = Endereco::where(
            'id_cliente_fk',
            $cliente->id_cliente
        )->get();

        return response()->json([
            'success' => true,
            'data' => $enderecos
        ], 200);
    }

    // Cadastrar endereço
    public function store(Request $request)
    {
        $dados = $request->validate([
            'nome_endereco' => 'nullable|string|max:100',
            'cep_endereco' => 'required|string|max:9',
            'rua_endereco' => 'required|string|max:100',
            'numero_endereco' => 'nullable|string|max:10',
            'complemento_endereco' => 'nullable|string|max:100',
            'ponto_referencia_endereco' => 'nullable|string|max:100',
            'bairro_endereco' => 'nullable|string|max:50',
            'cidade_endereco' => 'nullable|string|max:50',
        ]);

        $dados['id_cliente_fk'] = $request->user()->id_cliente;

        $endereco = Endereco::create($dados);

        return response()->json([
            'success' => true,
            'message' => 'Endereço cadastrado com sucesso!',
            'data' => $endereco
        ], 201);
    }

    // Atualizar endereço
    public function update(Request $request, $id)
    {
        $endereco = Endereco::where(
            'id_cliente_fk',
            $request->user()->id_cliente
        )
        ->where('id_endereco', $id)
        ->firstOrFail();

        $dados = $request->validate([
            'nome_endereco' => 'sometimes|nullable|string|max:100',
            'cep_endereco' => 'sometimes|required|string|max:9',
            'rua_endereco' => 'sometimes|required|string|max:100',
            'numero_endereco' => 'sometimes|nullable|string|max:10',
            'complemento_endereco' => 'sometimes|nullable|string|max:100',
            'ponto_referencia_endereco' => 'sometimes|nullable|string|max:100',
            'bairro_endereco' => 'sometimes|nullable|string|max:50',
            'cidade_endereco' => 'sometimes|nullable|string|max:50',
        ]);

        $endereco->update($dados);

        return response()->json([
            'success' => true,
            'message' => 'Endereço atualizado com sucesso!',
            'data' => $endereco
        ], 200);
    }

    // Excluir endereço
    public function destroy(Request $request, $id)
    {
        $endereco = Endereco::where(
            'id_cliente_fk',
            $request->user()->id_cliente
        )
        ->where('id_endereco', $id)
        ->firstOrFail();

        $endereco->delete();

        return response()->json([
            'success' => true,
            'message' => 'Endereço excluído com sucesso!'
        ], 200);
    }
}

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
     * Atualiza os dados cadastrais do cliente autenticado.
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
            'foto_cliente' => 'nullable|string',
        ]);

        // Se o utilizador escolheu uma nova foto (em formato Base64)
        if ($request->filled('foto_cliente') && str_starts_with($request->foto_cliente, 'data:image')) {
            try {
                $image = $request->foto_cliente;
                
                list($type, $image) = explode(';', $image);
                list(, $image)      = explode(',', $image);
                
                $extension = explode('/', $type)[1] ?? 'jpg';
                $imageName = 'cliente_' . $cliente->id_cliente . '_' . time() . '.' . $extension;
                
                $destinationPath = public_path('clientes');
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }
                
                file_put_contents($destinationPath . '/' . $imageName, base64_decode($image));
                
                $dados['foto_cliente'] = $imageName;
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erro ao processar a imagem: ' . $e->getMessage()
                ], 422);
            }
        } else {
            // Se manteve a foto antiga ou não alterou, remove do array para não sobrescrever indevidamente
            unset($dados['foto_cliente']);
        }

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
            'nova_senha' => 'required|string|min:6|confirmed',
        ]);

        if (!Hash::check($request->senha_atual, $cliente->senha_cliente)) {
            throw ValidationException::withMessages([
                'senha_atual' => ['A senha atual está incorreta.'],
            ]);
        }

        $cliente->update([
            'senha_cliente' => Hash::make($request->nova_senha)
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Senha atualizada com sucesso.'
        ]);
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GrupoAdicional; // Ajuste para o nome exato do seu Model de grupos

class GrupoAdicionalController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validar os dados que vieram do modal
        $request->validate([
            'id_produto_fk'        => 'required|integer',
            'nome_grupo_adicional' => 'required|string|max:100',
            'qtd_min_grupo'        => 'required|integer|min:0',
            'qtd_max_grupo'        => 'required|integer|min:1',
            'status_grupo'         => 'required|in:ATIVO,INATIVO',
        ]);

        // 2. Salvar no banco de dados
        $grupo = new GrupoAdicional(); // Ajuste o nome do Model se for diferente
        $grupo->id_produto_fk        = $request->id_produto_fk;
        $grupo->nome_grupo_adicional = $request->nome_grupo_adicional;
        $grupo->qtd_min_grupo        = $request->qtd_min_grupo;
        $grupo->qtd_max_grupo        = $request->qtd_max_grupo;
        $grupo->status_grupo         = $request->status_grupo;
        $grupo->save();

        // 3. Voltar para a tela com a mensagem de sucesso que já configuramos
        return redirect()->back()->with('success', 'Grupo adicional criado com sucesso!');
    }

    
}
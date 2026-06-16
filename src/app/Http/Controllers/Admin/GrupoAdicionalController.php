<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GrupoAdicional;

class GrupoAdicionalController extends Controller
{
    // 1. CARREGA A TELA DO FORMULÁRIO
    public function index()
    {
        $grupos = GrupoAdicional::with('adicionais')->orderBy('nome_grupo_adicional')->get();
        return view('admin.dash.grupoadicional.index', compact('grupos'));
    }

    // 2. SALVAR NOVO GRUPO
    public function store(Request $request)
    {
        $request->validate([
            'nome_grupo_adicional' => 'required|string|max:100',
            'qtd_min_grupo'        => 'required|integer|min:0',
            'qtd_max_grupo'        => 'required|integer|min:1',
            'status_grupo'         => 'required|in:ATIVO,INATIVO',
            'itens'                => 'required|array|min:1',
            'itens.*.nome'         => 'required|string|max:100',
            'itens.*.preco'        => 'required|numeric|min:0',
        ]);

        $grupo = new GrupoAdicional();
        $grupo->nome_grupo_adicional = $request->nome_grupo_adicional;
        $grupo->qtd_min_grupo        = $request->qtd_min_grupo;
        $grupo->qtd_max_grupo        = $request->qtd_max_grupo;
        $grupo->status_grupo         = $request->status_grupo;
        $grupo->save();

        foreach ($request->itens as $item) {
            $grupo->adicionais()->create([
                'nome_adicional'   => $item['nome'],
                'preco_adicional'  => $item['preco'],
                'status_adicional' => 'ATIVO'
            ]);
        }

        return redirect()->back()->with('success', 'Grupo e componentes criados com sucesso!');
    }

    // 3. EDITAR GRUPO
    public function update(Request $request, $id)
    {
        $request->validate([
            'nome_grupo_adicional' => 'required|string|max:100',
            'qtd_min_grupo'        => 'required|integer|min:0',
            'qtd_max_grupo'        => 'required|integer|min:1',
            'status_grupo'         => 'required|in:ATIVO,INATIVO',
            'itens'                => 'required|array|min:1',
            'itens.*.nome'         => 'required|string|max:100',
            'itens.*.preco'        => 'required|numeric|min:0',
        ]);

        $grupo = GrupoAdicional::findOrFail($id);
        $grupo->update([
            'nome_grupo_adicional' => $request->nome_grupo_adicional,
            'qtd_min_grupo'        => $request->qtd_min_grupo,
            'qtd_max_grupo'        => $request->qtd_max_grupo,
            'status_grupo'         => $request->status_grupo,
        ]);

        // Apaga os itens antigos e salva os novos da edição
        $grupo->adicionais()->delete();

        foreach ($request->itens as $item) {
            $grupo->adicionais()->create([
                'nome_adicional'   => $item['nome'],
                'preco_adicional'  => $item['preco'],
                'status_adicional' => 'ATIVO'
            ]);
        }

        return redirect()->back()->with('success', 'Grupo atualizado com sucesso!');
    }

   
   // 4. DESATIVAR GRUPO (Muda o status em vez de apagar do banco)
    public function destroy($id)
    {
        $grupo = GrupoAdicional::findOrFail($id);
        
        // Em vez de deletar, nós mudamos o status para INATIVO
        $grupo->status_grupo = 'INATIVO';
        $grupo->save();

        // Opcional: Se quiser que os componentes dentro dele também fiquem inativos no banco, 
        // usamos o comando abaixo. Se não, pode apagar a linha.
        $grupo->adicionais()->update(['status_adicional' => 'INATIVO']);

        return redirect()->back()->with('success', 'Grupo desativado com sucesso! Ele não aparecerá mais no cardápio.');
    }
}
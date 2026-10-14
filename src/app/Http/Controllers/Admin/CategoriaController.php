<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categoria;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::orderBy('nome_categoria')->get();
        return view('admin.dash.categoria.index', compact('categorias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome_categoria'           => 'required|string|max:100',
            'ordem_exibicao_categoria' => 'nullable|integer',
            'ativa_categoria'          => 'required|in:ATIVO,INATIVO',
        ]);

        Categoria::create([
            'nome_categoria'           => $request->nome_categoria,
            'ordem_exibicao_categoria' => $request->ordem_exibicao_categoria ?? 0,
            'ativa_categoria'          => $request->ativa_categoria,
        ]);

        return redirect()
            ->route('admin.categoria.index')
            ->with('sucesso', 'Categoria cadastrada com sucesso!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nome_categoria'           => 'required|string|max:100',
            'ordem_exibicao_categoria' => 'nullable|integer',
            'ativa_categoria'          => 'required|in:ATIVO,INATIVO',
        ]);

        $categoria = Categoria::findOrFail($id);
        $statusAntigo = $categoria->ativa_categoria;

        $categoria->update([
            'nome_categoria'           => $request->nome_categoria,
            'ordem_exibicao_categoria' => $request->ordem_exibicao_categoria ?? 0,
            'ativa_categoria'          => $request->ativa_categoria,
        ]);

        if ($request->ativa_categoria === 'INATIVO' && $statusAntigo === 'ATIVO') {
            return redirect()
                ->route('admin.categoria.index')
                ->with('alerta', 'Categoria desativada com sucesso!');
        }

        return redirect()
            ->route('admin.categoria.index')
            ->with('sucesso', 'Categoria atualizada com sucesso!');
    }

    public function destroy($id)
    {
        $categoria = Categoria::findOrFail($id);

        $categoria->update([
            'ativa_categoria' => 'INATIVO'
        ]);

        return redirect()
            ->route('admin.categoria.index')
            ->with('alerta', 'Categoria desativada com sucesso!');
    }
}

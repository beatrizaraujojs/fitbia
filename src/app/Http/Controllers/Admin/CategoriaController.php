<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categoria;
use Illuminate\Support\Facades\Redirect;

class CategoriaController extends Controller
{
    public function index()
    {
        // Ordena pelo nome, como no seu padrão
        $categorias = Categoria::orderBy('nome_categoria')->get();

        // Usei o caminho com '.dash.' baseado no erro que você teve na tela anterior
        return view('admin.dash.categoria.index', compact('categorias'));
    }

    // MÉTODO CRIAR
    public function store(Request $request)
    {
        $request->validate([
            'nome_categoria'           => 'required|string|max:100',
            'ordem_exibicao_categoria' => 'nullable|integer', // Adaptado do seu banco
            'ativa_categoria'          => 'required|in:ATIVO,INATIVO', // Adaptado do seu banco
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

    // MÉTODO DESATIVAR
    public function desativar($id)
    {
        $categoria = Categoria::findOrFail($id);
        
        $categoria->update([
            'ativa_categoria' => 'INATIVO'
        ]);

        return redirect()
            ->route('admin.categoria.index')
            ->with('sucesso', 'Categoria desativada com sucesso!');
    }

    // MÉTODO ATIVAR
    public function ativar($id)
    {
        $categoria = Categoria::findOrFail($id);
        
        $categoria->update([
            'ativa_categoria' => 'ATIVO'
        ]);

        return redirect()
            ->route('admin.categoria.index')
            ->with('sucesso', 'Categoria ativada com sucesso!');
    }

    // MÉTODO ATUALIZAR
    public function update(Request $request, $id)
    {
        $request->validate([
            'nome_categoria'           => 'required|string|max:100',
            'ordem_exibicao_categoria' => 'nullable|integer',
            'ativa_categoria'          => 'required|in:ATIVO,INATIVO',
        ]);

        $categoria = Categoria::findOrFail($id);

        $categoria->update([
            'nome_categoria'           => $request->nome_categoria,
            'ordem_exibicao_categoria' => $request->ordem_exibicao_categoria ?? 0,
            'ativa_categoria'          => $request->ativa_categoria,
        ]);

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
            ->with('success', 'Categoria desativada com sucesso!');
    }
    

    
}
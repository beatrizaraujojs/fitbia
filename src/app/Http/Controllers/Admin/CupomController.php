<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cupom;

class CupomController extends Controller
{
    // Exibe a lista de cupons no painel
    public function index()
    {
        $cupons = Cupom::orderBy('created_at', 'desc')->get();
        return view('admin.dash.cupons.index', compact('cupons'));
    }

    // Salva um novo cupom no banco de dados
    public function store(Request $request)
    {
        $request->validate([
            'codigo_cupom' => 'required|string|max:20|unique:tbl_cupom,codigo_cupom',
            'porcentagem_desconto' => 'required|numeric|min:0.01|max:100',
            'status_cupom' => 'required|in:ATIVO,INATIVO',
        ]);

        Cupom::create([
            'codigo_cupom' => strtoupper(trim($request->codigo_cupom)),
            'porcentagem_desconto' => $request->porcentagem_desconto,
            'status_cupom' => $request->status_cupom,
        ]);

        return redirect()->back()->with('sucesso', 'Cupom criado com sucesso!');
    }

    // Atualiza o cupom existente (via modal)
    public function update(Request $request, $id)
    {
        $cupom = Cupom::findOrFail($id);

        $request->validate([
            'codigo_cupom' => 'required|string|max:20|unique:tbl_cupom,codigo_cupom,' . $id . ',id_cupom',
            'porcentagem_desconto' => 'required|numeric|min:0.01|max:100',
            'status_cupom' => 'required|in:ATIVO,INATIVO',
        ]);

        $cupom->update([
            'codigo_cupom' => strtoupper(trim($request->codigo_cupom)),
            'porcentagem_desconto' => $request->porcentagem_desconto,
            'status_cupom' => $request->status_cupom,
        ]);

        return redirect()->back()->with('sucesso', 'Cupom atualizado com sucesso!');
    }

    // Altera o status entre ATIVO e INATIVO
    public function toggleStatus($id)
    {
        $cupom = Cupom::findOrFail($id);
        $cupom->status_cupom = $cupom->status_cupom === 'ATIVO' ? 'INATIVO' : 'ATIVO';
        $cupom->save();

        return redirect()->back()->with('sucesso', 'Status do cupom atualizado!');
    }

    // Exclui o cupom
    public function destroy($id)
    {
        $cupom = Cupom::findOrFail($id);
        $cupom->delete();

        return redirect()->back()->with('sucesso', 'Cupom removido com sucesso!');
    }
}

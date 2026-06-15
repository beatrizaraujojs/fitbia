<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Categoria;
use App\Models\Produto;
use Illuminate\Support\Str;
use App\Models\GrupoAdicional;

class ProdutoController extends Controller
{
    public function index()
    {
        // 1. Busca os produtos
        // Altera de: Produto::orderBy('nome_produto')->get();
        // Para isto:
        $produtos = Produto::with('gruposAdicionais')->orderBy('nome_produto')->get();

        // 2. Busca as categorias ativas
        $categorias = Categoria::where('ativa_categoria', 'ATIVO')
            ->orderBy('nome_categoria')
            ->get();

        // 3. Busca os grupos ativos
        $grupos = GrupoAdicional::where('status_grupo', 'ATIVO')->get();

        // 4. Envia TODAS as variáveis ('produtos', 'categorias' e 'grupos') para a view
        return view('admin.dash.produto.index', compact('produtos', 'categorias', 'grupos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome_produto'        => 'required|string|max:100',
            'id_categoria_fk'     => 'required|exists:tbl_categoria,id_categoria',
            'descricao_produto'   => 'nullable|string',
            'preco_base_produto'  => 'required|numeric|min:0',
            'foto_produto'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status_produto'      => 'required|in:ATIVO,INATIVO',
            'destaque_produto'    => 'required|in:SIM,NAO',
        ]);

        $caminhoFoto = null;

        if ($request->hasFile('foto_produto')) {
            $fotoProduto = $request->file('foto_produto');
            $slugProduto = Str::slug($request->nome_produto);
            $nomeFoto = $slugProduto . '_' . time() . '.' . $fotoProduto->getClientOriginalExtension();
            $fotoProduto->move(public_path('fitbia/images/produto/'), $nomeFoto);
            $caminhoFoto = $nomeFoto;
        }

        // 1. Cadastra o produto e guarda o resultado na variável $produto
        $produto = Produto::create([
            'nome_produto'        => $request->nome_produto,
            'id_categoria_fk'     => $request->id_categoria_fk,
            'descricao_produto'   => $request->descricao_produto,
            'preco_base_produto'  => $request->preco_base_produto,
            'foto_produto'        => $caminhoFoto,
            'status_produto'      => $request->status_produto,
            'destaque_produto'    => $request->destaque_produto,
        ]);

        // 2. MÁGICA DO MANY-TO-MANY: Se marcou "Sim" e escolheu grupos, salva na tabela intermediária
        if ($request->tem_adicionais === 'sim' && $request->has('grupos_adicionais')) {
            $gruposSelecionados = $request->input('grupos_adicionais');

            // O Laravel vai lá na 'tbl_produto_grupo_adicional' e cria as linhas sozinho
            $produto->gruposAdicionais()->attach($gruposSelecionados);
        }

        return redirect()
            ->route('admin.produto.index')
            ->with('success', 'Produto cadastrado com sucesso!');
    }

    public function edit($id)
    {
        $produto = Produto::findOrFail($id);

        $categorias = Categoria::where('ativa_categoria', 'ATIVO')
            ->orderBy('nome_categoria')
            ->get();

        return view('admin.produto.edit', compact('produto', 'categorias'));
    }

    public function update(Request $request, $id)


    {
        $produto = Produto::findOrFail($id);
        // dd($request->all());


        $request->validate([
            'nome_produto'        => 'required|string|max:100',
            'id_categoria_fk'     => 'required|exists:tbl_categoria,id_categoria',
            'descricao_produto'   => 'nullable|string',
            'preco_base_produto'  => 'required|numeric|min:0',
            'foto_produto'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status_produto'      => 'required|in:ATIVO,INATIVO',
            'destaque_produto'    => 'required|in:SIM,NAO',
        ]);

        $caminhoFoto = $produto->foto_produto;

        if ($request->hasFile('foto_produto')) {
            if ($produto->foto_produto) {
                $fotoAntiga = public_path('fitbia/images/produto/' . $produto->foto_produto);
                if (file_exists($fotoAntiga) && is_file($fotoAntiga)) {
                    unlink($fotoAntiga);
                }
            }

            $fotoProduto = $request->file('foto_produto');
            $slugProduto = Str::slug($request->nome_produto);
            $nomeFoto = $slugProduto . '_' . time() . '.' . $fotoProduto->getClientOriginalExtension();
            $fotoProduto->move(public_path('fitbia/images/produto/'), $nomeFoto);
            $caminhoFoto = $nomeFoto;
        }

        // 1. Atualiza os dados básicos do produto (Nome, Preço, Categoria...)
        $produto->update([
            'nome_produto'        => $request->nome_produto,
            'id_categoria_fk'     => $request->id_categoria_fk,
            'descricao_produto'   => $request->descricao_produto,
            'preco_base_produto'  => $request->preco_base_produto,
            'foto_produto'        => $caminhoFoto,
            'status_produto'      => $request->status_produto,
            'destaque_produto'    => $request->destaque_produto,
        ]);

        // 2. ATUALIZA OS GRUPOS ADICIONAIS NA TABELA INTERMEDIÁRIA
        if ($request->edit_tem_adicionais === 'sim' && $request->has('grupos_adicionais')) {
            $gruposSelecionados = $request->input('grupos_adicionais');

            // O sync() remove o que não foi marcado e adiciona o que foi marcado
            $produto->gruposAdicionais()->sync($gruposSelecionados);
        } else {
            // Se marcou "Não" ou desmarcou tudo, limpa todas as ligações antigas desse produto
            $produto->gruposAdicionais()->sync([]);
        }

        return redirect()
            ->route('admin.produto.index')
            ->with('success', 'Produto atualizado com sucesso!');
    }

    public function destroy($id)
    {
        // Busca o produto no banco
        $produto = Produto::findOrFail($id);

        // Em vez de deletar fisicamente e apagar a foto, apenas altera o status para INATIVO
        $produto->update([
            'status_produto' => 'INATIVO'
        ]);

        // Redireciona de volta com a mensagem correta
        return redirect()
            ->route('admin.produto.index')
            ->with('success', 'Produto desativado com sucesso!');
    }


    public function adicionais($id)
    {
        // 1. Busca o produto
        $produto = \App\Models\Produto::findOrFail($id);

        // 2. Busca os grupos adicionais que pertencem a este produto
        // Presumindo que você tem um Model GrupoAdicional
        $grupos = \App\Models\GrupoAdicional::where('id_produto_fk', $id)->get();

        // 3. Retorna a nova tela passando as variáveis
        return view('admin.dash.produto.adicionais', compact('produto', 'grupos'));
    }
}

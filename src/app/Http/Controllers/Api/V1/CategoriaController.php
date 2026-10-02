<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoriaController extends Controller
{
    /**
     * Lista todas as categorias ativas ordenadas pela ordem de exibição.
     */
    public function index()
    {
        // Busca as categorias ativas no banco de dados usando a tabela customizada
        $categorias = DB::table('tbl_categoria')
            ->where('ativa_categoria', 'ATIVO')
            ->orderBy('ordem_exibicao_categoria', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $categorias
        ], 200);
    }

    /**
     * Retorna os produtos vinculados a uma categoria específica.
     */
    public function produtos($id)
    {
        // Verifica se a categoria existe
        $categoria = DB::table('tbl_categoria')
            ->where('id_categoria', $id)
            ->first();

        if (!$categoria) {
            return response()->json([
                'success' => false,
                'message' => 'Categoria não encontrada.'
            ], 404);
        }

        // Busca os produtos daquela categoria (ajuste o nome da tabela/coluna de produtos se necessário futuramente)
        $produtos = DB::table('tbl_produto')
            ->where('id_categoria_fk', $id) // Substitua 'id_categoria_fk' pela chave estrangeira real na sua tabela de produtos
            ->where('ativo_produto', 'ATIVO')
            ->get();

        return response()->json([
            'success' => true,
            'categoria' => $categoria,
            'produtos' => $produtos
        ], 200);
    }
}
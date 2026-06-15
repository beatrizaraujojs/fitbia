<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    public $timestamps = true;
    protected $table = 'tbl_produto';
    protected $primaryKey = 'id_produto';

    protected $fillable = [
        'id_categoria_fk',
        'nome_produto',
        'descricao_produto',
        'foto_produto',
        'preco_base_produto',
        'status_produto',
        'destaque_produto'
    ];

    // Um produto pertence a uma categoria
    public function categoria() {
        return $this->belongsTo(Categoria::class, 'id_categoria_fk', 'id_categoria');
    }

    // ALTERADO: Agora é uma relação Muitos para Muitos (belongsToMany)
    public function gruposAdicionais() {
        return $this->belongsToMany(
            GrupoAdicional::class,
            'tbl_produto_grupo_adicional', // Nome da tabela intermediária que criou no MySQL
            'id_produto_fk',               // Chave estrangeira do Produto na tabela pivot
            'id_grupo_adicional_fk'        // Chave estrangeira do Grupo na tabela pivot
        );
    }
}
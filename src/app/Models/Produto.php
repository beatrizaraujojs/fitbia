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

    // Um produto tem muitos grupos de adicionais
    public function gruposAdicionais() {
        return $this->hasMany(GrupoAdicional::class, 'id_produto_fk', 'id_produto');
    }
}
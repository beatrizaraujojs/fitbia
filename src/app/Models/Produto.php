<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $table = 'tbl_produto';
    protected $primaryKey = 'id_produto';

    // Um produto tem muitos grupos de adicionais (ex: Complementos, Molhos)
    public function gruposAdicionais()
    {
        return $this->hasMany(GrupoAdicional::class, 'id_produto_fk', 'id_produto');
    }
}
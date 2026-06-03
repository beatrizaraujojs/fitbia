<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    // ⚠️ ESSA LINHA EXATAMENTE AQUI FAZ O ERRO SUMIR:
    protected $table = 'tbl_categoria';
    protected $primaryKey = 'id_categoria';

    public function produtos()
    {
        return $this->hasMany(Produto::class, 'id_categoria_fk', 'id_categoria');
    }
}
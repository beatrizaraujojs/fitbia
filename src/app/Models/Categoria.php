<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'tbl_categoria';
    protected $primaryKey = 'id_categoria';

    public $timestamps = true;

    protected $fillable = [
        'nome_categoria',
        'ordem_exibicao_categoria',
        'ativa_categoria',
    ];

    public function produtos()
    {
        return $this->hasMany(Produto::class, 'id_categoria_fk', 'id_categoria');
    }
}
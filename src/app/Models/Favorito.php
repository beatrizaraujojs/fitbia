<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorito extends Model
{
    protected $table = 'tbl_favorito';
    protected $primaryKey = 'id_favorito';
    public $timestamps = false; // Como a tabela só tem created_at e não updated_at (conforme a imagem)

    protected $fillable = [
        'id_cliente_fk',
        'id_produto_fk'
    ];
}
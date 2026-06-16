<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Adicional extends Model
{
    protected $table = 'tbl_adicional';
    protected $primaryKey = 'id_adicional';

    // ADICIONE ESTA LINHA ABAIXO:
    protected $fillable = [
        'id_grupo_fk',
        'nome_adicional',
        'preco_adicional',
        'status_adicional'
    ];
    
}
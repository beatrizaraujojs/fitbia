<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cupom extends Model
{
    protected $table = 'tbl_cupom';
    protected $primaryKey = 'id_cupom';

    protected $fillable = [
        'codigo_cupom',
        'porcentagem_desconto',
        'status_cupom',
    ];
}
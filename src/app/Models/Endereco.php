<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    protected $table = 'tbl_endereco';
    protected $primaryKey = 'id_endereco';
    
    protected $fillable = [
    'id_cliente_fk',
    'nome_endereco',
    'cep_endereco',
    'rua_endereco',
    'numero_endereco',
    'complemento_endereco',
    'ponto_referencia_endereco',
    'bairro_endereco',
    'cidade_endereco',
];

}

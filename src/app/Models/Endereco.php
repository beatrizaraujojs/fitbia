<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    use HasFactory;

    protected $table = 'tbl_endereco';
    protected $primaryKey = 'id_endereco';
    public $timestamps = true; 
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

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente_fk', 'id_cliente');
    }
}
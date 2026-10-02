<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Cliente extends Authenticatable
{
    use HasApiTokens;

    protected $table = 'tbl_cliente';
    protected $primaryKey = 'id_cliente';
    public $timestamps = true;

    protected $fillable = [
        'nome_cliente',
        'email_cliente',
        'senha_cliente',
        'whatsapp_cliente',
        'cpf_cliente',
        'data_nascimento',
        'status_cliente',
    ];

    protected $hidden = [
        'senha_cliente',
    ];

    protected $casts = [
        'data_nascimento' => 'date',
    ];

    public function getAuthPassword()
    {
        return $this->senha_cliente;
    }
}
<?php

namespace App\Models;

// Mudamos de Model para Authenticatable para habilitar o Login nesta tabela
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; // <--- 1. Importa o trait do Sanctum

class Cliente extends Authenticatable
{
    use HasApiTokens, Notifiable; // <--- 2. Adiciona o HasApiTokens aqui

    protected $table = 'tbl_cliente';
    protected $primaryKey = 'id_cliente';
    public $timestamps = true;

    protected $fillable = [
        'nome_cliente',
        'email_cliente',
        'senha_cliente',
        'foto_cliente',
        'whatsapp_cliente',
        'cpf_cliente',
        'data_nascimento',
        'status_cliente',
    ];

    // Ocultar a senha ao retornar JSON
    protected $hidden = [
        'senha_cliente',
    ];

    protected $casts = [
        'data_nascimento' => 'date',
    ];

    // Avisa o Laravel que o campo de senha no seu banco tem um nome diferente
    public function getAuthPassword()
    {
        return $this->senha_cliente;
    }
}
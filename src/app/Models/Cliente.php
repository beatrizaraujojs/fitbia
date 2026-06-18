<?php

namespace App\Models;

// Mudamos de Model para Authenticatable para habilitar o Login nesta tabela
use Illuminate\Foundation\Auth\User as Authenticatable; 
use Illuminate\Notifications\Notifiable;

class Cliente extends Authenticatable
{
    use Notifiable;

    // Avisa o Laravel qual é a tabela real do banco
    protected $table = 'tbl_cliente';
    
    // Avisa qual é a chave primária (já que não é o padrão 'id')
    protected $primaryKey = 'id_cliente';

    // Os campos que podem ser preenchidos no cadastro
    protected $fillable = [
        'nome_cliente',
        'email_cliente',
        'senha_cliente',
        'whatsapp_cliente',
        'cpf_cliente',
        'data_nascimento',
        'status_cliente'
    ];

    // Avisa o Laravel que o campo de senha no seu banco tem um nome diferente
    public function getAuthPassword()
    {
        return $this->senha_cliente;
    }
}
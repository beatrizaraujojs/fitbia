<?php

namespace App\Models;

// Trocamos o Model comum pelo Model de Autenticação do Laravel
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    // Informa o nome correto da tabela
    protected $table = 'tbl_usuario';

    // Informa qual é a chave primária (MUITO IMPORTANTE para o login funcionar)
    protected $primaryKey = 'id_usuario'; 

    protected $fillable = [
        'nome_usuario', 
        'email_usuario', 
        'senha_usuario', 
        'nivel_acesso_usuario', 
        'status_usuario'
    ];

    // Oculta a senha por segurança quando buscar no banco
    protected $hidden = [
        'senha_usuario',
    ];

    // Ensina o Laravel que a coluna da senha se chama 'senha_usuario' e não 'password'
    public function getAuthPassword()
    {
        return $this->senha_usuario;
    }
}
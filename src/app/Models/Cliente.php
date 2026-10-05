<?php
 
namespace App\Models;
<<<<<<< HEAD

=======
 
>>>>>>> a757d20 (feat: atualizacoes na home e controller)
// Mudamos de Model para Authenticatable para habilitar o Login nesta tabela
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; // <--- 1. Importa o trait do Sanctum
<<<<<<< HEAD

class Cliente extends Authenticatable
{
    use HasApiTokens, Notifiable; // <--- 2. Adiciona o HasApiTokens aqui

=======
 
class Cliente extends Authenticatable
{
    use HasApiTokens, Notifiable; // <--- 2. Adiciona o HasApiTokens aqui
 
    // Avisa o Laravel qual é a tabela real do banco
>>>>>>> a757d20 (feat: atualizacoes na home e controller)
    protected $table = 'tbl_cliente';
   
    // Avisa qual é a chave primária (já que não é o padrão 'id')
    protected $primaryKey = 'id_cliente';
 
    // Os campos que podem ser preenchidos no cadastro
    protected $fillable = [
        'nome_cliente',
        'email_cliente',
        'senha_cliente',
        'foto_cliente',
        'whatsapp_cliente',
        'cpf_cliente',
        'data_nascimento',
        'status_cliente'
    ];
<<<<<<< HEAD

=======
 
>>>>>>> a757d20 (feat: atualizacoes na home e controller)
    // Ocultar a senha ao retornar JSON
    protected $hidden = [
        'senha_cliente',
    ];
<<<<<<< HEAD

    protected $casts = [
        'data_nascimento' => 'date',
    ];

=======
 
>>>>>>> a757d20 (feat: atualizacoes na home e controller)
    // Avisa o Laravel que o campo de senha no seu banco tem um nome diferente
    public function getAuthPassword()
    {
        return $this->senha_cliente;
    }
}
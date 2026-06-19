<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    // Nome exato da tabela na base de dados
    protected $table = 'tbl_pedido';
    
    // Nome exato da chave primária
    protected $primaryKey = 'id_pedido';
    
    // Colunas que podem ser preenchidas em massa
    protected $fillable = [
        'id_cliente_fk',
        'id_endereco_fk',
        'id_cupom_fk',
        'forma_pagamento_pedido',
        'status_pedido',
        'valor_total_pedido',
        'troco_para_pedido',
        'observacoes_pedido',
    ];

    // Relacionamento: Um pedido tem muitos itens
    public function itens()
    {
        return $this->hasMany(ItemPedido::class, 'id_pedido_fk', 'id_pedido');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente_fk', 'id_cliente');
    }
}
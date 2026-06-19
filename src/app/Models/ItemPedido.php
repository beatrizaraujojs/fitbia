<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemPedido extends Model
{
    protected $table = 'tbl_item_pedido';
    
    protected $primaryKey = 'id_item_pedido';
    
    protected $fillable = [
        'id_pedido_fk',
        'id_produto_fk',
        'quantidade_item',
        'preco_unitario_item',
    ];

    // Relacionamento: Um item de pedido pode ter vários adicionais
    public function adicionais()
    {
        return $this->hasMany(ItemPedidoAdicional::class, 'id_item_pedido_fk', 'id_item_pedido');
    }

    // Relacionamento: Este item pertence a um Produto (para saberes o nome do prato)
    public function produto()
    {
        return $this->belongsTo(Produto::class, 'id_produto_fk', 'id_produto');
    }
}
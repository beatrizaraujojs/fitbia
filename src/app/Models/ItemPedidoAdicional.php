<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemPedidoAdicional extends Model
{
    protected $table = 'tbl_item_pedido_adicional';
    
    protected $primaryKey = 'id_item_pedido_adicional'; 
    
    protected $fillable = [
        'id_item_pedido_fk',
        'id_adicional_fk',
        'preco_cobrado_add',
    ];

    // Relacionamento: Este adicional de item pertence a um Adicional geral (para saberes o nome do adicional)
    public function adicional()
    {
        return $this->belongsTo(Adicional::class, 'id_adicional_fk', 'id_adicional');
    }
}
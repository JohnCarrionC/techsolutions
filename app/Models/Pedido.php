<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $table = 'pedidos';

    protected $fillable = ['cliente', 'total', 'estado'];

    protected $casts = ['total' => 'float'];

    public function detalles()
    {
        return $this->hasMany(DetallePedido::class);
    }
}

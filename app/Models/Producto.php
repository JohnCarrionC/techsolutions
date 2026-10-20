<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'productos';

    protected $fillable = ['sku', 'nombre', 'categoria', 'precio', 'stock', 'stock_minimo'];

    protected $casts = ['precio' => 'float'];

    public function detalles()
    {
        return $this->hasMany(DetallePedido::class);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Producto;

class DashboardController extends Controller
{
    public function index()
    {
        $productos = Producto::orderBy('nombre')->get();

        return view('dashboard', [
            'totalProductos' => $productos->count(),
            'alertas'        => $productos->filter(fn ($p) => $p->stock <= $p->stock_minimo)->count(),
            'totalPedidos'   => Pedido::count(),
        ]);
    }
}

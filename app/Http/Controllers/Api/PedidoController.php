<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DetallePedido;
use App\Models\Pedido;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{
    public function index()
    {
        return response()->json(
            Pedido::withCount('detalles')->latest()->take(10)->get()
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'cliente'             => 'required|string|max:255',
            'items'               => 'required|array|min:1',
            'items.*.producto_id' => 'required|integer|exists:productos,id',
            'items.*.cantidad'    => 'required|integer|min:1',
        ]);

        // Unificar líneas repetidas del mismo producto
        $lineas = [];
        foreach ($data['items'] as $item) {
            $id = (int) $item['producto_id'];
            $lineas[$id] = ($lineas[$id] ?? 0) + (int) $item['cantidad'];
        }

        try {
            $pedido = DB::transaction(function () use ($data, $lineas) {
                $pedido = Pedido::create([
                    'cliente' => $data['cliente'],
                    'total'   => 0,
                    'estado'  => 'completado',
                ]);

                $total = 0;

                foreach ($lineas as $productoId => $cantidad) {
                    $producto = Producto::lockForUpdate()->findOrFail($productoId);

                    if ($producto->stock < $cantidad) {
                        throw new \RuntimeException(
                            "Stock insuficiente para {$producto->nombre} (disponible: {$producto->stock})."
                        );
                    }

                    $producto->decrement('stock', $cantidad);

                    $subtotal = $producto->precio * $cantidad;
                    $total += $subtotal;

                    DetallePedido::create([
                        'pedido_id'       => $pedido->id,
                        'producto_id'     => $producto->id,
                        'cantidad'        => $cantidad,
                        'precio_unitario' => $producto->precio,
                        'subtotal'        => $subtotal,
                    ]);
                }

                $pedido->update(['total' => $total]);

                return $pedido;
            });
        } catch (\RuntimeException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }

        return response()->json($pedido->load('detalles'), 201);
    }
}

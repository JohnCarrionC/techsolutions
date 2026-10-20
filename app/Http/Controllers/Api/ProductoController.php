<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index()
    {
        return response()->json(Producto::orderBy('nombre')->get());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'sku'          => 'required|string|unique:productos,sku',
            'nombre'       => 'required|string|max:255',
            'categoria'    => 'nullable|string|max:100',
            'precio'       => 'required|numeric|min:0',
            'stock'        => 'required|integer|min:0',
            'stock_minimo' => 'required|integer|min:0',
        ]);

        return response()->json(Producto::create($data), 201);
    }

    public function update(Request $request, Producto $producto)
    {
        $data = $request->validate([
            'nombre'       => 'sometimes|string|max:255',
            'categoria'    => 'nullable|string|max:100',
            'precio'       => 'sometimes|numeric|min:0',
            'stock'        => 'sometimes|integer|min:0',
            'stock_minimo' => 'sometimes|integer|min:0',
        ]);

        $producto->update($data);

        return response()->json($producto);
    }

    public function destroy(Producto $producto)
    {
        $producto->delete();

        return response()->json(['ok' => true]);
    }
}

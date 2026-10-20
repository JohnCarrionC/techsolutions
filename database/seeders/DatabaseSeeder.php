<?php

namespace Database\Seeders;

use App\Models\Producto;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'nombre'   => 'Administrador',
            'email'    => 'admin@techsolutions.com',
            'password' => 'password123', // se encripta automáticamente (cast hashed)
        ]);

        $productos = [
            ['TS-LAP-001', 'Laptop Lenovo ThinkPad E14', 'Laptops',     3299.00, 15, 5],
            ['TS-LAP-002', 'Laptop HP ProBook 450',      'Laptops',     2899.00,  4, 5],
            ['TS-MON-001', 'Monitor Dell 24" Full HD',   'Monitores',    649.00, 30, 8],
            ['TS-TEC-001', 'Teclado mecánico Logitech',  'Periféricos',  259.00, 50, 10],
            ['TS-MOU-001', 'Mouse inalámbrico Logitech', 'Periféricos',   89.00,  3, 10],
            ['TS-SSD-001', 'SSD Kingston 1TB NVMe',      'Almacenamiento',329.00, 22, 6],
            ['TS-RAM-001', 'Memoria RAM DDR4 16GB',      'Componentes',  189.00, 12, 6],
            ['TS-ROU-001', 'Router TP-Link AX3000',      'Redes',        279.00,  6, 6],
        ];

        foreach ($productos as [$sku, $nombre, $cat, $precio, $stock, $min]) {
            Producto::create([
                'sku' => $sku, 'nombre' => $nombre, 'categoria' => $cat,
                'precio' => $precio, 'stock' => $stock, 'stock_minimo' => $min,
            ]);
        }
    }
}

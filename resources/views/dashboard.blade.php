<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>TechSolutions WMS · Panel</title>
    <style>
        *{box-sizing:border-box;margin:0;padding:0}
        body{font-family:system-ui,-apple-system,Segoe UI,Roboto,sans-serif;background:#f1f5f9;color:#0f172a}
        .topbar{background:#0f172a;color:#fff;padding:14px 24px;display:flex;justify-content:space-between;align-items:center}
        .topbar h1{font-size:18px}
        .topbar .user{display:flex;align-items:center;gap:14px;font-size:14px;color:#cbd5e1}
        .btn-logout{background:#dc2626;color:#fff;border:0;padding:8px 14px;border-radius:8px;cursor:pointer;font-weight:600}
        .btn-logout:hover{background:#b91c1c}
        .wrap{max-width:1200px;margin:24px auto;padding:0 20px}
        .stats{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:16px;margin-bottom:24px}
        .stat{background:#fff;border-radius:12px;padding:18px;box-shadow:0 1px 3px rgba(0,0,0,.08)}
        .stat small{color:#64748b;font-size:13px}
        .stat b{display:block;font-size:28px;margin-top:6px}
        .stat.warn b{color:#dc2626}
        .grid{display:grid;grid-template-columns:2fr 1fr;gap:20px}
        @media(max-width:900px){.grid{grid-template-columns:1fr}}
        .panel{background:#fff;border-radius:12px;padding:20px;box-shadow:0 1px 3px rgba(0,0,0,.08);margin-bottom:20px}
        .panel h2{font-size:16px;margin-bottom:14px}
        table{width:100%;border-collapse:collapse;font-size:14px}
        th{text-align:left;color:#64748b;font-weight:600;padding:8px;border-bottom:1px solid #e2e8f0}
        td{padding:9px 8px;border-bottom:1px solid #f1f5f9}
        .badge{padding:3px 9px;border-radius:99px;font-size:12px;font-weight:600}
        .ok{background:#dcfce7;color:#166534}
        .low{background:#fee2e2;color:#991b1b}
        .alert{background:#fef2f2;border-left:4px solid #dc2626;padding:10px 12px;border-radius:6px;margin-bottom:8px;font-size:13px}
        .alert.none{background:#f0fdf4;border-color:#16a34a}
        label{font-size:13px;font-weight:600;color:#334155;display:block;margin:10px 0 5px}
        input,select{width:100%;padding:9px 10px;border:1px solid #cbd5e1;border-radius:8px;font-size:14px}
        .row{display:flex;gap:8px}
        .btn{background:#2563eb;color:#fff;border:0;padding:10px 14px;border-radius:8px;cursor:pointer;font-weight:600;font-size:14px}
        .btn:hover{background:#1d4ed8}
        .btn.sec{background:#e2e8f0;color:#0f172a}
        .btn.full{width:100%;margin-top:14px}
        .cart-item{display:flex;justify-content:space-between;align-items:center;font-size:13px;padding:6px 0;border-bottom:1px dashed #e2e8f0}
        .cart-item button{background:none;border:0;color:#dc2626;cursor:pointer;font-size:16px}
        .total{font-weight:700;text-align:right;margin-top:10px}
        #msg{margin-top:12px;font-size:13px;padding:9px 11px;border-radius:8px;display:none}
        #msg.ok{background:#dcfce7;color:#166534;display:block}
        #msg.err{background:#fee2e2;color:#991b1b;display:block}
        .live{font-size:12px;color:#16a34a}
    </style>
</head>
<body>
    <div class="topbar">
        <h1>📦 TechSolutions WMS</h1>
        <div class="user">
            <span>{{ auth()->user()->nombre }}</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">Cerrar sesión</button>
            </form>
        </div>
    </div>

    <div class="wrap">
        <div class="stats">
            <div class="stat"><small>Productos</small><b id="st-prod">{{ $totalProductos }}</b></div>
            <div class="stat warn"><small>Alertas de stock bajo</small><b id="st-alert">{{ $alertas }}</b></div>
            <div class="stat"><small>Pedidos procesados</small><b id="st-ped">{{ $totalPedidos }}</b></div>
            <div class="stat"><small>Unidades en inventario</small><b id="st-uni">–</b></div>
        </div>

        <div class="grid">
            <div>
                <div class="panel">
                    <h2>Stock en tiempo real <span class="live">● actualizando cada 5 s</span></h2>
                    <table>
                        <thead><tr><th>SKU</th><th>Producto</th><th>Precio</th><th>Stock</th><th>Estado</th></tr></thead>
                        <tbody id="tabla"></tbody>
                    </table>
                </div>
                <div class="panel">
                    <h2>Últimos pedidos</h2>
                    <table>
                        <thead><tr><th>#</th><th>Cliente</th><th>Líneas</th><th>Total</th><th>Fecha</th></tr></thead>
                        <tbody id="pedidos"></tbody>
                    </table>
                </div>
            </div>

            <div>
                <div class="panel">
                    <h2>🔔 Alertas automáticas</h2>
                    <div id="alertas"></div>
                </div>

                <div class="panel">
                    <h2>🧾 Terminal de pedidos</h2>
                    <label>Cliente</label>
                    <input id="cliente" placeholder="Nombre del cliente">

                    <label>Producto</label>
                    <select id="sel-prod"></select>

                    <label>Cantidad</label>
                    <div class="row">
                        <input id="cant" type="number" min="1" value="1">
                        <button class="btn sec" type="button" onclick="agregar()">Agregar</button>
                    </div>

                    <div id="carrito" style="margin-top:14px"></div>
                    <div class="total" id="total"></div>

                    <button class="btn full" type="button" onclick="procesar()">Procesar pedido</button>
                    <div id="msg"></div>
                </div>
            </div>
        </div>
    </div>

<script>
const csrf = document.querySelector('meta[name="csrf-token"]').content;
const headers = {'Content-Type':'application/json','Accept':'application/json','X-CSRF-TOKEN':csrf};
const money = n => 'S/ ' + Number(n).toLocaleString('es-PE',{minimumFractionDigits:2,maximumFractionDigits:2});
let productos = [];
let carrito = [];

async function cargar() {
    try {
        const [rp, rd] = await Promise.all([
            fetch('/api/productos',{headers}), fetch('/api/pedidos',{headers})
        ]);
        if (rp.status === 401 || rp.status === 419) { location.reload(); return; }
        productos = await rp.json();
        const pedidos = await rd.json();
        pintarProductos();
        pintarPedidos(pedidos);
    } catch (e) { console.error(e); }
}

function pintarProductos() {
    const bajos = productos.filter(p => p.stock <= p.stock_minimo);

    document.getElementById('tabla').innerHTML = productos.map(p => `
        <tr>
            <td>${p.sku}</td><td>${p.nombre}</td><td>${money(p.precio)}</td>
            <td><b>${p.stock}</b></td>
            <td><span class="badge ${p.stock <= p.stock_minimo ? 'low' : 'ok'}">${p.stock <= p.stock_minimo ? 'Stock bajo' : 'OK'}</span></td>
        </tr>`).join('');

    document.getElementById('alertas').innerHTML = bajos.length
        ? bajos.map(p => `<div class="alert"><b>${p.nombre}</b><br>Quedan ${p.stock} uds. (mínimo ${p.stock_minimo})</div>`).join('')
        : '<div class="alert none">Todo el inventario está en niveles normales.</div>';

    document.getElementById('st-prod').textContent = productos.length;
    document.getElementById('st-alert').textContent = bajos.length;
    document.getElementById('st-uni').textContent = productos.reduce((s,p)=>s+p.stock,0);

    const sel = document.getElementById('sel-prod');
    const actual = sel.value;
    sel.innerHTML = productos.map(p => `<option value="${p.id}" ${p.stock===0?'disabled':''}>${p.nombre} (stock: ${p.stock})</option>`).join('');
    if (actual) sel.value = actual;
}

function pintarPedidos(lista) {
    document.getElementById('st-ped').textContent = lista.length >= 10 ? '10+' : lista.length;
    document.getElementById('pedidos').innerHTML = lista.length ? lista.map(p => `
        <tr><td>${p.id}</td><td>${p.cliente}</td><td>${p.detalles_count}</td><td>${money(p.total)}</td>
        <td>${new Date(p.created_at).toLocaleString('es-PE')}</td></tr>`).join('')
        : '<tr><td colspan="5" style="color:#64748b">Aún no hay pedidos.</td></tr>';
}

function agregar() {
    const id = parseInt(document.getElementById('sel-prod').value);
    const cant = parseInt(document.getElementById('cant').value);
    if (!id || !cant || cant < 1) return;
    const prod = productos.find(p => p.id === id);
    const ya = carrito.find(i => i.producto_id === id);
    const nuevaCant = (ya ? ya.cantidad : 0) + cant;
    if (nuevaCant > prod.stock) { mostrar('Stock insuficiente para ' + prod.nombre, false); return; }
    if (ya) ya.cantidad = nuevaCant;
    else carrito.push({producto_id: id, cantidad: cant});
    document.getElementById('cant').value = 1;
    mostrar('', true, true);
    pintarCarrito();
}

function quitar(id) { carrito = carrito.filter(i => i.producto_id !== id); pintarCarrito(); }

function pintarCarrito() {
    let total = 0;
    document.getElementById('carrito').innerHTML = carrito.map(i => {
        const p = productos.find(x => x.id === i.producto_id);
        total += p.precio * i.cantidad;
        return `<div class="cart-item"><span>${i.cantidad} × ${p.nombre}</span>
                <span>${money(p.precio*i.cantidad)} <button onclick="quitar(${i.producto_id})">×</button></span></div>`;
    }).join('');
    document.getElementById('total').textContent = carrito.length ? 'Total: ' + money(total) : '';
}

async function procesar() {
    const cliente = document.getElementById('cliente').value.trim();
    if (!cliente) return mostrar('Ingresa el nombre del cliente.', false);
    if (!carrito.length) return mostrar('Agrega al menos un producto.', false);

    const r = await fetch('/api/pedidos', {method:'POST', headers, body: JSON.stringify({cliente, items: carrito})});
    const data = await r.json();
    if (r.ok) {
        mostrar(`Pedido #${data.id} procesado. Stock actualizado.`, true);
        carrito = []; document.getElementById('cliente').value = '';
        pintarCarrito(); cargar();
    } else {
        mostrar(data.message || 'No se pudo procesar el pedido.', false);
        cargar();
    }
}

function mostrar(texto, ok, ocultar) {
    const m = document.getElementById('msg');
    if (ocultar) { m.className = ''; m.textContent = ''; return; }
    m.textContent = texto; m.className = ok ? 'ok' : 'err';
}

cargar();
setInterval(cargar, 5000);
</script>
</body>
</html>
